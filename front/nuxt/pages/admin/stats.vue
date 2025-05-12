<template>
    <div class="bg-gray-50 p-6 md:mt-16 grid grid-cols-6 gap-5">
        <section class="col-span-4">
            <div v-if="loading" class="text-center py-8">
                <Loading size="xl" color="#4F46E5" />
            </div>

            <div v-else class="bg-white p-4 rounded-xl border border-gray-200 h-[450px]">
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
                            <p class="text-sm text-gray-400">Es necessiten múltiples punts de dades per generar una
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
        <section class="col-span-2">
            <div v-if="loading" class="text-center py-8">
                <Loading size="xl" color="#4F46E5" />
            </div>

            <div v-else class="bg-white p-4 rounded-xl border border-gray-200 h-[450px]">
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
                    <div class="flex flex-col justify-center py-3" v-for="producto in topProducts" :key="producto.producto_id">
                        <div class="flex justify-between">
                            <section class="flex gap-3">
                                <img :src="producto.image || '#'" alt="" width="50px" height="50px" class="rounded-md border">
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
                        <div class="flex flex-col justify-center py-3" v-for="client in topClients" :key="client.client_id">
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
        <section class="col-span-3">
            <div v-if="loading" class="text-center py-8">
                <Loading size="xl" color="#4F46E5" />
            </div>

            <div v-else class="bg-white p-6 rounded-xl border border-gray-200 h-[180px] flex flex-col justify-center">
                <header class="flex flex-col md:flex-row justify-between items-start mb-2">
                    <h3 class="text-xl font-bold text-gray-800 mb-2 md:mb-0">
                        Clients
                    </h3>
                </header>
                <section>
                    <p class="text-gray-700 text-xl"><span class="text-green-400 text-md">% subida</span> 228 clients
                        totals aquest últim mes</p>
                </section>
            </div>
        </section>
        <section class="col-span-3">
            <div class="bg-white border border-gray-200 rounded-lg p-6 h-[180px]">
                <div class="w-full">
                    <div class="flex items-center gap-8">
                        <div class="flex flex-col items-center">
                            <h3 class="mb-2 text-base font-normal text-gray-500 dark:text-gray-400">Valoracions</h3>
                            <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
                                3,3
                            </span>
                            <PuntuacionComp :rating="3.5" />
                        </div>
                        <div class="flex-grow">
                            <div class="flex items-center mb-2">
                                <div class="mr-5 text-sm font-medium dark:text-white">5</div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                </div>
                            </div>
                            <div class="flex items-center mb-2">
                                <div class="mr-5 text-sm font-medium dark:text-white">4</div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                </div>
                            </div>
                            <div class="flex items-center mb-2">
                                <div class="mr-5 text-sm font-medium dark:text-white">3</div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                </div>
                            </div>
                            <div class="flex items-center mb-2">
                                <div class="mr-5 text-sm font-medium dark:text-white">2</div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                </div>
                            </div>
                            <div class="flex items-center mb-2">
                                <div class="mr-5 text-sm font-medium dark:text-white">1</div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="traffic-channels-chart" class="w-full"></div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref, watch, computed, nextTick } from 'vue';
import { Chart } from 'chart.js/auto';
import { useAuthStore } from '@/stores/authStore';
import Loading from '@/components/loading.vue';
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
const topCurrentSelected = ref(1);
const loading = ref(false);

function currentSelected(value) {
    topCurrentSelected.value = value;
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
});
onBeforeUnmount
</script>