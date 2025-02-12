<template>
    <div class="bg-gray-100">
        <div :class="{ 'dark': isDarkMode }">
            <div class="dark:bg-gray-900 min-h-screen transition-colors duration-300">

                <!-- <div id="banner" class="w-full h-64 flex overflow-hidden relative items-center">
                    <div id="carousel" class="flex items-center transition-transform duration-500 ease-in-out">
                        <img src="https://static.vecteezy.com/system/resources/previews/002/506/587/non_2x/flash-sale-discount-banner-promotion-background-vector.jpg"
                            class="w-full h-full object-cover object-center">
                        <img src="https://s.tmimgcdn.com/scr/1200x750/343900/banner-de-venta-de-color-azul-degradado-vectorial-y-idea-de-fondo-azul-de-promocion-de-descuento-de-banner-de-venta_343959-original.jpg"
                            class="w-full h-full object-cover object-center">
                        <img src="https://img.freepik.com/vector-premium/promocion-plantilla-banner-descuento-venta-flash_7087-866.jpg"
                            class="w-full h-full object-cover object-center">
                    </div>
                </div> -->

                <div id="contain-categorias" class="bg-white w-full flex flex-col py-4 border-b rounded-b-xl mb-2 scrollbar-none">
                    <div class="flex justify-between mx-4 mb-3">
                        <h2 class="font-semibold text-lg">Categories</h2>
                        <p>Totes les categories</p>
                    </div>
                    <div id="categorias" class="flex space-x-6 px-4 items-center overflow-x-auto">
                        <div v-for="categoria in categorias" :key="categoria.id"
                            class="flex flex-col items-center justify-center cursor-pointer"
                            @click="irACategoria(categoria.id)">
                            <div class="w-[4em] h-[4em] rounded-full p-2 border bg-gray-50 overflow-hidden">
                                <img :src="categoria.imagenes" alt="imgCategoria">
                            </div>
                            <p class="flex items-center justify-center mt-1 text-sm font-medium text-gray-800 dark:text-gray-200">
                                {{ categoria.name }}
                            </p>
                        </div>
                    </div>
                </div>

                <div id="contain-productos" class="py-4 bg-white border-t rounded-t-xl">
                    <h1 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 ml-4">Últimes tendències</h1>
                    <div class="flex space-x-1 pl-4 items-center overflow-x-auto scrollbar-none">
                        <productoComp v-for="(producto, index) in productos" :key="index" :id="producto.id"
                            :img="producto.imagen ? `http://localhost:8000/storage/${producto.imagen}` : 'http://localhost:8000/storage/productos/default-image.webp'"
                            :title="producto.nombre" :price="producto.precio" :comercio="producto.comercio" :customClass="'w-[170px]'"
                            price-class="text-gray-900 dark:text-white" @click="mostrarIdProducto(producto.id)">
                        </productoComp>
                    </div>
                    <h1 class="text-xl mt-5 font-semibold text-gray-900 dark:text-white mb-4 ml-4">Para ti</h1>
                    <div id="productos" class="grid grid-cols-2 gap-4 px-4">
                        <productoComp v-for="(producto, index) in productos" :key="index" :id="producto.id"
                            :img="producto.imagen ? `http://localhost:8000/storage/${producto.imagen}` : 'http://localhost:8000/storage/productos/default-image.webp'"
                            :title="producto.nombre" :price="producto.precio" :comercio="producto.comercio" :customClass="'w-full'"
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

    function irACategoria(id) {
        router.push(`/categorias/${id}`);
    }

    function mostrarIdProducto(id) {
        router.push(`/producto/${id}`);
    }
</script>

<style scoped>
    @import '../assets/index.css';
</style>