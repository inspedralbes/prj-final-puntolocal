<template>
    <div ref="mapContainer" class="map-container"></div>
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
        const coordenadasVilafranca = fromLonLat([coordenadas.vilafranca.lo, coordenadas.vilafranca.la]);
        const coordenadasCastelldefels = fromLonLat([coordenadas.castelldefels.lo, coordenadas.castelldefels.la]);

        const markerVilafranca = new Feature({
            geometry: new Point(coordenadasVilafranca),
            name: coordenadas.vilafranca.name
        });

        const markerCastelldefels = new Feature({
            geometry: new Point(coordenadasCastelldefels),
            name: coordenadas.castelldefels.name
        });

        const markerStyle = new Style({
            image: new Circle({
                radius: 5,
                fill: new Fill({
                    color: 'blue'
                })
            })
        });

        markerVilafranca.setStyle(markerStyle);
        markerCastelldefels.setStyle(markerStyle);

        const vectorLayer = new VectorLayer({
            source: new VectorSource({
                features: [markerVilafranca, markerCastelldefels]
            })
        });

        const map = new Map({
            target: mapContainer.value,
            layers: [
                new TileLayer({
                    source: new OSM()
                }),
                vectorLayer
            ],
            view: new View({
                center: coordenadasVilafranca,
                zoom: 10
            })
        });

        const selectClick = new Select({
            condition: click,
        });

        map.addInteraction(selectClick);

        selectClick.on('select', (e) => {
            const selectedFeature = e.selected[0];
            if (selectedFeature) {
                const name = selectedFeature.get('name');
                alert(`¡Has seleccionado ${name}!`);
            }
        });
    });
</script>

<style scoped>
    .map-container {
        width: 100%;
        height: 400px;
    }
</style>
