<template>
    <div v-if="show"
        class="fixed top-3/4 left-1/2 transform -translate-x-1/2 bg-white border border-gray-300 p-6 shadow-lg z-50 w-[90%] rounded-xl">
        
        <div class="flex items-center gap-4 w-full">
            <!-- Contenedor de la imagen -->
            <div id="imagenLocal" class="h-[70px] w-[70px] border-2 border-gray-500 border-solid">
                <!-- Imagen aquí -->
            </div>
            
            <!-- Contenedor de la información -->
            <div class="flex flex-col items-center w-full max-w-xs" id="infoLocal">
                <h3>{{ info.name }}</h3>

                <p v-if="info.puntaje_medio" class="text-m text-gray-600 text-right"> ⭐ {{ info.puntaje_medio }} / 5</p>

                <div class="flex w-full items-center text-center gap-5">
                    <p class="w-1/2 text-sm font-bold py-2 text-right gap-10"
                        :class="estadoLocal === 'Abierto' ? 'text-green-600' : 'text-red-600'">
                        {{ estadoLocal }}
                    </p>

                    <p class="w-1/2 text-sm text-gray-600 py-2 border-gray-300 text-left">
                        {{ horarioDelDia }}
                    </p>
                </div>

                <button @click="cerrar" id="cerrar">x</button>
                <button @click="infoDelComercio" 
                    class="mt-4 px-6 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 transition duration-200">
                    Ir al local
                </button>

            </div>
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
