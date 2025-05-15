<template>
    <div v-if="loading" class="flex justify-center items-center">
        <Loading />
    </div>
    <div v-else>
        <nav class="sticky top-[76px] z-50 flex justify-center w-full bg-white text-lg border-b border-gray-300">
            <div class="flex justify-around w-[60vw]">
                <button class="border-b-2 transition-all"
                    :class="currentSection === 'productos' ? 'text-black border-[#276BF2]' : 'text-gray-400 border-white'"
                    @click="showSection('productos'); getProductsBySearch()">
                    Productes
                </button>
                <button class="border-b-2 transition-all"
                    :class="currentSection === 'comercios' ? 'text-black border-[#276BF2]' : 'text-gray-400 border-white'"
                    @click="showSection('comercios'); getComerciosBySearch()">
                    Comerços
                </button>
            </div>
        </nav>

        <div v-if="currentSection === 'productos'" class="p-5">
            <div v-if="Object.values(productos).length > 0" class="grid grid-cols-2 gap-4">
                <div v-for="(product, index) in Object.values(productos)" :key="index"
                    class="border rounded-xl overflow-hidden" @click="mostrarIdProducto(product.id)">
                    <div class="flex flex-col">
                        <img :src="`${baseUrl}/storage/${product.imagen}`" class="h-[180px] w-full" />
                        <div class="flex flex-col p-2">
                            <p class="text-[15px]">{{ product.comercio }}</p>
                            <p class="text-[20px] mb-2 line-clamp-2 break-all">{{ product.nombre }}</p>
                            <p class="mt-1 text-xl flex">{{ product.precio }} <span class="text-base">€</span></p>
                            <!-- <button @click="addToBasket(product)"
                                class="pt-1 pb-1 pl-2 pr-2 mt-4 w-fit bg-[#276BF2] rounded-lg text-white">Afegir a la
                                cistella</button> -->
                        </div>
                    </div>
                </div>
            </div>
            <div v-else>
                <p class="text-center text-lg mt-4">No hi ha coincidències</p>
            </div>
        </div>
        <div v-else v-if="currentSection === 'comercios'">
            <div v-if="Object.values(comercios).length > 0">
                <div v-for="(comercio, index) in Object.values(comercios)" :key="index"
                    @click="navigateTo('comercio/' + comercio.id)"
                    class="relative border rounded-xl m-4 overflow-hidden">
                    <img :src="`${baseUrl}/storage/${comercio.imagen_local_path}`"
                        class="w-full h-[250px] object-cover" />
                    <div class="absolute bottom-0 left-0 w-full bg-gray-200 bg-opacity-70 p-4 h-fit">

                        <p class="text-center">{{ comercio.nombre }}</p>
                        <p class="text-center">{{ getNombreCategoria(comercio.categoria_id) }}</p>
                        <div class="flex items-left justify-between">
                            <div class="flex items-center">
                                <p class="mr-1">{{ comercio.puntaje_medio }}</p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#facc15"
                                    class="bi bi-star-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                </svg>
                            </div>
                            <div class="flex text-right items-center">
                                <div :style="{ backgroundColor: getOpenState(comercio.horario) === 'cerrado' ? 'red' : 'green' }"
                                    class="w-4 h-4 rounded-full mr-2">
                                </div>
                                <p>{{ getOpenState(comercio.horario) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else>
                <p class="text-center text-lg mt-4">No hay coincidencias</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import Loading from "@/components/loading.vue";
import { useRoute, useRouter } from '#imports';
import { useComercioStore } from '@/stores/comercioStore';

import { useRuntimeConfig } from "#imports";
const config = useRuntimeConfig();
const baseUrl = config.public.apiBaseUrl;

definePageMeta({
    layout: 'default',
});

const loading = ref(true);
let productos = reactive({});
const comercios = reactive({});
const categorias = ref([]);
const route = useRoute();
const router = useRouter();
let searchQuery = route.query.search || '';
const currentSection = ref('productos');

function addToBasket(producto) {
    const comercioStore = useComercioStore();
    comercioStore.addToBasket(producto);
    if (confirm('¿Quieres ir a la cesta?')) {
        navigateTo('/cistella');
    }
}

function mostrarIdProducto(id) {
    router.push(`/producto/${id}`);
}

function showSection(section) {
    currentSection.value = section;
}

function getNombreCategoria(categoria_id) {
    console.log(categoria_id)
    if (!Array.isArray(categorias.value)) return 'Categoria no trobada'; // Previene el error
    const categoria = categorias.value.find((c) => c.id === categoria_id);
    return categoria ? categoria.name : 'Categoria no trobada';
}

async function getProductsBySearch() {
    const { $communicationManager } = useNuxtApp();

    const response = await $communicationManager.busquedaProductos(searchQuery);
    console.log(response);

    Object.keys(productos).forEach(key => delete productos[key]);
    if (response.data) {
        Object.assign(productos, response.data);
    }
}

async function getComerciosBySearch() {
    const { $communicationManager } = useNuxtApp();

    const response = await $communicationManager.busquedaComercios(searchQuery);
    Object.keys(comercios).forEach(key => delete comercios[key]);
    if (response) {
        Object.assign(comercios, response.data);
    }
}

async function getCategorias() {
    const { $communicationManager } = useNuxtApp();
    const data = await $communicationManager.getCategorias();
    categorias.value = data;
}

function getOpenState(horario) {
    if (!horario) return 'Cerrado';
    const schedule = typeof horario === 'string' ? JSON.parse(horario) : horario;
    const dayOfWeek = new Date().toLocaleString('es-ES', { weekday: 'long' }).toLowerCase();

    if (!schedule[dayOfWeek] || schedule[dayOfWeek].toLowerCase().includes('cerrado')) {
        return 'Cerrado';
    }
    const [openTime, closeTime] = schedule[dayOfWeek].split('-').map(t => t.trim());
    const [openHour, openMinute] = openTime.split(':').map(Number);
    const [closeHour, closeMinute] = closeTime.split(':').map(Number);

    const now = new Date();
    const currentMinutes = now.getHours() * 60 + now.getMinutes();
    const startMinutes = openHour * 60 + openMinute;
    const endMinutes = closeHour * 60 + closeMinute;

    return currentMinutes >= startMinutes && currentMinutes <= endMinutes ? 'Abierto' : 'Cerrado';
}

onMounted(() => {
    loading.value = true;
    if (currentSection.value === 'productos') {
        getProductsBySearch();
    } else if (currentSection.value === 'comercios') {
        getComerciosBySearch();
    }
    loading.value = false;
    getCategorias();
});

// Observa cambios en `route.query.search`
watch(() => route.query.search, (newSearch) => {
    loading.value = true;
    searchQuery = newSearch || '';
    if (currentSection.value === 'productos') {
        getProductsBySearch();
    } else if (currentSection.value === 'comercios') {
        getCategorias();
        getComerciosBySearch();
    }
    loading.value = false;
});
</script>
