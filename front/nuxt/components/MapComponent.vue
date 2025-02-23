<template>
    <div>
        <!-- Botón Retroceder (GoBack) visible solo cuando showPopup es falso -->
        <div v-if="!showPopup" @click="goBack" class="text-xl text-gray-700 dark:text-gray-300 cursor-pointer"
            id="retrocederBtn">
            <svg width="1.5em" height="1.5em" viewBox="0 0 1024 1024" class="icon" xmlns="http://www.w3.org/2000/svg"
                fill="#000000">
                <g id="SVGRepo_iconCarrier">
                    <path fill="#000000" d="M224 480h640a32 32 0 110 64H224a32 32 0 010-64z"></path>
                    <path fill="#000000"
                        d="M237.248 512l265.408 265.344a32 32 0 01-45.312 45.312l-288-288a32 32 0 010-45.312l288-288a32 32 0 1145.312 45.312L237.248 512z">
                    </path>
                </g>
            </svg>
        </div>

        <!-- Buscador -->
        <div id="divBuscador">
            <input v-model="codigoPostal" @keyup.enter="buscarPorCodigoPostal" placeholder="Código Postal" />
            <button @click="buscarPorCodigoPostal" id="buscar">
                <img src="../assets/lupa-white.svg" alt="Lupa" />
            </button>
        </div>

        <!-- Contenedor del mapa visible siempre -->
        <div ref="mapContainer" class="map-container"></div>

        <!-- Botón GetLocation visible solo cuando showPopup es falso -->
        <div v-if="!showPopup">
            <button @click="getLocation" id="btnLocation">
                <img src="../assets/location.svg" alt="Location">
            </button>
        </div>

        <!-- Componente InfoMapa visible solo cuando showPopup es verdadero -->
        <InfoMapa v-if="showPopup" :info="puebloSeleccionado" @cerrarPopup="cerrarPopup" id="infoMapa" />
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import 'ol/ol.css';
import Map from 'ol/Map';
import View from 'ol/View';
import TileLayer from 'ol/layer/Tile';
import OSM from 'ol/source/OSM';
import { fromLonLat } from 'ol/proj';
import VectorLayer from 'ol/layer/Vector';
import VectorSource from 'ol/source/Vector';
import Feature from 'ol/Feature';
import Point from 'ol/geom/Point';
import Style from 'ol/style/Style';
import { Fill, Stroke, Circle as CircleStyle, Text } from "ol/style";
import Select from 'ol/interaction/Select';
import XYZ from 'ol/source/XYZ';  // Asegúrate de que esta línea esté presente
import MVT from 'ol/format/MVT';
import VectorTileSource from 'ol/source/VectorTile';
import { click } from 'ol/events/condition';
import InfoMapa from './InfoMapa.vue';
import { useRouter } from "vue-router";
import Icon from 'ol/style/Icon';
import { defaults as defaultControls } from 'ol/control';
import puntoMapaIcon from '@/assets/punto-mapa.svg';


const map = ref(null);
const router = useRouter();
const location = ref(null);
const codigoPostal = ref("");
const showPopup = ref(false);
const mapContainer = ref(null);
const puebloSeleccionado = ref({});
const vectorSource = ref(new VectorSource());
const { $communicationManager } = useNuxtApp();
const API_URL = "https://nominatim.openstreetmap.org/search";

onMounted(async () => {
    const vectorLayer = new VectorLayer({ source: vectorSource.value });

    map.value = new Map({
        target: mapContainer.value,
        layers: [
            new TileLayer({
                source: new VectorTileSource({
                    format: new MVT(),
                    url: 'https://api.maptiler.com/tiles/v3/{z}/{x}/{y}.pbf?key=TU_CLAVE',
                }),
            }),
            vectorLayer
        ],
        view: new View({
            center: fromLonLat([2.15899, 41.38879]),
            zoom: 10
        }),
        controls: defaultControls({ zoom: false })
    });

    await agregarMarcadoresDesdeResponse();

    const selectClick = new Select({
        condition: click,
        style: new Style({
            image: new CircleStyle({
                radius: 12, // Tamaño del círculo
                fill: new Fill({ color: "red" }), // Color del círculo
                stroke: new Stroke({ color: "white", width: 3 }) // Contorno
            })
        })
    });
    map.value.addInteraction(selectClick);
    selectClick.on('select', (e) => {
        const selectedFeature = e.selected[0];
        if (selectedFeature) {
            console.log(selectedFeature);
            const id = selectedFeature.get('id');
            const name = selectedFeature.get('name');
            const lonLat = selectedFeature.getGeometry().getCoordinates();
            const lon = lonLat[0];
            const lat = lonLat[1];
            const puntaje = selectedFeature.get('puntaje_medio');
            const horario = selectedFeature.get('horario');
            const calle_num = selectedFeature.get('calle_num');
            const telefon = selectedFeature.get('phone');
            const imagen = selectedFeature.get('imagen');

            puebloSeleccionado.value = { id, name, lat, lon, puntaje_medio: puntaje, horario, calle_num, telefon, imagen };
            showPopup.value = true;
        }
    });
});

const goBack = () => {
    router.back();
};

