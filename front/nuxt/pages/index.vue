<template>
    <div id="banner">
        <div id="carousel" class="transition-transform duration-500 ease-in-out">
            <img
                src="https://static.vecteezy.com/system/resources/previews/002/506/587/non_2x/flash-sale-discount-banner-promotion-background-vector.jpg">
            <img
                src="https://s.tmimgcdn.com/scr/1200x750/343900/banner-de-venta-de-color-azul-degradado-vectorial-y-idea-de-fondo-azul-de-promocion-de-descuento-de-banner-de-venta_343959-original.jpg">
            <img
                src="https://img.freepik.com/vector-premium/promocion-plantilla-banner-descuento-venta-flash_7087-866.jpg">
        </div>
    </div>
    <div id="contain-categorias">
        <div id="categorias" class="flex">
            <div v-for="categoria in categorias" :key="categoria.id" class="box-categoria"></div>
        </div>
    </div>
    <div id="contain-productos">
        <h1 class="titulo-productos">Últimes tendències</h1>
        <div id="productos">
            <productoComp v-for="(producto, index) in productos" :key="index" :id="producto.id" :img="producto.img"
                :title="producto.nombre" :price="producto.precio" :comercio="producto.comercio"
                @click="mostrarIdProducto(producto.id)">
            </productoComp>
        </div>
    </div>
</template>

<script setup>
    import { ref, onMounted } from "vue";
    import { useRouter } from "vue-router";
    import { useAuthStore } from "~/stores/authStore";

    const productos = ref([]);
    const categorias = ref([]);
    const router = useRouter();
    const authStore = useAuthStore();
    const { $communicationManager } = useNuxtApp();

    async function fetchProductos() {
        try {
            const response = await $communicationManager.getProductos();
            if (response && response.data) {
                productos.value = response.data;
            } else {
                console.error("Error al obtener los productos");
            }
        } catch (error) {
            console.error("Error en la petición:", error);
        }
    }

    async function fetchCategorias() {
        try {
            const responseCategorias = await $communicationManager.getCategoriasGenerales();
            if (responseCategorias) {
                categorias.value = responseCategorias;
            } else {
                console.error("Error al obtener las categorías");
            }
        } catch (error) {
            console.error("Error en la petición:", error);
        }
    }


    function mostrarIdProducto(id) {
        router.push(`/producto/${id}`);
    }

    onMounted(() => {
        let currentIndex = 0;
        const images = document.querySelectorAll("#carousel img");
        const totalImages = images.length;

        function moveCarousel() {
            currentIndex++;
            if (currentIndex >= totalImages) currentIndex = 0;
            document.querySelector("#carousel").style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        setInterval(moveCarousel, 5000);
        fetchProductos();
        fetchCategorias();
    });
</script>



<style scoped>
@import '../assets/index.css';
</style>