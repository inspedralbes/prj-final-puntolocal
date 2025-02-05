<template>
    <div v-if="show" class="popup">
        <div class="popup-content">
            <h3>{{ info.name }}</h3>
            <p>Latitud: {{ info.lat }}</p>
            <p>Longitud: {{ info.lon }}</p>
            <button @click="cerrar">Cerrar</button>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits } from 'vue';

const props = defineProps({
    info: Object
});
const emit = defineEmits(['cerrarPopup']);

const show = ref(true);

const cerrar = () => {
    show.value = false;
    emit('cerrarPopup');
};
</script>

<style scoped>
.popup {
    position: fixed;
    top: 20%;
    left: 50%;
    transform: translateX(-50%);
    background: white;
    border: 1px solid #ccc;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

.popup-content {
    display: flex;
    flex-direction: column;
    align-items: center;
}

button {
    margin-top: 10px;
}
</style>