const agregarMarcadoresDesdeResponse = async () => {
    try {
        const categoria_icon = ref();
        const response = await $communicationManager.getLocations();
        console.log(response);

        response.forEach((comercio) => {
            console.log(comercio);
            if (!isNaN(comercio.latitude) && !isNaN(comercio.longitude)) {
                let horarioParseado = {};

                if (comercio.horario && typeof comercio.horario === 'string') {
                    try {
                        horarioParseado = JSON.parse(comercio.horario);
                    } catch (e) {
                        console.error('Error al parsear el horario:', e);
                    }
                }

                const marker = new Feature({
                    geometry: new Point(fromLonLat([comercio.longitude, comercio.latitude])),
                    id: comercio.id,
                    name: comercio.nombre,
                    puntaje_medio: comercio.puntaje_medio,
                    horario: horarioParseado,
                    phone: comercio.phone,
                    calle_num: comercio.calle_num,
                    categoria_id: comercio.categoria_id,
                    imagen: comercio.imagen
                });

                switch (comercio.categoria_id) {
                    case 1:
                        categoria_icon.value = "indumentaria";
                        break;
                    case 2:
                        categoria_icon.value = "tecnologia";
                        break;
                    case 3:
                        categoria_icon.value = "hogar";
                        break;
                    case 4:
                        categoria_icon.value = "cosmeticos";
                        break;
                    case 5:
                        categoria_icon.value = "jugueterias";
                        break;
                    case 6:
                        categoria_icon.value = "ferreterias";
                        break;
                    case 7:
                        categoria_icon.value = "librerias";
                        break;
                    case 8:
                        categoria_icon.value = "farmacias";
                        break;
                    case 9:
                        categoria_icon.value = "zapaterias";
                        break;
                    case 10:
                        categoria_icon.value = "floristerias";
                        break;
                    case 11:
                        categoria_icon.value = "opticas";
                        break;
                    case 12:
                        categoria_icon.value = "accesorios";
                        break;
                    case 13:
                        categoria_icon.value = "mascotas";
                        break;
                    default:
                        categoria_icon.value = 'https://imgs.search.brave.com/us8Gu30N5ILiAsZiqIrxuXbRxaJDoZ22JegunkIifwE/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9pY29u/ZXMucHJvL3dwLWNv/bnRlbnQvdXBsb2Fk/cy8yMDIxLzAyL2lj/b25lLWRlLWJyb2No/ZS1kZS1sb2NhbGlz/YXRpb24tYmxldWUu/cG5n';
                        break;
                }

                marker.setStyle(
                    new Style({
                        image: new Icon({
                            src: categoria_icon.value,
                            src: 'https://imgs.search.brave.com/us8Gu30N5ILiAsZiqIrxuXbRxaJDoZ22JegunkIifwE/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9pY29u/ZXMucHJvL3dwLWNv/bnRlbnQvdXBsb2Fk/cy8yMDIxLzAyL2lj/b25lLWRlLWJyb2No/ZS1kZS1sb2NhbGlz/YXRpb24tYmxldWUu/cG5n',
                            scale: 0.08
                        }),
                        text: new Text({
                            text: comercio.nombre, // Nombre del comercio
                            font: "bold 14px Arial",
                            fill: new Fill({ color: "#007bff" }), // Color azul
                            stroke: new Stroke({ color: "#fff", width: 3 }), // Contorno blanco
                            offsetY: 0, // Eleva el texto sobre el marcador
                            offsetX: -15,
                            textAlign: "right", // Alineación horizontal
                            textBaseline: "middle",
                        })
                    })
                );

                vectorSource.value.addFeature(marker);
            }
        });
    } catch (error) {
        console.error("Error obteniendo ubicaciones:", error);
    }
};

const buscarPorCodigoPostal = async () => {
    if (!codigoPostal.value) {
        alert("Introduce un código postal.");
        return;
    }

    try {
        const response = await fetch(`${API_URL}?postalcode=${codigoPostal.value}&country=ES&format=json`);
        const data = await response.json();

        if (data.length > 0) {
            const ubicacion = data[0];
            const lat = parseFloat(ubicacion.lat);
            const lon = parseFloat(ubicacion.lon);
            puebloSeleccionado.value = {
                name: ubicacion.display_name,
                lat,
                lon
            };

            agregarMarcador(lon, lat, puebloSeleccionado.value.name);

            map.value.getView().animate({
                center: fromLonLat([lon, lat]),
                zoom: 14,
                duration: 1000
            });
        } else {
            alert("No se encontró la ubicación.");
        }
    } catch (error) {
        console.error("Error en la búsqueda:", error);
        alert("Error al buscar el código postal.");
    }
};

const agregarMarcador = (lon, lat, name) => {
    const marker = new Feature({
        geometry: new Point(fromLonLat([lon, lat])),
        name: name
    });

    vectorSource.value.addFeature(marker);
};

const getLocation = () => {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;
                location.value = `Lat: ${lat}, Lng: ${lon}`;

                const lonLat = fromLonLat([lon, lat]);

                map.value.getView().animate({
                    center: lonLat,
                    zoom: 16,
                    duration: 1000
                });

                vectorSource.value.getFeatures().forEach(feature => {
                    if (feature.get('userLocation')) {
                        vectorSource.value.removeFeature(feature);
                    }
                });
            },
            (error) => {
                location.value = `Error: ${error.message}`;
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    } else {
        location.value = 'La geolocalización no es compatible con este navegador.';
    }
};

const cerrarPopup = () => {
    showPopup.value = false;
};
</script>

<style scoped>
@import '@/assets/mapa.css';
</style>