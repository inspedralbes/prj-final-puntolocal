<template>
    <loading v-if="isLoading" />

    <div v-if="comercio" class="text-gray-700 mb-6 p-6 bg-white rounded-lg shadow-lg">
        <!-- Contenedor de botones para cambiar la vista -->
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

        <!-- Vista de productos -->
        <div v-if="view === 'productos'">
            <div v-if="subcategorias.length" class="mb-6">
                <div class="overflow-x-auto">
                    <ul class="flex space-x-4">
                        <li v-for="subcategoria in subcategorias" :key="subcategoria.id"
                            class="text-gray-600 font-medium hover:text-indigo-600 cursor-pointer transition duration-200">
                            {{ subcategoria.name }}
                        </li>
                    </ul>
                </div>
            </div>

            <div id="productos" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="(producto, index) in productos" :key="producto.producto_id"
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

        <!-- Vista de información del comercio -->
        <div v-if="view === 'informacion'">
            <strong class="text-2xl font-semibold text-gray-800">Detalles completos del comercio:</strong>

            <div class="mt-6">
                <h4 class="text-lg font-medium text-gray-700">Descripción:</h4>
                <p class="mt-2 text-gray-600">{{ comercio.descripcion }}</p>
            </div>

            <div class="mt-6">
                <h4 class="text-lg font-medium text-gray-700">Horario:</h4>
                <pre class="mt-2 text-gray-600">{{ parseHorario(comercio.horario) }}</pre>
            </div>

            <div class="mt-6">
                <h4 class="text-lg font-medium text-gray-700">Dirección:</h4>
                <p class="mt-2 text-gray-600">{{ comercio.calle_num }}, {{ comercio.ciudad }}, {{ comercio.provincia }},
                    {{ comercio.codigo_postal }}</p>
            </div>

            <div class="mt-6">
                <h4 class="text-lg font-medium text-gray-700">Contacto:</h4>
                <p class="mt-2 text-gray-600">Email: <a :href="'mailto:' + comercio.email"
                        class="text-indigo-600 hover:text-indigo-800 transition duration-200">{{ comercio.email }}</a>
                </p>
                <p class="mt-2 text-gray-600">Teléfono: {{ comercio.phone }}</p>
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
    const view = ref('productos');
    const { $communicationManager } = useNuxtApp();

    const fetchComercio = async () => {
        const id = route.params.id;
        const response = await $communicationManager.getComercioById(id);

        if (response) {
            comercio.value = response;
            console.log("Comercio recibido:", comercio.value);
            productos.value = response.productos;

            const subcats = response.productos.map(producto => producto.subcategoria);
            subcategorias.value = [...new Map(subcats.map(sub => [sub.id, sub])).values()];
        }
    };

    const formatPrice = (price) => {
        return price.toFixed(2);
    };

    const toggleView = (newView) => {
        view.value = newView;
    };

    const parseHorario = (horario) => {
        const horarioObj = JSON.parse(horario);
        let result = '';
        for (const dia in horarioObj) {
            result += `${dia.charAt(0).toUpperCase() + dia.slice(1)}: ${horarioObj[dia]}\n`;
        }
        return result;
    };

    onMounted(() => {
        fetchComercio();
    });
</script>
