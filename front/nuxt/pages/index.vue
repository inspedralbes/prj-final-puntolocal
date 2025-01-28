<template>
    <div id="banner">
        <div id="carousel" class="transition-transform duration-500 ease-in-out">
            <img src="https://static.vecteezy.com/system/resources/previews/002/506/587/non_2x/flash-sale-discount-banner-promotion-background-vector.jpg">
            <img src="https://s.tmimgcdn.com/scr/1200x750/343900/banner-de-venta-de-color-azul-degradado-vectorial-y-idea-de-fondo-azul-de-promocion-de-descuento-de-banner-de-venta_343959-original.jpg">
            <img src="https://img.freepik.com/vector-premium/promocion-plantilla-banner-descuento-venta-flash_7087-866.jpg">
        </div>
    </div>
    <div id="contain-categorias">
        <div id="categorias" class="flex">
            <div class="box-categoria">
                <img src="" alt="">
            </div>
            <div class="box-categoria"></div>
            <div class="box-categoria"></div>
            <div class="box-categoria"></div>
            <div class="box-categoria"></div>
            <div class="box-categoria"></div>
        </div>
    </div>
    <div id="contain-productos">
        <h1 class="titulo-productos">Ultimes tendències</h1>
        <div id="productos">
            <productoComp v-for="(producto, index) in productos" :key="index"
                :img="producto.img || 'https://via.placeholder.com/150'"
                :title="producto.nombre"
                :price="producto.precio"
                :comercio="producto.comercio"
                ></productoComp>
        </div>
    </div>
</template>

<style scoped>
    #banner {
        width: 100%;
        height: 260px;
        display: flex;
        overflow: hidden;
        position: relative;
        align-items: center;
    }

    #carousel {
        display: flex;
        align-items: center;
    }

    #carousel img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    #contain-categorias {
        width: 100%;
        height: 110px;
        display: flex;
        overflow: scroll;
        align-items: center;
        background-color: #eff1f3;
        box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
    }

    #contain-categorias::-webkit-scrollbar {
        display: none;
    }

    #categorias {
        padding-right: 20px;
    }

    #categorias .box-categoria {
        width: 80px;
        height: 80px;
        margin-left: 20px;
        border-radius: 10px;
        background-color: white;
        box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
    }

    #contain-productos {
        padding: 20px;
    }

    #productos {
        gap: 20px;
        width: 100%;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
    }

    .titulo-productos {
        font-size: 20px;
        margin-top: 0px;
        font-weight: 500;
        margin-bottom: 10px;
    }
</style>

<script setup>
    import { ref, onMounted } from "vue";
    import { useAuthStore } from "~/stores/authStore";

    const { $communicationManager } = useNuxtApp();
    const authStore = useAuthStore();
    const productos = ref([]);

    function seleccionarProductosAleatorios(lista) {
        if (!Array.isArray(lista)) {
            console.error("El parámetro proporcionado no es una lista válida:", lista);
            return [];
        }
        const copiaLista = [...lista];
        const seleccionados = [];
        while (seleccionados.length < 6 && copiaLista.length > 0) {
            const indiceAleatorio = Math.floor(Math.random() * copiaLista.length);
            seleccionados.push(copiaLista[indiceAleatorio]);
            copiaLista.splice(indiceAleatorio, 1);
        }
        return seleccionados;
    }

    async function fetchProductos() {
        try {
            const response = await $communicationManager.getProductos();
            if (response && response.data) {
                const productosRecibidos = response.data;
                productos.value = seleccionarProductosAleatorios(productosRecibidos);
            } else { console.error("Error al obtener los productos"); }
        } catch (error) {
            console.error("Error en la petición:", error);
        }
    }

    onMounted(() => {
        let currentIndex = 0;
        const images = document.querySelectorAll("#carousel img");
        const totalImages = images.length;

        function moveCarousel() {
            currentIndex++;

            if (currentIndex >= totalImages) { currentIndex = 0; }

            const offset = -currentIndex * 100;
            document.querySelector("#carousel").style.transform = `translateX(${offset}%)`;
        }

        setInterval(moveCarousel, 5000);

        fetchProductos();
    });
</script>