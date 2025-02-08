<template>
    <div ref="mapContainer" class="map-container" style="height: 100%;"></div>
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

const mapContainer = ref(null);

onMounted(() => {
    // Definir la vista del mapa con un centro y un zoom
    const mapView = new View({
        center: fromLonLat([-0.1276, 51.5074]), // Coordenadas para Londres
        zoom: 10, // Nivel de zoom
    });

    // Capa base con OpenStreetMap
    const baseLayer = new TileLayer({
        source: new OSM(),
    });

    // Crear un punto de ejemplo en las coordenadas [-0.1276, 51.5074] (Londres)
    const pointFeature = new Feature({
        geometry: new Point(fromLonLat([-0.1276, 51.5074])),
    });

    // Estilo para el punto
    pointFeature.setStyle(
        new Style({
            image: new CircleStyle({
                radius: 10,
                fill: new Fill({ color: 'red' }),
                stroke: new Stroke({ color: 'white', width: 2 }),
            }),
        })
    );

    // Fuente y capa vectorial
    const vectorSource = new VectorSource({
        features: [pointFeature],
    });

    const vectorLayer = new VectorLayer({
        source: vectorSource,
    });

    // Crear el mapa con la vista y las capas
    const map = new Map({
        target: mapContainer.value,
        layers: [baseLayer, vectorLayer],
        view: mapView,
    });

    // Interacción para seleccionar objetos con un click
    const selectInteraction = new Select({
        condition: click,
    });
    map.addInteraction(selectInteraction);
});
</script>

<style scoped>
.map-container {
    width: 100%;
    height: 400px;
}
</style>
