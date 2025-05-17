<template>
    <div class="bg-gray-50 p-6 md:mt-16 md:grid md:grid-cols-6 flex flex-col gap-5 mt-12 md:mt-0">
        <!-- Vendes -->
        <section class="md:col-span-4">
            <div v-if="loading" class="text-center py-8">
                <Loading size="xl" color="#4F46E5" />
            </div>

            <div v-else class="bg-white p-4 rounded-xl border border-gray-200 md:h-[450px]">
                <div class="flex flex-col md:flex-row justify-between items-start mb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 md:mb-0">
                        Vendes
                    </h2>

                    <div class="flex gap-2">
                        <button v-for="period in periods" :key="period" @click="selectedPeriod = period"
                            class="px-4 py-2 rounded-lg transition-colors font-medium" :style="selectedPeriod === period
                                ? 'background-color: #4F46E5; color: white'
                                : 'background-color: #E0E7FF; color: #4F46E5; hover:bg-[#C7D2FE]'">
                            {{ periodLabels[period] }}
                        </button>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-center h-64">
                        <div v-if="!hasEnoughData" class="text-center p-4">
                            <i class="bi bi-bar-chart-line text-4xl text-gray-400 mb-2"></i>
                            <p class="text-gray-500">No hi ha suficients dades per mostrar el gràfic</p>
                            <p class="text-sm text-gray-500">Es necessiten múltiples punts de dades per generar una
                                representació gràfica</p>
                        </div>
                        <canvas v-else ref="chartCanvas" :key="`chart-${selectedPeriod}`"
                            class="w-full h-full"></canvas>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <StatCard title="Mitjana del període" :value="formatCurrency(stats.average)" icon="bi-graph-up"
                        color="#4F46E5" />
                    <StatCard title="Vendes totals" :value="formatCurrency(totalSales)" icon="bi-currency-euro"
                        color="#10B981" />
                    <StatCard title="Període analitzat" :value="periodLabels[selectedPeriod]" icon="bi-calendar"
                        color="#eb8b3b" />
                </div>
            </div>
        </section>

        <!-- Estadístiques mes actual -->
        <section class="col-span-2">
            <div class="bg-white p-4 rounded-xl border border-gray-200 h-[450px]">
                <header class="flex flex-col md:flex-row justify-between items-start mb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 md:mb-0">
                        Estadístiques mes actual
                    </h2>
                </header>

                <div class="w-full bg-gray-50 h-[50px] border-b mb-3 rounded-md">
                    <div class="w-full flex divide-x h-full items-center text-gray-700 text-sm">
                        <div class="w-full flex justify-center"
                            :class="topCurrentSelected === 1 ? 'text-blue-600' : ''"><button
                                @click="currentSelected(1)">Top productes</button></div>
                        <div class="w-full flex justify-center"
                            :class="topCurrentSelected === 2 ? 'text-blue-600' : ''"><button
                                @click="currentSelected(2)">Top clients</button></div>
                    </div>
                </div>

                <div v-if="topCurrentSelected === 1" class="w-full divide-y">
                    <div class="flex flex-col justify-center py-3" v-for="producto in topProducts"
                        :key="producto.producto_id">
                        <div class="flex justify-between">
                            <section class="flex gap-3">
                                <img :src="producto.image || '#'" alt="" width="50px" height="50px"
                                    class="rounded-md border">
                                <div>
                                    <p>{{ producto.nombre }}</p>
                                </div>
                            </section>
                            <p class="font-bold">{{ producto.total.toFixed(2) }} €</p>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div v-if="topClients" class="w-full divide-y">
                        <div class="flex flex-col justify-center py-3" v-for="client in topClients"
                            :key="client.client_id">
                            <div class="flex justify-between">
                                <section class="flex gap-3">
                                    <div>
                                        <p>{{ client.nombre }}</p>
                                    </div>
                                </section>
                                <p class="font-bold">{{ client?.subtotal?.toFixed(2) }} €</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Clients -->
        <section class="col-span-3">
            <div class="bg-white p-6 rounded-xl border border-gray-200 h-[180px] flex flex-col justify-center">
                <header class="flex flex-col md:flex-row justify-between items-start mb-2">
                    <h3 class="text-xl font-bold text-gray-800 mb-2 md:mb-0">
                        Clients
                    </h3>
                </header>
                <section>
                    <p class="text-gray-700 text-xl"> {{ uniqueClients }} clients
                        totals aquest últim mes</p>
                </section>
            </div>
        </section>

        <!-- Valoracions -->
        <section class="col-span-3">
            <div class="bg-white border border-gray-200 rounded-lg p-6 h-[180px]">
                <div class="w-full">
                    <div class="flex items-center gap-8">
                        <div class="flex flex-col items-center">
                            <h3 class="mb-2 text-base font-normal text-gray-500 dark:text-gray-400">Valoracions</h3>
                            <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
                                {{ rating }}
                            </span>
                            <PuntuacionComp :rating="rating" />
                            <span class="text-sm text-gray-600 font-light">({{ ratingBars?.totalRatings ?
                                ratingBars?.totalRatings : 0 }})</span>
                        </div>
                        <div class="flex-grow">
                            <div v-for="star in [5, 4, 3, 2, 1]" class="flex items-center mb-2" :key="star">
                                <p class="mr-5 text-sm font-medium dark:text-white">{{ star }}</p>
                                <div
                                    class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 relative overflow-hidden">
                                    <div class="absolute bg-yellow-400 left-0 z-50 h-2.5"
                                        :style="{ width: calcularPorcentaje(star) + '%' }"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="traffic-channels-chart" class="w-full"></div>
            </div>
        </section>

        <!-- Comentarios comercio -->
        <section class="md:col-span-3">
            <div class="bg-white p-4 rounded-xl border border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-start">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 md:mb-0">
                        Ressenyes de comerç
                    </h2>
                </div>
                <div>
                    <div class="flex justify-center">
                        <div v-if="reviewsComercio.length == 0" class="text-center p-4">
                            <i class="bi bi-bar-chart-line text-4xl text-gray-400 mb-2"></i>
                            <p class="text-gray-500">No existeix cap ressenya</p>
                        </div>
                        <div v-else class="w-full divide-y">
                            <div v-for="review in reviewsComercio.slice(0, 5)" class="py-5">
                                <header class="flex justify-between">
                                    <div class="flex gap-2 items-center">
                                        <p>{{ review.name }}</p>
                                        <PuntuacionComp :rating="review.stars" :customClass="'relative w-4 h-4'" />
                                    </div>
                                    <p class="text-gray-600 font-light text-sm">{{ formatData(review.created_at) }}</p>
                                </header>
                                <section>
                                    <p class="text-gray-800 font-light">{{ review.comment }}</p>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Comentarios productos -->
        <section class="md:col-span-3">
            <div class="bg-white p-4 rounded-xl border border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-start">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 md:mb-0">
                        Ressenyes de productes
                    </h2>
                </div>
                <div>
                    <div class="flex justify-center">
                        <div v-if="reviewsProducto.length == 0" class="text-center p-4">
                            <i class="bi bi-bar-chart-line text-4xl text-gray-400 mb-2"></i>
                            <p class="text-gray-500">No existeix cap ressenya</p>
                        </div>
                        <div v-else class="w-full divide-y">
                            <div v-for="review in reviewsProducto.slice(0, 5)" class="py-5">
                                <header class="flex justify-between">
                                    <div class="flex gap-2 items-center">
                                        <p class="text-md">{{ review.name }}</p>
                                        <PuntuacionComp :rating="review.stars" :customClass="'relative w-4 h-4'" />
                                    </div>
                                    <p class="text-gray-600 font-light text-sm">{{ formatData(review.created_at) }}</p>
                                </header>
                                <section>
                                    <p class="text-lg text-gray-800">{{ review.producto.nombre }}</p>
                                    <p class="text-gray-800 font-light">{{ review.comment }}</p>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref, watch, computed, nextTick } from 'vue';
