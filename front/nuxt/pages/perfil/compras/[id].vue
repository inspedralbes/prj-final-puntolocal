<template>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Detalles de la Compra</h1>

        <!-- Mostrar detalles solo si están disponibles -->
        <div v-if="compra">
            <!-- Encabezado con fecha y tipo de envío -->
            <div class="bg-white shadow-md rounded-lg p-4 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-500 text-sm">
                        Fecha: {{ new Date(compra.fecha).toLocaleDateString() }}
                    </span>
                    <span class="text-blue-500 font-semibold">
                        Tipo de envío: {{ compra.tipo_envio.nombre }}
                    </span>
                </div>
                <div class="text-gray-800 font-semibold">
                    Total de la compra: ${{ compra.total.toFixed(2) }}
                </div>
            </div>

            <!-- Lista de productos -->
            <div class="bg-white shadow-md rounded-lg p-4">
                <h2 class="text-lg font-semibold mb-4">Productos</h2>

                <div v-for="productoCompra in compra.productos_compra" :key="productoCompra.id"
                    class="flex items-center mb-4 p-4 border rounded-lg">
                    <!-- Imagen del producto -->
                    <div class="w-20 h-20 flex-shrink-0 rounded-lg bg-gray-100">
                        <img :src="productoCompra.producto.imagen || 'https://via.placeholder.com/150'"
                            alt="Imagen del producto" class="w-full h-full object-cover rounded-lg" />
                    </div>

                    <!-- Información del producto -->
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-semibold">{{ productoCompra.producto.nombre }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ productoCompra.producto.descripcion }}</p>
                        <div class="text-sm text-gray-800 mt-2">
                            <span class="font-semibold">Precio unitario:</span> ${{
                                productoCompra.producto.precio.toFixed(2) }}
                        </div>
                        <div class="text-sm text-gray-800">
                            <span class="font-semibold">Cantidad:</span> {{ productoCompra.cantidad }}
                        </div>
                        <div class="text-sm text-gray-800 font-semibold mt-2">
                            Total por este producto: ${{ productoCompra.total.toFixed(2) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Si no hay información de la compra -->
        <div v-else class="text-gray-500 text-center">
            <p>Cargando detalles de la compra...</p>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";

const { $communicationManager } = useNuxtApp();
const route = useRoute();
const compra = ref(null); // Detalles de la compra

async function fetchCompraDetalle() {
    const compraId = route.params.id;

    if (compraId) {
        const response = await $communicationManager.get(`/compras/${compraId}`); // Ajusta el endpoint si es necesario
        if (response) {
            compra.value = response;
        } else {
            console.error("Error al obtener los detalles de la compra.");
        }
    }
}

// Cargar detalles al montar el componente
onMounted(fetchCompraDetalle);
</script>

<style>
/* Agrega estilos personalizados si es necesario */
</style>
