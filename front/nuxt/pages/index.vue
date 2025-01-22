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
            <productoComp img="https://catalogosparaempresas.com/wp-content/uploads/2022/07/ice2-1.jpg" title="Zapatilla deportiva negra" price="24,99"></productoComp>
            <productoComp img="https://static.carrefour.es/hd_510x_/crs/cdn_static/catalog/hd/424728_00_1.jpg" title="iPhone 13 128GB Apple - Blanco estrella" price="539,00"></productoComp>
            <productoComp img="https://www.markamania.es/1017148-large_default/pantalon-deportivo-de-corte-recto-roly-new-astun.jpg" title="Pantalon Jean Negro Ajustado Elastico" price="19,99" ></productoComp>
            <productoComp img="https://www.shutterstock.com/image-photo/big-diamond-solitaire-necklace-chain-600nw-2083887445.jpg" title="Collar de diamante para dama" price="69,99"></productoComp>
        </div>
    </div>
</template>

<style scoped>
#banner {
    width: 100%;
    height: 260px;
    display: flex;
    align-items: center;
    overflow: hidden;
    position: relative;
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
    align-items: center;
    overflow: scroll;
    box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
    background-color: #eff1f3;
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
    box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
    margin-left: 20px;
    border-radius: 10px;
    background-color: white;
}

#contain-productos{
    padding: 20px;
}

#productos {
    width: 100%;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.titulo-productos{
    font-size: 20px;
    font-weight: 500;
    margin-top: 0px;
    margin-bottom: 10px;
}
</style>

<script setup>
import { onMounted } from 'vue';
import { NuxtLink } from '#components';

onMounted(() => {
    let currentIndex = 0;
    const images = document.querySelectorAll("#carousel img");
    const totalImages = images.length;

    function moveCarousel() {
        currentIndex++;

        if (currentIndex >= totalImages) {
            currentIndex = 0;
        }
        const offset = -currentIndex * 100; // Calcular el desplazamiento
        document.querySelector("#carousel").style.transform = `translateX(${offset}%)`;
    }

    // Mueve el carrusel cada 5 segundos
    setInterval(moveCarousel, 5000);
});
</script>