<template>
    <loading v-if="isLoading" />

    <div v-if="comercio" class="p-4 space-y-6">
        <div class="flex gap-6 mb-6 justify-center">
            <a @click="toggleView('productos')"
                class="bg-transparent text-blue-600 rounded-lg transition-all duration-300 ease-in-out text-lg font-semibold flex items-center">
                Ver Productos
            </a>

            <a @click="toggleView('informacion')"
                class="bg-transparent text-green-600 rounded-lg transition-all duration-300 ease-in-out text-lg font-semibold flex items-center">
                Ver Información del Comercio
            </a>
        </div>


        <div v-if="view === 'productos'">
            <div v-if="subcategorias.length" class="overflow-x-auto pb-2 border-b border-gray-300">
                <ul class="flex space-x-3 whitespace-nowrap">
                    <li v-for="subcategoria in subcategorias" :key="subcategoria.id"
                        @click="toggleSubcategoria(subcategoria)" :class="selectedSubcategorias.includes(subcategoria.id)
                            ? 'bg-blue-800 text-white font-semibold'
                            : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                        class="px-4 py-2 rounded-md cursor-pointer transition-all duration-300">
                        {{ subcategoria.name }}
                    </li>
                </ul>
            </div>

            <div id="productos" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-[30px]">
                <div v-for="(producto, index) in filteredProductos" :key="producto.producto_id"
                    class="border rounded-lg p-4 shadow-md hover:shadow-lg transition">
                    <img :src="producto.imagen ? `http://localhost:8000/storage/${producto.imagen}` : 'http://localhost:8000/storage/productos/default-image.webp'"
                        alt="Imagen del producto" class="w-full h-48 object-cover mb-4 rounded-md" />
                    <h3 class="font-semibold text-xl mb-2">{{ producto.nombre }}</h3>
                    <p class="text-gray-600 mb-4">{{ producto.descripcion }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold">{{ formatPrice(producto.precio) }}€</span>
                        <button @click="mostrarIdProducto(producto.producto_id)"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            Ver Producto
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="view === 'informacion'" class="space-y-4">
            <div>
                <h4 class="font-semibold text-lg">Nombre del Comercio:</h4>
                <p class="text-gray-700">{{ comercio.nombre }}</p>
            </div>

            <div>
                <h4 class="font-semibold text-lg">Descripción:</h4>
                <p class="text-gray-700">{{ comercio.descripcion }}</p>
            </div>

            <div>
                <h4 class="font-semibold text-lg">Dirección:</h4>
                <p class="text-gray-700">
                    {{ comercio.calle_num }}, {{ comercio.num_puerta }}, Planta {{ comercio.num_planta }}<br>
                    {{ comercio.ciudad }}, {{ comercio.provincia }}, {{ comercio.codigo_postal }}
                </p>
            </div>

            <div>
                <h4 class="font-semibold text-lg">Teléfono:</h4>
                <p class="text-gray-700">{{ comercio.phone }}</p>
            </div>

            <div>
                <h4 class="font-semibold text-lg">Email:</h4>
                <p class="text-gray-700">{{ comercio.email }}</p>
            </div>

            <div>
                <h4 class="font-semibold text-lg">Horario:</h4>
                <ul class="space-y-2">
                    <li v-for="(horario, dia) in JSON.parse(comercio.horario)" :key="dia" class="text-gray-700">
                        <strong>{{ dia }}:</strong> {{ horario }}
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="font-semibold text-lg">Puntuación Media:</h4>
                <p class="text-yellow-500">{{ comercio.puntaje_medio }} ⭐</p>
            </div>

            <div v-if="comercio.imagenes">
                <h4 class="font-semibold text-lg">Imagen del Comercio:</h4>
                <img :src="JSON.parse(comercio.imagenes)[0]" alt="Imagen del comercio"
                    class="w-full h-64 object-cover rounded-lg shadow-md" />
            </div>
        </div>
    </div>
</template>


<script setup>
definePageMeta({
    layout: false,
});

import { useNuxtApp } from "#app";
import { ref, onMounted, computed } from "vue";
import { useRoute, useRouter } from "vue-router";
import loading from "../../components/loading.vue";

const route = useRoute();
const productos = ref([]);
const router = useRouter();
const comercio = ref(null);
const isLoading = ref(true);
const subcategorias = ref([]);
const selectedSubcategorias = ref([]);
const view = ref('productos');
const { $communicationManager } = useNuxtApp();

const fetchComercio = async () => {
    const id = route.params.id;
    try {
        const response = await $communicationManager.getComercioById(id);

        if (response) {
            comercio.value = response.comercio;
            productos.value = response.productos;

            const subcats = response.productos.map(producto => producto.subcategoria);
            subcategorias.value = [...new Map(subcats.map(sub => [sub.id, sub])).values()];

            isLoading.value = false;
        } else {
            throw new Error("No se pudo obtener el comercio");
        }
    } catch (error) {
        console.error("Error al obtener el comercio:", error);
        isLoading.value = false;
    }
};

const formatPrice = (price) => {
    return parseFloat(price).toFixed(2);
};

const toggleView = (newView) => {
    view.value = newView;
};

const filteredProductos = computed(() => {
    if (selectedSubcategorias.value.length === 0) {
        return productos.value;
    }
    return productos.value.filter(producto =>
        selectedSubcategorias.value.includes(producto.subcategoria.id)
    );
});

const toggleSubcategoria = (subcategoria) => {
    if (selectedSubcategorias.value.includes(subcategoria.id)) {
        selectedSubcategorias.value = selectedSubcategorias.value.filter(id => id !== subcategoria.id);
    } else {
        selectedSubcategorias.value.push(subcategoria.id);
    }
};

onMounted(() => {
    fetchComercio();
});
</script>