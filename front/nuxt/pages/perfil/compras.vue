<template>
    <h1>
        Mis compras
    </h1>

    <div v-if="clientData" class="mt-4 p-4 bg-gray-100 rounded shadow">
        <h2 class="text-lg font-semibold">Datos del cliente:</h2>
        <pre class="text-sm text-gray-700 mt-2">{{ clientData }}</pre>
    </div>

    <div v-else class="mt-4 text-gray-500">
        No se han cargado datos aún.
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useAuthStore } from '../../stores/authStore';

const { $communicationManager } = useNuxtApp();

const clientData = ref([]); // Cambiado a arreglo vacío
const authStore = useAuthStore();

async function fetchClientData() {
    const clienteId = authStore.user.id;
    const token = authStore.token;

    if (clienteId && token) {
        try {
            const compras = await $communicationManager.comprasCliente(clienteId);
            if (compras) {
                clientData.value = compras;
            } else {
                console.warn("No se encontraron compras para este cliente.");
            }
        } catch (error) {
            console.error("Error al realizar fetch de los datos del cliente:", error);
        }
    } else {
        console.error("ID de cliente o token no disponibles");
    }
}

onMounted(async () => {
    await fetchClientData();
});
</script>
