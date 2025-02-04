<template>
    <loading v-if="isLoading" />

    <div v-if="comercio" class="text-gray-700 mb-6 p-6 bg-white rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <a @click="toggleView('productos')"
                class="text-lg font-medium text-indigo-600 hover:text-indigo-800 transition duration-200">
                Ver Productos
            </a>
            <a @click="toggleView('informacion')"
                class="text-lg font-medium text-indigo-600 hover:text-indigo-800 transition duration-200">
                Ver Información del Comercio
            </a>
        </div>

        <div v-if="view === 'productos'">
            <div v-if="subcategorias.length" class="mb-6">
                <div class="overflow-x-auto">
                    <ul class="flex space-x-4">
                        <li v-for="subcategoria in subcategorias" :key="subcategoria.id"
                            @click="toggleSubcategoria(subcategoria)"
                            :class="{
                                'text-blue-600': selectedSubcategorias.includes(subcategoria.id),
                                'text-gray-600': !selectedSubcategorias.includes(subcategoria.id)
                            }"
                            class="font-medium hover:text-indigo-600 cursor-pointer transition duration-200">
                            {{ subcategoria.name }}
                        </li>
                    </ul>
                </div>
            </div>

            <div id="productos" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="(producto, index) in filteredProductos" :key="producto.producto_id"
                    class="bg-white p-4 rounded-lg shadow-sm hover:shadow-lg transition duration-200">
                    <img :src="producto.imagen ? `http://localhost:8000/storage/${producto.imagen}` : 'http://localhost:8000/storage/productos/default-image.webp'"
                        alt="Imagen del producto" class="w-full h-48 object-cover rounded-t-lg" />
                    <h3 class="mt-4 text-xl font-semibold text-gray-800">{{ producto.nombre }}</h3>
                    <p class="mt-2 text-gray-600 text-sm">{{ producto.descripcion }}</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-lg font-semibold text-indigo-600">{{ formatPrice(producto.precio) }}€</span>
                        <button @click="mostrarIdProducto(producto.producto_id)"
                            class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 transition duration-200">
                            Ver Producto
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="view === 'informacion'">
            <strong class="text-2xl font-semibold text-gray-800">Detalles completos del comercio:</strong>

            <div class="mt-6">
                <h4 class="text-lg font-medium text-gray-700">Nombre del Comercio:</h4>
                <p class="mt-2 text-gray-600">{{ comercio.nombre }}</p>

                <h4 class="text-lg font-medium text-gray-700 mt-4">Información de Contacto:</h4>
                <p class="mt-2 text-gray-600">Email: <a :href="'mailto:' + comercio.email" class="text-indigo-600">{{ comercio.email }}</a></p>
                <p class="mt-2 text-gray-600">Teléfono: {{ comercio.phone || 'No disponible' }}</p>

                <h4 class="text-lg font-medium text-gray-700 mt-4">Dirección:</h4>
                <p class="mt-2 text-gray-600">{{ comercio.calle_num }}, {{ comercio.ciudad }}, {{ comercio.provincia }}, {{ comercio.codigo_postal }}</p>

                <h4 class="text-lg font-medium text-gray-700 mt-4">Descripción:</h4>
                <p class="mt-2 text-gray-600">{{ comercio.descripcion }}</p>

                <h4 class="text-lg font-medium text-gray-700 mt-4">Puntaje Medio:</h4>
                <p class="mt-2 text-gray-600">{{ comercio.puntaje_medio }}</p>

                <h4 class="text-lg font-medium text-gray-700 mt-4">Horario:</h4>
                <pre v-if="comercio.horario" class="mt-2 text-gray-600">{{ formatHorario(comercio.horario) }}</pre>

                <h4 class="text-lg font-medium text-gray-700 mt-4">Imagenes:</h4>
                <div class="mt-2">
                    <img v-for="(imagen, index) in parsedImages(comercio.imagenes)" :key="index" :src="imagen"
                        alt="Imagen del Comercio" class="w-40 h-40 object-cover rounded-lg mr-2 mb-2" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
definePageMeta({
    layout: false,
});

import { useNuxtApp } from "#app";
import { ref, onMounted } from "vue";
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
            comercio.value = response;
            productos.value = response.productos;

            // Extraemos las subcategorías únicas de los productos
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
    console.log("Vista cambiada a:", view.value);
};

// Filtrar productos según las subcategorías seleccionadas
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
