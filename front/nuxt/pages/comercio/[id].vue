<template>
    <loading v-if="isLoading" />

    <div v-if="comercio" class="text-gray-600 mb-4">
        <div v-if="subcategorias.length">
            <h2 class="font-semibold text-xl mb-4">Subcategorías</h2>

            <div class="overflow-x-auto">
                <ul class="flex space-x-4">
                    <li v-for="subcategoria in subcategorias" :key="subcategoria.id"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 p-3 rounded-lg shadow-md cursor-pointer transition-colors duration-200 whitespace-nowrap">
                        {{ subcategoria.name }}
                    </li>
                </ul>
            </div>
        </div>

        <div id="productos" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            <div v-for="(producto, index) in productos" :key="producto.producto_id"
                class="bg-white p-4 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-200">
                <img :src="producto.imagen ? `http://localhost:8000/storage/${producto.imagen}` : 'http://localhost:8000/storage/productos/default-image.webp'"
                    alt="Imagen del producto" class="w-full h-40 object-cover mb-3 rounded-md" />
                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ producto.nombre }}</h3>
                <p class="text-sm text-gray-600 mb-3">{{ producto.descripcion }}</p>
                <div class="flex justify-between items-center">
                    <span class="text-xl font-semibold text-gray-900">{{ producto.precio | currency }}</span>
                    <button class="bg-blue-500 text-white px-3 py-2 rounded-lg hover:bg-blue-600"
                        @click="mostrarIdProducto(producto.producto_id)">
                        Ver Producto
                    </button>
                </div>
            </div>
        </div>

        <pre class="bg-gray-100 p-4 rounded-lg text-sm mt-2">
            {{ JSON.stringify(comercio, null, 2) }}
        </pre>
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
    const router = useRouter();
    const comercio = ref(null);
    const productos = ref([]);
    const subcategorias = ref([]);
    const isLoading = ref(true);
    const { $communicationManager } = useNuxtApp();

    const fetchComercio = async () => {
        try {
            const id = route.params.id;
            const response = await $communicationManager.getComercioById(id);

            if (response) {
                comercio.value = response;
                console.log("Comercio recibido:", comercio.value);

                productos.value = response.productos;

                const subcats = response.productos.map(producto => producto.subcategoria);
                subcategorias.value = [...new Map(subcats.map(sub => [sub.id, sub])).values()];
            }
        } catch (error) {
            console.error("Error obteniendo el comercio:", error);
        } finally {
            isLoading.value = false;
        }
    };

    onMounted(() => {
        fetchComercio();
    });
</script>