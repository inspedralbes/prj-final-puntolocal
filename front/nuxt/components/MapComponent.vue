<template>
    <div>
        <input 
            v-model="codigoPostal" 
            @keyup.enter="buscarPorCodigoPostal" 
            placeholder="Introduce código postal" 
        />
        <button @click="buscarPorCodigoPostal">Buscar</button>
        <div ref="mapContainer" class="map-container"></div>
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
import Circle from 'ol/style/Circle';
import Fill from 'ol/style/Fill';
import Stroke from 'ol/style/Stroke';
import Select from 'ol/interaction/Select';
import { click } from 'ol/events/condition';

const mapContainer = ref(null);
const map = ref(null);
const vectorSource = ref(new VectorSource());
const codigoPostal = ref("");
const puebloSeleccionado = ref("");
const API_URL = "https://nominatim.openstreetmap.org/search"; // URL de Nominatim

// Coordenadas predefinidas
const coordenadas = {
    vilafranca: {
        la: 41.341365,
        lo: 1.690866,
        name: "Vilafranca del Penedès"
    },
    castelldefels: {
        la: 41.3784,
        lo: 2.0834,
        name: "Castelldefels"
    }
};

onMounted(() => {
    const vectorLayer = new VectorLayer({ source: vectorSource.value });

    // Inicializar el mapa con OpenLayers
    map.value = new Map({
        target: mapContainer.value,
        layers: [
            new TileLayer({ source: new OSM() }),
            vectorLayer
        ],
        view: new View({
            center: fromLonLat([1.690866, 41.341365]), // Centro inicial
            zoom: 10
        })
    });

    // Agregar los marcadores predefinidos
    agregarMarcadoresPredefinidos();

    // Permitir clics en los puntos
    const selectClick = new Select({ condition: click });
    map.value.addInteraction(selectClick);
    selectClick.on('select', (e) => {
        const selectedFeature = e.selected[0];
        if (selectedFeature) {
            alert(`¡Has seleccionado ${selectedFeature.get('name')}!`);
        }
    });
});

// Función para agregar los marcadores predefinidos al mapa
const agregarMarcadoresPredefinidos = () => {
    Object.values(coordenadas).forEach(({ lo, la, name }) => {
        const marker = new Feature({
            geometry: new Point(fromLonLat([lo, la])),
            name: name
        });
        marker.setStyle(
            new Style({
                image: new Circle({
                    radius: 6,
                    fill: new Fill({ color: 'blue' }),
                    stroke: new Stroke({ color: 'white', width: 1 })
                })
            })
        );
        vectorSource.value.addFeature(marker);
    });
};

// Buscar por código postal usando la API de Nominatim
const buscarPorCodigoPostal = async () => {
    if (!codigoPostal.value) {
        alert("Introduce un código postal.");
        return;
    }

    try {
        const response = await fetch(`${API_URL}?postalcode=${codigoPostal.value}&country=ES&format=json`);
        const data = await response.json();

        if (data.length > 0) {
            const ubicacion = data[0]; // Tomamos el primer resultado
            const lat = parseFloat(ubicacion.lat);
            const lon = parseFloat(ubicacion.lon);
            puebloSeleccionado.value = ubicacion.display_name;

            // Añadir marcador en el mapa
            agregarMarcador(lon, lat, puebloSeleccionado.value);

            // Mover el mapa a la nueva ubicación
            map.value.getView().animate({
                center: fromLonLat([lon, lat]),
                zoom: 12,
                duration: 1000
            });
        } else {
            puebloSeleccionado.value = "No encontrado";
            alert("No se encontró la ubicación.");
        }
    } catch (error) {
        console.error("Error en la búsqueda:", error);
        alert("Error al buscar el código postal.");
    }
};

// Función para agregar un marcador para el código postal buscado
const agregarMarcador = (lon, lat, name) => {
    const marker = new Feature({
        name: name
    });

    vectorSource.value.addFeature(marker);
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
