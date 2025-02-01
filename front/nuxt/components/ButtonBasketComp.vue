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
        border: none;
        display: flex;
        color: white;
        cursor: pointer;
        padding: 10px 40px;
        border-radius: 5px;
        align-items: center;
        justify-content: center;
        background-color: #007bff;
    }
    button:hover {
        background-color: #0056b3;
    }

    .svg-icon {
        width: 30px;
        height: 30px;
    }
</style>