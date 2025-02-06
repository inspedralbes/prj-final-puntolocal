<template>
    <div v-if="loading" class="flex justify-center items-center">
        <Loading />
    </div>
    <div v-else>
        <nav class="sticky top-[76px] z-50 flex gap-4 w-full justify-center bg-gray-200 text-lg">
            <button class="border p-2" @click="showSection('productos')">Productes</button>
            <button @click="showSection('comercios')">Comerços</button>
        </nav>
        <div v-if="currentSection === 'productos'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div v-for="(product, index) in Object.values(productos)" :key="index" class="p-4 border rounded shadow-md">
                <div class="flex">
                    <img :src="product.imagen" class="min-h-[150px] min-w-[140px] border" />
                    <div class="flex flex-col ml-5">
                        <h2 class="text-xl font-bold mb-2 line-clamp-2 break-all">{{ product.nombre }}</h2>
                        <div class="flex mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#e9ec27"
                                class="bi bi-star-fill" viewBox="0 0 16 16">
                                <path
                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#e9ec27"
                                class="bi bi-star-fill" viewBox="0 0 16 16">
                                <path
                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#e9ec27"
                                class="bi bi-star-fill" viewBox="0 0 16 16">
                                <path
                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#e9ec27"
                                class="bi bi-star-fill" viewBox="0 0 16 16">
                                <path
                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#e9ec27"
                                class="bi bi-star-half" viewBox="0 0 16 16">
                                <path
                                    d="M5.354 5.119 7.538.792A.52.52 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.54.54 0 0 1 16 6.32a.55.55 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.5.5 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.6.6 0 0 1 .085-.302.51.51 0 0 1 .37-.245zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.56.56 0 0 1 .162-.505l2.907-2.77-4.052-.576a.53.53 0 0 1-.393-.288L8.001 2.223 8 2.226z" />
                            </svg>
                        </div>
                        <p class="mt-2">Comerç a 400m</p>
                        <p class="mt-3 text-xl">{{ product.precio }} €</p>
                        <button @click="addToBasket(product)" class="pt-2 pb-2 pl-3 pr-3 mt-4 w-fit bg-[#276BF2] rounded-lg">Afegir a la
                            cistella</button>
                    </div>
                </div>
            </div>
        </div>
        <div v-else v-if="currentSection === 'comercios'">
            <p>Contenido de comercios</p>
        </div>
    </div>
    <!-- <div>
        {{ searchQuery }}
    </div> -->

</template>

<script setup>
import Loading from "@/components/loading.vue";
import { useRoute } from '#imports';
import { useComercioStore } from '@/stores/comercioStore';

definePageMeta({
    layout: 'default',
});

const loading = ref(true);
const productos = reactive({});
const comercios = reactive({});
const route = useRoute();
let searchQuery = route.query.search || '';
const currentSection = ref('productos');

function addToBasket(producto) {
    const comercioStore = useComercioStore();
    comercioStore.addToBasket(producto);
    if (confirm('¿Quieres ir a la cesta?')) {
        navigateTo('/cistella');
    }
}

function showSection(section) {
    currentSection.value = section;
}

async function getProductsBySearch() {
    loading.value = true;
    const { $communicationManager } = useNuxtApp();

    const response = await $communicationManager.busquedaGeneral(searchQuery);

    Object.assign(productos, response.data);

    console.log(productos)

    loading.value = false;
}

async function getComerciosBySearch() {
    //Aqui petición comercios
}



onMounted(() => {
    getProductsBySearch();
});

// Observa cambios en `route.query.search`
watch(() => route.query.search, (newSearch) => {
    searchQuery = newSearch || '';
    getProductsBySearch();
});
</script>
