<template>
    <div class="bg-gray-100">
        <div :class="{ 'dark': isDarkMode }">
            <div class="dark:bg-gray-900 min-h-screen transition-colors duration-300">

                <div id="banner" class="bg-white mt-2 px-4 w-full h-[180px] flex relative items-center overflow-hidden">
                    <div id="carousel"
                        class="h-full flex items-center transition-transform duration-500 ease-in-out rounded-lg overflow-hidden">
                        <img src="https://s.tmimgcdn.com/scr/1200x750/343900/banner-de-venta-de-color-azul-degradado-vectorial-y-idea-de-fondo-azul-de-promocion-de-descuento-de-banner-de-venta_343959-original.jpg"
                            class="object-cover object-center">
                    </div>
                </div>

                <div id="contain-categorias"
                    class="bg-white w-full flex flex-col py-4 border-b rounded-b-xl mb-2 scrollbar-none">
                    <div class="flex justify-between mx-4 mb-3">
                        <h2 class="font-semibold text-lg">Categories</h2>
                        <p class="text-gray-500 flex items-center">
                            Veure totes
                            <svg width="1.5em" height="1.5em" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M9.71069 18.2929C10.1012 18.6834 10.7344 18.6834 11.1249 18.2929L16.0123 13.4006C16.7927 12.6195 16.7924 11.3537 16.0117 10.5729L11.1213 5.68254C10.7308 5.29202 10.0976 5.29202 9.70708 5.68254C9.31655 6.07307 9.31655 6.70623 9.70708 7.09676L13.8927 11.2824C14.2833 11.6729 14.2833 12.3061 13.8927 12.6966L9.71069 16.8787C9.32016 17.2692 9.32016 17.9023 9.71069 18.2929Z"
                                        fill="#6B7280"></path>
                                </g>
                            </svg>
                        </p>
                    </div>
                    <div id="categorias" class="flex space-x-6 px-4 items-center overflow-x-auto">
                        <div v-for="categoria in categorias" :key="categoria.id"
                            class="flex flex-col items-center justify-center cursor-pointer"
                            @click="irACategoria(categoria.id)">
                            <div class="w-[4em] h-[4em] rounded-full p-2 border bg-gray-50 overflow-hidden">
                                <img :src="categoria.imagenes" alt="imgCategoria">
                            </div>
                            <p
                                class="flex items-center justify-center mt-1 text-sm font-medium text-gray-800 dark:text-gray-200">
                                {{ categoria.name }}
                            </p>
                        </div>
                    </div>
                </div>

                <div id="contain-productos" class="py-4 bg-white border-t rounded-t-xl">
                    <div class="flex justify-between mx-4 mb-4">
                        <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Últimes tendències</h1>
                        <p class="text-gray-500 flex items-ceeminter">
                            Veure totes
                            <svg width="1.5em" height="1.5em" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M9.71069 18.2929C10.1012 18.6834 10.7344 18.6834 11.1249 18.2929L16.0123 13.4006C16.7927 12.6195 16.7924 11.3537 16.0117 10.5729L11.1213 5.68254C10.7308 5.29202 10.0976 5.29202 9.70708 5.68254C9.31655 6.07307 9.31655 6.70623 9.70708 7.09676L13.8927 11.2824C14.2833 11.6729 14.2833 12.3061 13.8927 12.6966L9.71069 16.8787C9.32016 17.2692 9.32016 17.9023 9.71069 18.2929Z"
                                        fill="#6B7280"></path>
                                </g>
                            </svg>
                        </p>
                    </div>
                    <div class="flex space-x-1 pl-4 items-center overflow-x-auto scrollbar-none">
                        <productoComp v-for="(producto, index) in productos2" :key="index" :id="producto.id"
                            :img="producto.imagen ? `${baseUrl}/storage/${producto.imagen}` : `${baseUrl}/storage/productos/default-image.webp`"
                            :title="producto.nombre" :price="producto.precio" :comercio="producto.comercio"
                            :customClass="'w-[170px]'" price-class="text-gray-900 dark:text-white"
                            @click="mostrarIdProducto(producto.id)">
                        </productoComp>
                    </div>
                    <h1 class="text-xl mt-5 font-semibold text-gray-900 dark:text-white mb-4 ml-4">Per a tu</h1>
                    <div id="productos" class="grid grid-cols-2 gap-4 px-4">
                        <productoComp v-for="(producto, index) in productos" :key="index" :productoId="producto.id"
                            :img="producto.imagen ? `${baseUrl}/storage/${producto.imagen}` : `${baseUrl}/storage/productos/default-image.webp`"
                            :title="producto.nombre" :price="producto.precio" :comercio="producto.comercio"
                            :customClass="'w-full'" price-class="text-gray-900 dark:text-white"
                            @click="mostrarIdProducto(producto.id)">
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
import { useRuntimeConfig } from "#imports";
import Swal from "sweetalert2";
import { Loading } from "#components";

const config = useRuntimeConfig();
const baseUrl = config.public.apiBaseUrl;

const productos = ref([]);
const productos2 = ref([]);
const categorias = ref([]);
const router = useRouter();
const authStore = useAuthStore();
const { $communicationManager } = useNuxtApp();
const isDarkMode = ref(window.matchMedia("(prefers-color-scheme: dark)").matches);
const userLocation = ref(null);

onMounted(async () => {
    const mediaQuery = window.matchMedia("(prefers-color-scheme: dark)");
    const handleChange = (event) => {
        isDarkMode.value = event.matches;
    };
    mediaQuery.addEventListener("change", handleChange);
    document.body.classList.toggle("dark", isDarkMode.value);

    getLocation();
    fetchProductos();
    fetchProductos2();
    fetchCategorias();
    await checkLocationPermission();
});

async function checkLocationPermission() {
    if (localStorage.getItem("locationPermission") === "granted") {
        await getLocation();
    } else {
        requestLocationPermission();
    }
}

async function getLocation() {
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(
            async (position) => {
                const { latitude, longitude } = position.coords;
                userLocation.value = { latitude, longitude };
                localStorage.setItem("locationPermission", "granted");
                await fetchComerciosCercanos(latitude, longitude);
            },
            (error) => {
                console.error("Error al obtener la ubicación:", error);
            }
        );
    } else {
        console.error("Geolocalización no disponible.");
    }
}

async function fetchComerciosCercanos(lat, lon) {
    try {
        const response = await $communicationManager.getComerciosCercanos(lat, lon);
        console.log("Comercios cercanos:", response);

        if (response && response.data) {
            const comercioIds = response.data.map(comercio => comercio.id);
            await fetchProductos(comercioIds);
        } else {
            console.error("No se encontraron comercios cercanos.");
        }
    } catch (error) {
        console.error("Error obteniendo comercios cercanos:", error);
    }
}

async function fetchProductos(comercioIds) {
    try {
        const response = await $communicationManager.getProductosCercanos(comercioIds);

        if (response && response.data) {
            productos.value = response.data;
        } else {
            console.error("No se encontraron productos disponibles.");
            productos.value = []; // Evita que el front falle al no recibir datos
        }
    } catch (error) {
        console.error("Error en la petición:", error);
        productos.value = [];
    }
}



async function fetchProductos2() {
    try {
        const response = await $communicationManager.getProductos();
        if (response && response.data) {
            productos2.value = response.data;
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