<template>
    <div id="detalle-compra" class="h-screen bg-gray-100">
        <div class="container mx-auto p-6 bg-white shadow-lg rounded-lg mt-6">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">Detalls de la Compra</h1>

            <div v-if="loading" class="flex justify-center items-center">
                <Loading />
            </div>

            <div v-else-if="compra" class="space-y-6">
                <div class="flex justify-between items-center text-lg text-gray-700">
                    <p><strong>Data:</strong> {{ new Date(compra.fecha).toLocaleDateString('ca-ES') }}</p>
                    <p><strong>Total:</strong> {{ compra.total.toFixed(2) }} €</p>
                </div>

                <div class="flex items-center space-x-2">
                    <div id="colorEstado" :style="{ backgroundColor: compra.estat_compra.color }"
                        class="w-6 h-6 rounded-full border border-gray-400"></div>
                    <p>
                        <strong>Estat de la compra:</strong>
                        {{ compra.estat_id === 1 ? "Pendiente"
                            : compra.estat_id === 2 ? "Procesando"
                                : compra.estat_id === 3 ? "Enviado"
                                    : compra.estat_id === 4 ? "Entregado"
                                        : "Cancelado" }}
                    </p>
                </div>

                <div class="flex items-center justify-between">
                    <p><strong>Tipus d'enviament:</strong> {{ compra.tipo_envio_info?.nombre }}</p>
                </div>

                <h3 class="text-xl font-semibold mt-4 text-gray-700">Productes:</h3>
                <div v-for="producto in compra.productos_compra" :key="producto.id"
                    class="bg-gray-50 p-4 rounded-lg shadow-md flex items-center space-x-4 mb-4">
                    <img :src="producto.producto.imagen || 'https://via.placeholder.com/100'" alt="Imagen del producto"
                        class="w-24 h-24 object-cover rounded-md" />
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-800">{{ producto.producto.nombre }}</h4>
                        <p class="text-sm text-gray-500">{{ truncateDescription(producto.producto.descripcion) }}</p>
                        <div class="mt-2 flex justify-between items-center">
                            <span class="text-sm text-gray-500">Quantitat: {{ producto.cantidad }}</span>
                            <span class="font-bold text-blue-500">{{ producto.total.toFixed(2) }} €</span>
                        </div>
                    </div>
                </div>

                <h3 class="text-xl font-semibold mt-6 text-gray-700">JSON complet:</h3>
                <pre class="bg-gray-100 p-4 rounded-lg text-sm text-gray-600 overflow-auto">
                    {{ formattedJson }}
                </pre>
            </div>

            <div v-else>
                <p class="text-center text-gray-500">No s'ha trobat informació de la compra.</p>
            </div>
        </div>
    </div>
</template>

<script setup>
    definePageMeta({
        layout: false,
    });

    import { ref, onMounted, computed } from "vue";
    import { useRoute } from "vue-router";
    import Loading from "../../../components/loading.vue";

    const { $communicationManager } = useNuxtApp();
    const route = useRoute();
    const compra = ref(null);
    const loading = ref(true);

    const formattedJson = computed(() => {
        return compra.value ? JSON.stringify(compra.value, null, 2) : "";
    });

    // Function to truncate the description to 10 words
    const truncateDescription = (descripcion) => {
        const words = descripcion.split(' ');
        if (words.length > 10) {
            return words.slice(0, 10).join(' ') + '...';
        }
        return descripcion;
    };

    onMounted(async () => {
        const compraId = route.params.id;

        if (compraId) {
            loading.value = true;
            const response = await $communicationManager.detalleCompra(compraId);

            if (response) {
                compra.value = response;
            } else {
                console.error("No es va poder obtenir els detalls de la compra.");
            }
            loading.value = false;
        }
    });
</script>

<style scoped>
    #colorEstado {
        width: 15px;
        height: 15px;
        border-radius: 99px;
        border: 1px solid #ccc;
    }
</style>