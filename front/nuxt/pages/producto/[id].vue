<template>
    <div
        class="min-h-screen flex flex-col bg-white text-gray-900 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300">
        <div id="header" class="relative flex items-center justify-between p-4 bg-white dark:bg-gray-800 shadow-lg rounded-lg">
            <div @click="goBack" class="text-xl text-gray-700 dark:text-gray-300 cursor-pointer">
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

            <div
                class="flex-1 text-center text-lg font-semibold text-gray-800 dark:text-gray-200 max-w-[calc(100%-2rem)]">
                <h3 @click="irAComercio" class="cursor-pointer text-blue-500 hover:underline">
                    {{ producto?.comercio || 'Nombre del comercio no disponible' }}
                </h3>
            </div>

            <div id="corazon" class="w-16 h-8 flex items-center justify-between cursor-pointer">
                <svg width="1.5em" height="1.5em" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                    </path>
                </svg>
                <NuxtLink to="/cistella">
                    <svg width="1.7em" height="1.7em" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M8 12L8 8C8 5.79086 9.79086 4 12 4V4C14.2091 4 16 5.79086 16 8L16 12" stroke="#000000"
                                stroke-width="1.3" stroke-linecap="round"></path>
                            <path
                                d="M3.69435 12.6678C3.83942 10.9269 3.91196 10.0565 4.48605 9.52824C5.06013 9 5.9336 9 7.68053 9H16.3195C18.0664 9 18.9399 9 19.514 9.52824C20.088 10.0565 20.1606 10.9269 20.3057 12.6678L20.8195 18.8339C20.904 19.8474 20.9462 20.3542 20.6491 20.6771C20.352 21 19.8435 21 18.8264 21H5.1736C4.15655 21 3.64802 21 3.35092 20.6771C3.05382 20.3542 3.09605 19.8474 3.18051 18.8339L3.69435 12.6678Z"
                                stroke="#000000" stroke-width="1.3"></path>
                        </g>
                    </svg>
                </NuxtLink>
            </div>
        </div>

        <div id="imgs" class="h-[400px] w-full max-w-[900px] mx-auto overflow-hidden">
            <img :src="producto?.imagen ? `http://localhost:8000/storage/${producto.imagen}` : 'http://localhost:8000/storage/productos/default-image.webp'"
                alt="Imagen del producto" class="h-full w-full object-contain" />
        </div>

        <div id="infoAdicional" class="p-4 flex flex-col flex-grow">
            <div id="contain-title" class="flex items-center">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                    {{ producto?.nombre || 'Nombre no disponible' }}
                </h2>
                <span class="flex items-center">
                    <svg width="1.5em" height="1.5em" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg"
                        fill="#f7ad23">
                        <g id="SVGRepo_iconCarrier">
                            <path fill="#f7ad23"
                                d="m512 747.84 228.16 119.936a6.4 6.4 0 0 0 9.28-6.72l-43.52-254.08 184.512-179.904a6.4 6.4 0 0 0-3.52-10.88l-255.104-37.12L517.76 147.904a6.4 6.4 0 0 0-11.52 0L392.192 379.072l-255.104 37.12a6.4 6.4 0 0 0-3.52 10.88L318.08 606.976l-43.584 254.08a6.4 6.4 0 0 0 9.28 6.72L512 747.84z">
                            </path>
                        </g>
                    </svg>
                    <h3 class="ml-1 text-gray-600 font-bold text-xl dark:text-gray-400 mt-1">{{ producto?.valoracion ||
                        '3.9' }}</h3>
                </span>
            </div>
            <p class="text-gray-600 dark:text-gray-400 mt-2 text-justify">
                {{ producto?.descripcion || 'Descripción no disponible' }}
            </p>
        </div>

        <div v-if="producto" id="footer"
            class="flex items-center justify-between pt-4 pb-4 pr-4 mt-auto bg-gray-50 dark:bg-gray-800 rounded-lg shadow-footer">
            <div id="precio" class="text-xl font-semibold text-gray-800 dark:text-gray-200 m-auto">
                <h3 class="text-2xl font-bold">
                    {{ producto?.precio ? `${producto.precio.toFixed(2)} €` : 'Precio no disponible' }}
                </h3>
            </div>

            <div id="carrito" class="flex items-center space-x-4">
                <ButtonBasketComp :producto="producto" />
            </div>
        </div>
    </div>
</template>

<script setup>
    definePageMeta({
        layout: false,
    });

    import { useNuxtApp } from "#app";
    import { ref, onMounted } from "vue";
    import { useRoute, useRouter } from "vue-router";
    import ButtonBasketComp from "../../components/ButtonBasketComp.vue";

    const route = useRoute();
    const router = useRouter();
    const producto = ref(null);
    const selectedSize = ref(null);
    const selectedColor = ref(null);
    const { $communicationManager } = useNuxtApp();

    const fetchProducto = async () => {
        try {
            const id = route.params.id;
            const response = await $communicationManager.getProductoById(id);
            if (response) {
                producto.value = response;
                console.log(producto.value);
                if (producto.value.varientes && producto.value.varientes.length > 0) {
                    selectedColor.value = producto.value.varientes[0].color;
                    selectedSize.value = producto.value.varientes[0];
                }
            }
        } catch (error) {
            console.error("Error obteniendo el producto:", error);
        }
    };

    const goBack = () => {
        router.back();
    };

    const irAComercio = () => {
        if (producto.value && producto.value.comercio_id) {
            router.push(`/comercio/${producto.value.comercio_id}`);
        } else {
            console.error("No se encontró el ID del comercio.");
        }
    };

    onMounted(() => {
        fetchProducto();
    });
</script>


<style scoped>
    @import '../../assets/productoConcreto.css';
</style>