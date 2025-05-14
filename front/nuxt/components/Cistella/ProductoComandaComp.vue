<script setup>
import { useComercioStore } from '@/stores/comercioStore';
import { useRuntimeConfig } from "#imports";

const config = useRuntimeConfig();
const baseUrl = config.public.apiBaseUrl;


const comercioStore = useComercioStore();

defineProps({
    producto: {
        type: Object,
        required: true
    }
})
</script>

<template>
    <button @click="comercioStore.removeFromBasket(producto.id)" class="mr-3">
        <svg viewBox="0 0 24 24" fill="none" width="1.3em" height="1.3em" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M7 4C7 2.34315 8.34315 1 10 1H14C15.6569 1 17 2.34315 17 4V5H21C21.5523 5 22 5.44772 22 6C22 6.55228 21.5523 7 21 7H19.9394L19.1153 20.1871C19.0164 21.7682 17.7053 23 16.1211 23H7.8789C6.29471 23 4.98356 21.7682 4.88474 20.1871L4.06055 7H3C2.44772 7 2 6.55228 2 6C2 5.44772 2.44772 5 3 5H7V4ZM9 5H15V4C15 3.44772 14.5523 3 14 3H10C9.44772 3 9 3.44772 9 4V5ZM6.06445 7L6.88085 20.0624C6.91379 20.5894 7.35084 21 7.8789 21H16.1211C16.6492 21 17.0862 20.5894 17.1191 20.0624L17.9355 7H6.06445Z"
                    fill="#000000"></path>
            </g>
        </svg>
    </button>
    <div id="contain-image" class="mr-4 w-[80px] h-[100px] overflow-hidden">
        <img :src="`${baseUrl}/storage/${producto.imagen}`" alt="" />
    </div>
    <div class="flex flex-col w-full justify-between flex-grow">
        <div class="flex justify-between">
            <div class="w-[75%]">
                <h3 class="text-lg font-medium line-clamp-2">{{ producto.nombre }}</h3>
            </div>
            <p>{{ producto?.precio?.toFixed(2) }}€</p>
        </div>
        <div id="btn-quantity" class="text-lg flex items-center mb-1">
            <button @click="comercioStore.decreaseProductQuantity(producto.id)"
                class="border w-[1.5em] h-[1.5em] flex items-center justify-center">
                <svg width="1.1em" height="1.1em" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                    </g>
                    <g id="SVGRepo_iconCarrier">
                        <g>
                            <path fill="none" d="M0 0h24v24H0z"></path>
                            <path d="M5 11h14v2H5z"></path>
                        </g>
                    </g>
                </svg>
            </button>
            <h4 class="border-t border-b min-w-[1.5em] h-[1.5em] flex items-center justify-center">
                {{ producto.cantidad }}</h4>
            <button @click="comercioStore.increaseProductQuantity(producto.id)"
                class="border w-[1.5em] h-[1.5em] flex items-center justify-center">
                +
            </button>
        </div>
    </div>
</template>

<style scoped>
#contain-image {
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    border-radius: 5px;
    border: 1px solid #dde0e2;
}
</style>