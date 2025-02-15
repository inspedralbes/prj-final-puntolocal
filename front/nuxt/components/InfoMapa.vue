<template>
    <div v-if="show"
        class="fixed top-3/4 left-1/2 transform -translate-x-1/2 bg-white border border-gray-300 p-6 shadow-lg z-50 w-[90%] rounded-xl">
        <div class="flex flex-col items-center w-full max-w-xs">
            <h3>{{ info.name }}</h3>

            <p v-if="info.puntaje_medio" class="text-m text-gray-600"> ⭐ {{ info.puntaje_medio }} / 5</p>

            <p class="text-sm text-gray-600 mt-2">Horario hoy: {{ horarioDelDia }}</p>
            <p class="text-sm font-bold" :class="estadoLocal === 'Abierto' ? 'text-green-600' : 'text-red-600'">
                {{ estadoLocal }}
            </p>

            <button @click="cerrar" id="cerrar">x</button>
            <button @click="infoDelComercio">Ir al local</button>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, computed } from 'vue';
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

const obtenerDiaActual = () => {
    const dias = ["lunes", "martes", "miércoles", "jueves", "viernes", "sábado", "domingo"];
    const fecha = new Date();
    const dia = fecha.getDay();
    return dias[dia === 0 ? 6 : dia - 1];
};

const horarioDelDia = computed(() => {
    if (props.info.horario) {
        const diaActual = obtenerDiaActual();
        return props.info.horario[diaActual] || 'Cerrado';
    }
    return 'No disponible';
});

const estadoLocal = computed(() => {
    if (!horarioDelDia.value || horarioDelDia.value === 'Cerrado' || horarioDelDia.value === 'No disponible') {
        return 'Cerrado';
    }

    const ahora = new Date();
    const horaActual = ahora.getHours() * 60 + ahora.getMinutes(); // Minutos desde la medianoche

    const horarioMatch = horarioDelDia.value.match(/(\d{2}):(\d{2})\s*-\s*(\d{2}):(\d{2})/);

    if (!horarioMatch) return 'Cerrado';

    const apertura = parseInt(horarioMatch[1]) * 60 + parseInt(horarioMatch[2]);
    const cierre = parseInt(horarioMatch[3]) * 60 + parseInt(horarioMatch[4]);

    return horaActual >= apertura && horaActual <= cierre ? 'Abierto' : 'Cerrado';
});

const cerrar = () => {
    show.value = false;
    emit('cerrarPopup');
};
</script>

<style scoped>
#cerrar {
    top: 0;
    right: 10px;
    color: red;
    font-weight: 900;
    font-size: 20px;
    position: absolute;
    border-radius: 1000px;
}
</style>
