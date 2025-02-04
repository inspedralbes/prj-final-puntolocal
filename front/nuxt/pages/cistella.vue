<script setup>
definePageMeta({
    layout: false,
});

import { computed, onMounted, ref } from 'vue';
import { useComercioStore } from '@/stores/comercioStore';
import { useNuxtApp } from '#app';
import shoppingBasketIcon from '../assets/shopping-basket.svg';

const comercioStore = useComercioStore();
const { $communicationManager } = useNuxtApp();

const comercios = ref({});

const groups = reactive([]);

// Fetch de los comercios que tienen id en la cesta
onMounted(async () => {
    const uniqueComercioIds = [...new Set(comercioStore.cesta.map(item => item.comercio_id))];
    await Promise.all(uniqueComercioIds.map(async (id) => {
        const comercioData = await $communicationManager.getComercio(id);
        if (comercioData && comercioData.nombre) {
            comercios.value[id] = comercioData.nombre;
        }
    }));
});

// Agrupos los productos por el nombre del comercio
const groupedCesta = computed(() => {
    return comercioStore.cesta.reduce((groups, item) => {
        const comercioNombre = comercios.value[item.comercio_id] || 'Cargando...';
        if (!groups[comercioNombre]) {
            groups[comercioNombre] = [];
        }
        groups[comercioNombre].push(item);
        return groups;
    }, {});
});

// Calculate total for a single store
const storeTotal = (storeName) => {
    return groupedCesta.value[storeName].reduce((acc, item) => acc + item.precio * item.cantidad, 0);
};

const comprar = () => {
    console.log('Aqui deberemos redirigir a la vista de compra')
}

</script>

<template>
    <header class="border-b border-gray-200 dsadsad"        >
        <div>

        </div>
    </header>
    <div>
        <div v-if="Object.keys(groupedCesta).length === 0">
            <p>La cistella esta buida.</p>
        </div>
        <div v-else>
            <div v-for="(items, storeName) in groupedCesta" :key="storeName"
                class="bg-gray-100 mb-8 border rounded-lg p-4 m-4">
                <h2 class="text-center font-bold text-xl mb-4">{{ storeName }}</h2>
                <div v-for="item in items" :key="item.id" class="mb-4 flex items-center">
                    <button @click="comercioStore.removeFromBasket(item.id)" class="mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-trash3-fill" viewBox="0 0 16 16">
                            <path
                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                        </svg>
                    </button>
                    <img :src="item.imagen" alt="Product Image" class="w-[80px] h-[80px] mr-4" />
                    <div class="flex flex-col">
                        <div class="flex mb-2">
                            <h3 class="mr-2 line-clamp-1 break-all max-sm:w-[178px]">{{ item.nombre }}</h3>
                            <p>{{ item.precio.toFixed(2) }}€</p>
                        </div>
                        <div class="text-lg font-bold">
                            <button @click="comercioStore.decreaseProductQuantity(item.id)"> - </button>
                            {{ item.cantidad }}
                            <button @click="comercioStore.increaseProductQuantity(item.id)"> + </button>
                        </div>
                    </div>
                </div>
                <div class="text-right font-bold">
                    <p>Total: {{ storeTotal(storeName).toFixed(2) }}€</p>
                </div>
            </div>
            <div id="footer"
                class="flex items-center justify-between p-4 mt-auto bg-gray-50 dark:bg-gray-800 shadow-footer">
                <div id="precio" class="font-semibold text-gray-800 dark:text-gray-200">
                    <p class="text-gray-600 font-light">Precio total:</p>
                    <h3 class="text-2xl">
                        <p>{{ comercioStore.totalPrice.toFixed(2) }}€</p>
                    </h3>
                </div>
                <div id="carrito" class="flex items-center space-x-4">
                    <ButtonComp @click="comprar">
                        Checkout ({{ comercioStore.totalItems }})
                    </ButtonComp>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
header {
    height: 100px;
}

header div {}

#footer {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    margin: 0 auto;
}
</style>
