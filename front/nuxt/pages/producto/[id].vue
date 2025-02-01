<template>
    <div
        class="min-h-screen flex flex-col bg-white text-gray-900 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300">
        <div id="header" class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 shadow-lg rounded-lg">
            <div class="text-xl text-gray-700 dark:text-gray-300 cursor-pointer">
                ←
            </div>

            <div class="flex-1 text-center text-lg font-semibold text-gray-800 dark:text-gray-200 truncate max-w-[calc(100%-2rem)]"
                :title="producto?.comercio || 'Nombre del comercio no disponible'">
                {{ producto?.comercio?.length > 18 ? producto.comercio.slice(0, 18) + '...' : producto?.comercio ||
                    'Nombre del comercio no disponible' }}
            </div>

            <div id="corazon" class="w-8 h-8 flex items-center justify-center cursor-pointer">
                <img src="../../assets/heart.svg" alt="Heart Icon" class="w-full h-full object-contain" />
            </div>
        </div>

        <div id="imgs" class="h-[400px] w-full max-w-[900px] mx-auto overflow-hidden">
            <img :src="producto?.imagen" alt="Imagen del producto" class="h-full w-full object-contain" />
        </div>

        <div id="infoAdicional" class="p-4 flex flex-col flex-grow">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 text-justify">
                {{ producto?.nombre || 'Nombre no disponible' }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 mt-2 text-justify">
                {{ producto?.descripcion || 'Descripción no disponible' }}
            </p>
        </div>

        <div id="footer"
            class="flex items-center justify-between p-4 mt-auto bg-gray-50 dark:bg-gray-800 rounded-lg shadow-footer">
            <div id="precio" class="text-xl font-semibold text-gray-800 dark:text-gray-200 text-center"
                style="width: 50%;">
                {{ producto?.precio ? `${producto.precio.toFixed(2)}€` : 'Precio no disponible' }}
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
    import { useRoute } from "vue-router";
    import ButtonBasketComp from "../../components/ButtonBasketComp.vue";

    const route = useRoute();
    const { $communicationManager } = useNuxtApp();
    const producto = ref(null);
    const selectedColor = ref(null);
    const selectedSize = ref(null);

    const fetchProducto = async () => {
        try {
            const id = route.params.id;
            const response = await $communicationManager.getProductoById(id);

            if (response) {
                producto.value = response;

                if (producto.value.varientes && producto.value.varientes.length > 0) {
                    selectedColor.value = producto.value.varientes[0].color;
                    selectedSize.value = producto.value.varientes[0];
                }
            }
        } catch (error) {
            console.error("Error obteniendo el producto:", error);
        }
    };

    onMounted(() => {
        fetchProducto();
    });
</script>

<style scoped>
    @import '../../assets/productoConcreto.css';
</style>