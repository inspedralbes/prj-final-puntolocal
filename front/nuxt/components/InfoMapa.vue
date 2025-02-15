<template>
    <div v-if="show"
        class="fixed top-1/4 left-1/2 transform -translate-x-1/2 bg-white border border-gray-300 p-6 shadow-lg z-50 w-[90%] rounded-xl">
        <div class="flex flex-col items-center w-full max-w-xs">
            <h3 >{{ info.name }}</h3>
            <h3>{{ info.puntaje_medio }}</h3>
            <button @click="cerrar" id="cerrar">
                x
            </button>
            <button
                @click="infoDelComercio">
                Ir al local
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits } from 'vue';
import { useRouter } from 'vue-router';

const props = defineProps({
    info: Object
});
const emit = defineEmits(['cerrarPopup']);
const router = useRouter();
const show = ref(true);

const infoDelComercio = () => {
    if (props.info?.id) {
        router.push(`/comercio/${props.info.id}`);
    } else {
        alert("Error: No se encontró el ID del comercio.");
    }
};

const cerrar = () => {
    show.value = false;
    emit('cerrarPopup');
};
</script>

<style scoped>
    #cerrar{
        top: 0;
        right: 10px;
        color: red;
        font-weight: 900;
        font-size: 20px;
        position: absolute;
        border-radius: 1000px;
    }
</style>