import { Chart } from 'chart.js/auto';
import { useAuthStore } from '@/stores/authStore';
import Loading from '@/components/loading.vue';
import PuntuacionComp from '~/components/PuntuacionComp.vue';

definePageMeta({
    layout: 'admin',
});

const authStore = useAuthStore();
const { $communicationManager } = useNuxtApp();

const chartCanvas = ref(null);
let chartInstance = null;
const chartReady = ref(false);

const periods = ['week', 'month', 'year'];
const periodLabels = {
    week: 'Última setmana',
    month: 'Últim mes',
    year: 'Any actual'
};

const selectedPeriod = ref('week');
const stats = ref({ labels: [], data: [], average: 0 });
const topClients = ref(null);
const topProducts = ref(null);
const uniqueClients = ref(0);
const topCurrentSelected = ref(1);
const rating = ref(0);
const ratingBars = ref([]);
const reviewsComercio = ref([]);
const reviewsProducto = ref([]);
const loading = ref(false);

function currentSelected(value) {
    topCurrentSelected.value = value;
}

function formatData(dateStr) {
    if (!dateStr) return '';
    const date = new Date(dateStr);
    const options = { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit' };
    return date.toLocaleString('es-ES', options);
}

const totalSales = computed(() => stats.value.data.reduce((a, b) => a + b, 0));

const destroyChart = () => {
    if (chartInstance) {
        chartInstance.destroy();
        chartInstance = null;
    }
};

// Colores principales
const chartColors = {
    primary: '#4F46E5',
    secondary: '#818CF8',
    background: '#F8FAFC'
};

const formatCurrency = (value) => {
    return new Intl.NumberFormat('ca-ES', {
        style: 'currency',
        currency: 'EUR',
        minimumFractionDigits: 2
    }).format(value);
};

const hasEnoughData = computed(() => {
    return stats.value.labels?.length > 1;
});

const loadChart = () => {
    try {
        if (chartInstance) {
            chartInstance.destroy();
            chartInstance = null;
        }

        const ctx = chartCanvas.value.getContext('2d');

        chartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: stats.value.labels,
                datasets: [{
                    label: 'Vendes',
                    data: stats.value.data,
                    borderColor: '#4F46E5',
                    tension: 0.4,
                    fill: false,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true },
                    x: {}
                }
            }
        });

    } catch (error) {
        console.error('Error al cargar el gráfico:', error);
    }
};

