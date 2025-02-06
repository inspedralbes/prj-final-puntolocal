<template>
    <div>
        <input v-model="codigoPostal" @keyup.enter="buscarPorCodigoPostal" placeholder="Introduce código postal" />
        <button @click="buscarPorCodigoPostal">Buscar</button>

        <div ref="mapContainer" class="map-container"></div>

        <div>
            <button @click="getLocation" class="px-4 py-2 bg-blue-500 text-white rounded-lg">
                Obtener Ubicación
            </button>
            <p v-if="location">Ubicación: {{ location }}</p>
        </div>

        <InfoMapa v-if="showPopup" :info="puebloSeleccionado" @cerrarPopup="cerrarPopup" />
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
import CircleGeom from 'ol/geom/Circle';
import Style from 'ol/style/Style';
import CircleStyle from 'ol/style/Circle';
import Fill from 'ol/style/Fill';
import Stroke from 'ol/style/Stroke';
import Select from 'ol/interaction/Select';
import { click } from 'ol/events/condition';
import InfoMapa from './InfoMapa.vue';

const map = ref(null);
const location = ref(null);
const codigoPostal = ref("");
const mapContainer = ref(null);
const puebloSeleccionado = ref({});
const vectorSource = ref(new VectorSource()); // Fuente para los marcadores y círculos
const showPopup = ref(false);
const API_URL = "https://nominatim.openstreetmap.org/search";

const coordenadas = {
    vilafranca: { la: 41.341365, lo: 1.690866, name: "Vilafranca del Penedès" },
    castelldefels: { la: 41.3784, lo: 2.0834, name: "Los Pollos Hermanos" }
};

onMounted(() => {
    const vectorLayer = new VectorLayer({ source: vectorSource.value });

    map.value = new Map({
        target: mapContainer.value,
        layers: [
            new TileLayer({ source: new OSM() }),
            vectorLayer
        ],
        view: new View({
            center: fromLonLat([1.690866, 41.341365]),
            zoom: 10
        })
    });

    agregarMarcadoresPredefinidos();

    const selectClick = new Select({ condition: click });
    map.value.addInteraction(selectClick);
    selectClick.on('select', (e) => {
        const selectedFeature = e.selected[0];
        if (selectedFeature) {
            const name = selectedFeature.get('name');
            const lonLat = selectedFeature.getGeometry().getCoordinates();
            const lon = lonLat[0];
            const lat = lonLat[1];

            puebloSeleccionado.value = { name, lat, lon };
            showPopup.value = true;
        }
    });
});

const agregarMarcadoresPredefinidos = () => {
    Object.values(coordenadas).forEach(({ lo, la, name }) => {
        const marker = new Feature({
            geometry: new Point(fromLonLat([lo, la])),
            name: name
        });
        marker.setStyle(
            new Style({
                image: new CircleStyle({
                    radius: 6,
                    fill: new Fill({ color: 'blue' }),
                    stroke: new Stroke({ color: 'white', width: 1 })
                })
            })
        );
        vectorSource.value.addFeature(marker);
    });
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
                zoom: 12,
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

    marker.setStyle(
        new Style({
            image: new CircleStyle({
                radius: 6,
                fill: new Fill({ color: 'red' }),
                stroke: new Stroke({ color: 'white', width: 1 })
            })
        })
    );

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

                // Centrar el mapa en la ubicación exacta
                map.value.getView().animate({
                    center: lonLat,
                    zoom: 16, // Zoom más cercano
                    duration: 1000
                });

                // Eliminar marcadores previos de ubicación del usuario
                vectorSource.value.clear();

                // Agregar un marcador rojo en la ubicación actual
                const userMarker = new Feature({
                    geometry: new Point(lonLat),
                    name: "Tu ubicación exacta"
                });

                userMarker.setStyle(
                    new Style({
                        image: new CircleStyle({
                            radius: 8,
                            fill: new Fill({ color: 'red' }),
                            stroke: new Stroke({ color: 'white', width: 2 })
                        })
                    })
                );

                vectorSource.value.addFeature(userMarker);

                // Dibujar un círculo verde con radio de 2.5 km
                const circleFeature = new Feature(
                    new CircleGeom(lonLat, 2500) // Radio en metros
                );
                
                circleFeature.setStyle(
                    new Style({
                        stroke: new Stroke({
                            color: 'green',
                            width: 2
                        }),
                        fill: new Fill({
                            color: 'rgba(0, 255, 0, 0.2)' // Transparente
                        })
                    })
                );

                vectorSource.value.addFeature(circleFeature);
            },
            (error) => {
                location.value = `Error: ${error.message}`;
            },
            {
                enableHighAccuracy: true, // Mayor precisión
                timeout: 10000, // Tiempo de espera máximo
                maximumAge: 0 // No usar datos en caché
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
.map-container {
    width: 100%;
    height: 400px;
    margin-top: 10px;
}

input {
    padding: 5px;
    margin-right: 5px;
}

button {
    padding: 5px;
    cursor: pointer;
}
</style>
