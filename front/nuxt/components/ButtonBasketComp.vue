<template>
    <button @click="addToBasket">
        <img :src="shoppingBasketIcon" alt="Añadir al carrito" class="svg-icon" />
    </button>
</template>

<script>
import shoppingBasketIcon from '../assets/shopping-basket.svg';

export default {
    data() {
        return {
            shoppingBasketIcon,
        };
    },
    methods: {
        addToBasket() {
            console.log("Producto añadido al carrito");
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