// Modifica la función fetchStats:
const fetchStats = async () => {
    loading.value = true;
    try {
        destroyChart();

        const data = await $communicationManager.getStatsSales(selectedPeriod.value);

        stats.value = {
            labels: data?.labels || [],
            data: data?.data?.map(Number) || [],
            average: Number(data?.average) || 0
        };

        // 1. Desactivar loading ANTES de renderizar
        loading.value = false;

        // 2. Esperar 2 ciclos de actualización del DOM
        await nextTick();

        // 3. Renderizar después de que el canvas esté disponible
        if (hasEnoughData.value) {
            loadChart();
        }

    } catch (error) {
        console.error('Error:', error);
        stats.value = { labels: [], data: [], average: 0 };
        loading.value = false;
    }
};

watch(selectedPeriod, fetchStats, { immediate: true });

async function topStats() {
    try {
        const data = await $communicationManager.getTopStats();

        topClients.value = data.topClients;
        topProducts.value = data.topProducts;
        uniqueClients.value = data.uniqueClients;
        console.log(data)
    } catch (error) {
        console.error(error);
    }
}

async function ratingStats() {
    try {
        const totalRating = await $communicationManager.getRating();
        const barsRatingFetch = await $communicationManager.getRatingData();
        console.log(barsRatingFetch);
        ratingBars.value = barsRatingFetch;
        rating.value = totalRating.rating;
    } catch (error) {
        console.error(error);
    }
}

function calcularPorcentaje(star) {
    if (ratingBars.value?.rating) {
        const count = ratingBars.value.rating[star]?.count || 0;
        const total = ratingBars.value.totalRatings || 0;

        const porcentaje = total > 0 ? ((count / total) * 100).toFixed(2) : 0;
        return porcentaje;
    }
}

async function getReviews() {
    try {
        const comercios = await $communicationManager.getReviewsComercio();
        const productos = await $communicationManager.getReviewsProducto();
        reviewsComercio.value = comercios.reviews;
        reviewsProducto.value = productos.reviews;
        console.log({ "comercios": reviewsComercio.value, "productos": reviewsProducto.value });
    } catch (error) {
        console.error(error);
    }
}

// Ciclo de vida mejorado
onMounted(async () => {
    if (!authStore.isAuthenticated || !authStore.comercio) {
        navigateTo('/login');
    }
    topStats();
    ratingStats();
    getReviews();
});
onBeforeUnmount
</script>