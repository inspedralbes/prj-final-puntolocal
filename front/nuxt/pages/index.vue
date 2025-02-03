<template>
    <div>
        <div :class="{ 'dark': isDarkMode }">
            <div class="bg-white dark:bg-gray-900 min-h-screen transition-colors duration-300">

                <div id="banner" class="w-full h-64 flex overflow-hidden relative items-center">
                    <div id="carousel" class="flex items-center transition-transform duration-500 ease-in-out">
                        <img src="https://static.vecteezy.com/system/resources/previews/002/506/587/non_2x/flash-sale-discount-banner-promotion-background-vector.jpg"
                            class="w-full h-full object-cover object-center">
                        <img src="https://s.tmimgcdn.com/scr/1200x750/343900/banner-de-venta-de-color-azul-degradado-vectorial-y-idea-de-fondo-azul-de-promocion-de-descuento-de-banner-de-venta_343959-original.jpg"
                            class="w-full h-full object-cover object-center">
                        <img src="https://img.freepik.com/vector-premium/promocion-plantilla-banner-descuento-venta-flash_7087-866.jpg"
                            class="w-full h-full object-cover object-center">
                    </div>
                </div>

                <div id="contain-categorias" class="w-full overflow-x-auto bg-gray-100 dark:bg-gray-800 py-4">
                    <div id="categorias" class="flex space-x-6 px-4 items-center">
                        <div v-for="categoria in categorias" :key="categoria.id"
                            class="flex flex-col items-center justify-center">
                            <div class="w-20 h-20 rounded-lg shadow-md bg-cover bg-center dark:shadow-sm dark:shadow-white"
                                :style="{ backgroundImage: `url(${categoria.imagenes})` }">
                            </div>
                            <p
                                class="h-10 flex items-center justify-center mt-2 text-sm font-medium text-gray-800 dark:text-gray-200">
                                {{ categoria.name }}
                            </p>
                        </div>
                    </div>
                </div>

                <div id="contain-productos" class="p-4">
                    <h1 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Últimes tendències</h1>
                    <div id="productos" class="grid grid-cols-2 gap-4">
                        <productoComp v-for="(producto, index) in productos" :key="index" :id="producto.id"
                            :img="producto.imagen ? `http://localhost:8000/storage/${producto.imagen}` : 'http://localhost:8000/storage/productos/default-image.webp'"
                            :title="producto.nombre" :price="producto.precio" :comercio="producto.comercio"
                            price-class="text-gray-900 dark:text-white" @click="mostrarIdProducto(producto.id)">
                        </productoComp>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref, onMounted, watch } from "vue";
    import { useRouter } from "vue-router";
    import { useAuthStore } from "~/stores/authStore";

    const productos = ref([]);
    const categorias = ref([]);
    const router = useRouter();
    const authStore = useAuthStore();
    const { $communicationManager } = useNuxtApp();
    const isDarkMode = ref(window.matchMedia("(prefers-color-scheme: dark)").matches);

    onMounted(() => {
        const mediaQuery = window.matchMedia("(prefers-color-scheme: dark)");
        const handleChange = (event) => {
            isDarkMode.value = event.matches;
        };
        mediaQuery.addEventListener("change", handleChange);

        document.body.classList.toggle('dark', isDarkMode.value);

        fetchProductos();
        fetchCategorias();
    });

    watch(isDarkMode, (newValue) => {
        document.body.classList.toggle('dark', newValue);
    });

    async function fetchProductos() {
        try {
            const response = await $communicationManager.getProductos();
            console.log(response);
            if (response && response.data) {
                productos.value = response.data;
            } else {
                console.error("Error al obtener los productos");
            }
        } catch (error) {
            console.error("Error en la petición:", error);
        }
    }

    async function fetchCategorias() {
        try {
            const responseCategorias = await $communicationManager.getCategoriasGenerales();
            if (responseCategorias) {
                categorias.value = responseCategorias;
            } else {
                console.error("Error al obtener las categorías");
            }
        } catch (error) {
            console.error("Error en la petición:", error);
        }
    }

    function mostrarIdProducto(id) {
        router.push(`/producto/${id}`);
    }
</script>

<style scoped>
    @import '../assets/index.css';
</style>