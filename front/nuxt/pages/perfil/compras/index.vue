<template>
    <div id="general">
        <div class="container mx-auto p-6">
            <h1 class="text-2xl font-bold mb-6">Mis Compras</h1>

            <div v-if="compras.length > 0">
                <div v-for="compra in compras" :key="compra.id" @click="verDetalles(compra.id)"
                    class="bg-white shadow-md rounded-lg p-4 mb-6 cursor-pointer hover:shadow-lg transition">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 text-sm">
                            Fecha: {{ new Date(compra.fecha).toLocaleDateString() }}
                        </span>
                        <span class="text-blue-500 text-sm font-semibold">
                            Total: ${{ compra.total.toFixed(2) }}
                        </span>
                    </div>
                    <div class="text-gray-700 mt-2 text-sm">
                        Tipo de envío: {{ compra.tipo_envio.nombre }}
                    </div>
                </div>
            </div>

            <div v-else class="text-gray-500 text-center">
                <p>No se encontraron compras.</p>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref, onMounted } from "vue";
    import { useRouter } from "vue-router";
    import { useAuthStore } from "../../../stores/authStore";

    const { $communicationManager } = useNuxtApp();
    const compras = ref([]);
    const authStore = useAuthStore();
    const router = useRouter();

    async function fetchCompras() {
        const clienteId = authStore.user?.id;

        if (clienteId) {
            const response = await $communicationManager.comprasCliente(clienteId);
            if (response) {
                compras.value = response;
            } else {
                console.error("Error al obtener las compras.");
            }
        }
    }

    function verDetalles(compraId) {
        router.push(`/perfil/compras/${compraId}`);
    }

    onMounted(fetchCompras);
</script>

<style>
    #general {
        height: 100vh;
    }
</style>
