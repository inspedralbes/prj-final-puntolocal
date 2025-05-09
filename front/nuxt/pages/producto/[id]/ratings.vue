<template>
    <div class="min-h-screen bg-gray-100 text-gray-900">
        <div id="header" class="w-full z-50 flex items-center justify-between p-4 bg-white fixed top-0 border-b">

            <!-- Botón de retroceso -->
            <div @click="goBack" class="text-xl text-gray-700 cursor-pointer">
                <svg width="1.5em" height="1.5em" viewBox="0 0 1024 1024" class="icon"
                    xmlns="http://www.w3.org/2000/svg" fill="#000000">
                    <g id="SVGRepo_iconCarrier">
                        <path fill="#000000" d="M224 480h640a32 32 0 110 64H224a32 32 0 010-64z"></path>
                        <path fill="#000000"
                            d="M237.248 512l265.408 265.344a32 32 0 01-45.312 45.312l-288-288a32 32 0 010-45.312l288-288a32 32 0 1145.312 45.312L237.248 512z">
                        </path>
                    </g>
                </svg>
            </div>

            <!-- Contenedor del título centrado -->
            <div class="absolute left-1/2 transform -translate-x-1/2">
                <h3 class="text-lg font-semibold truncate">
                    Resenyes
                </h3>
            </div>

            <div class="w-16 h-8 flex items-center justify-end mr-2 cursor-pointer">
                <NuxtLink to="/cistella">
                    <svg width="1.7em" height="1.7em" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_iconCarrier">
                            <path d="M8 12L8 8C8 5.79086 9.79086 4 12 4V4C14.2091 4 16 5.79086 16 8L16 12"
                                stroke="#000000" stroke-width="1.3" stroke-linecap="round"></path>
                            <path
                                d="M3.69435 12.6678C3.83942 10.9269 3.91196 10.0565 4.48605 9.52824C5.06013 9 5.9336 9 7.68053 9H16.3195C18.0664 9 18.9399 9 19.514 9.52824C20.088 10.0565 20.1606 10.9269 20.3057 12.6678L20.8195 18.8339C20.904 19.8474 20.9462 20.3542 20.6491 20.6771C20.352 21 19.8435 21 18.8264 21H5.1736C4.15655 21 3.64802 21 3.35092 20.6771C3.05382 20.3542 3.09605 19.8474 3.18051 18.8339L3.69435 12.6678Z"
                                stroke="#000000" stroke-width="1.3"></path>
                        </g>
                    </svg>
                </NuxtLink>
            </div>
        </div>
        <div class="p-4 mt-[58px]">
            <div v-if="isLoading" class="space-y-2 animate-pulse">
                <div v-for="n in 8" :key="n" class="bg-white p-4 mb-2">
                    <div class="flex justify-between mb-2">
                        <div class="flex items-center space-x-2">
                            <div class="bg-gray-200 w-10 h-10 rounded-full"></div>
                            <div class="w-24 bg-gray-200 h-4"></div>
                        </div>
                        <div class="w-16 bg-gray-200 h-4"></div>
                    </div>
                    <div class="w-full bg-gray-200 h-4"></div>
                </div>
            </div>
            <div v-else>
                <div v-for="review in reviews" :key="review.id" class="bg-white p-4 mb-2">
                    <div class="flex justify-between mb-2">
                        <div class="flex items-center">
                            <div class="flex items-center justify-center bg-gray-200 rounded-full w-10 h-10 mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                    class="bi bi-person-fill" viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ review.cliente.name }} {{
                                    review.cliente.apellidos }}</p>
                                <div class="flex items-center">
                                    <PuntuacionComp :rating="review.rating" :customClass="'relative w-4 h-4'" />
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-500 text-sm">{{ formatDate(review.created_at) }}</p>
                    </div>
                    <p class="text-gray-700">{{ review.comment }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useNuxtApp, useRoute, useRouter } from "#app";

const reviews = ref([]);
const isLoading = ref(true);
const { $communicationManager } = useNuxtApp();
const route = useRoute();
const router = useRouter();

definePageMeta({
    layout: false,
});

function goBack() {
    router.back();
}

function formatDate(dateStr) {
    return dateStr ? dateStr.slice(0, 10) : '';
}

async function fetchAllReviews() {
    try {
        const response = await $communicationManager.getProductoRatings(route.params.id, 'all');
        if (response) {
            reviews.value = response.ratings || [];
        }
        isLoading.value = false;
    } catch (error) {
        console.error("Error fetching full ratings:", error);
        isLoading.value = false;
    }
}

onMounted(() => {
    fetchAllReviews();
});
</script>