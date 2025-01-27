<template>
    <button @click="addToBasket">
        <img :src="shoppingBasketIcon" alt="Icono de carrito" class="svg-icon" />
    </button>
</template>

<script>
import shoppingBasketIcon from '../assets/shopping-basket.svg';
import { useComercioStore } from '@/stores/comercioStore';

export default {
    props: {
        producto: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            shoppingBasketIcon,
        };
    },
    methods: {
        addToBasket() {
            const comercioStore = useComercioStore();
            comercioStore.addToBasket(this.producto);
            if(confirm('¿Quieres ir a la cesta?')){
                navigateTo('/cistella');
            }
        },
    },
};
</script>

<style scoped>
    button {
        padding: 10px 40px;
        background-color: #007bff;
        color: white;
        border: none;
        font-size: 10px;
        border-radius: 5px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    button:hover {
        background-color: #0056b3;
    }

    .svg-icon {
        width: 30px;
        height: 30px;
    }
</style>
