<template>
    <div v-if="show"
        class="fixed top-1/4 left-1/2 transform -translate-x-1/2 bg-white border border-gray-300 p-6 shadow-lg z-50">
        <div class="flex flex-col items-center w-full max-w-xs">
            <h3 class="text-xl font-semibold mb-4">{{ info.name }}</h3>
            <p class="text-sm mb-2">Latitud: {{ info.lat }}</p>
            <p class="text-sm mb-4">Longitud: {{ info.lon }}</p>
            <button @click="cerrar"
                class="mt-2 w-full px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition duration-300">
                Cerrar
            </button>
            <button
                class="mt-2 w-full px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-300"
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