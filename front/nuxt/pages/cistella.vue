<script setup>
import shoppingBasketIcon from '../assets/shopping-basket.svg';
import { useComercioStore } from '@/stores/comercioStore';

function filtrarProductosPorTienda(){
    const comercioStore = useComercioStore();

    console.log(comercioStore.cesta)

}

</script>

<template>
    <button @click="filtrarProductosPorTienda">Pulsame</button>

</template>


