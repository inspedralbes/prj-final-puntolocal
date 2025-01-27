<template>
    <div id="detalle-compra" class="h-screen bg-gray-100">
        <div class="container mx-auto p-6 bg-white shadow-lg rounded-lg mt-6">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">Detalls de la Compra</h1>

            <div v-if="compra" class="space-y-6">
                <!-- Fecha y Precio total -->
                <div class="flex justify-between items-center text-lg text-gray-700">
                    <p><strong>Data:</strong> {{ new Date(compra.fecha).toLocaleDateString('ca-ES') }}</p>
                    <p><strong>Total:</strong> {{ compra.total.toFixed(2) }} €</p>
                </div>

                <!-- Tipo de Envío -->
                <div class="flex items-center justify-between">
                    <p><strong>Tipus d'enviament:</strong> {{ compra.tipo_envio_info?.nombre }}</p>
                </div>

                <!-- Productos -->
                <h3 class="text-xl font-semibold mt-4 text-gray-700">Productes:</h3>
                <div v-for="producto in compra.productos_compra" :key="producto.id"
                    class="bg-gray-50 p-4 rounded-lg shadow-md flex items-center space-x-4 mb-4">
                    <!-- Imagen del producto (si existe) -->
                    <img :src="producto.producto.imagen || 'https://via.placeholder.com/100'" alt="Imagen del producto"
                        class="w-24 h-24 object-cover rounded-md" />
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-800">{{ producto.producto.nombre }}</h4>
                        <p class="text-sm text-gray-500">{{ producto.producto.descripcion }}</p>
                        <div class="mt-2 flex justify-between items-center">
                            <span class="font-bold text-blue-500">{{ producto.total.toFixed(2) }} €</span>
                            <span class="text-sm text-gray-500">Quantitat: {{ producto.cantidad }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <div v-else>
                <p class="text-center text-gray-500">Cargando...</p>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref, onMounted } from "vue";
    import { useRoute } from "vue-router";
    import { useAuthStore } from "@/stores/authStore";

    const { $communicationManager } = useNuxtApp();
    const route = useRoute();
    const compra = ref(null);

    onMounted(async () => {
        const compraId = route.params.id;

        if (compraId) {
            const response = await $communicationManager.detalleCompra(compraId);

            if (response) {
                compra.value = response;
            } else {
                console.error("No es va poder obtenir els detalls de la compra.");
            }
        }
    });
</script>