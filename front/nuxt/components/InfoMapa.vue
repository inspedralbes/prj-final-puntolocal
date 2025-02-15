<template>
    <div v-if="show"
        class="fixed top-3/4 left-1/2 transform -translate-x-1/2 bg-white border border-gray-300 p-6 shadow-lg z-50 w-[90%] rounded-xl">
        <div class="flex flex-col items-center w-full max-w-xs">
            <h3>{{ info.name }}</h3>
            
            <p v-if="info.puntaje_medio" class="text-m text-gray-600"> ⭐ {{ info.puntaje_medio }} / 5</p>
            
            <p class="text-sm text-gray-600 mt-2">Horario hoy: {{ horarioDelDia }}</p>

            <button @click="cerrar" id="cerrar">
                x
            </button>
            <button @click="infoDelComercio">
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

    const obtenerDiaActual = () => {
        const dias = ["lunes", "martes", "miércoles", "jueves", "viernes", "sábado", "domingo"];
        const fecha = new Date();
        const dia = fecha.getDay();
        const diaActual = dias[dia === 0 ? 6 : dia - 1];
        return diaActual;
    };


    const horarioDelDia = computed(() => {
        console.log("Horario completo del comercio:", props.info.horario);
        if (props.info.horario) {
            const diaActual = obtenerDiaActual();
            console.log("Día actual:", diaActual);
            console.log("Horario del local:", props.info.horario);
            
            return props.info.horario?.[diaActual] || 'Cerrado';
        }
        return 'No disponible';
    });


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
