<template>
    <div>
        <input v-model="codigoPostal" @keyup.enter="buscarPorCodigoPostal" placeholder="Introduce código postal" />
        <button @click="buscarPorCodigoPostal">Buscar</button>

        <div ref="mapContainer" class="map-container"></div>

        <div>
            <button @click="getLocation" class="px-4 py-2 bg-blue-500 text-white rounded-lg">
                Ver tiendas cerca de mí
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
            new TileLayer({ source: new OSM() }),
            vectorLayer
        ],
        view: new View({
            center: fromLonLat([1.690866, 41.341365]),
            zoom: 10
        })
    });

    await agregarMarcadoresDesdeResponse();

    const selectClick = new Select({ condition: click });
    map.value.addInteraction(selectClick);
    selectClick.on('select', (e) => {
        const selectedFeature = e.selected[0];
        if (selectedFeature) {
            const id = selectedFeature.get('id');
            const name = selectedFeature.get('name');
            const lonLat = selectedFeature.getGeometry().getCoordinates();
            const lon = lonLat[0];
            const lat = lonLat[1];

            puebloSeleccionado.value = { id, name, lat, lon };
            showPopup.value = true;
        }
    });
});

const agregarMarcadoresDesdeResponse = async () => {
    try {
        const response = await $communicationManager.getLocations();

        response.forEach(({ id, latitude, longitude, nombre }) => {
            if (!isNaN(latitude) && !isNaN(longitude)) {
                const marker = new Feature({
                    geometry: new Point(fromLonLat([longitude, latitude])),
                    id: id,
                    name: nombre
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

                const userMarker = new Feature({
                    geometry: new Point(lonLat),
                    name: "Tu ubicación exacta",
                    userLocation: true
                });

                vectorSource.value.addFeature(userMarker);
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
