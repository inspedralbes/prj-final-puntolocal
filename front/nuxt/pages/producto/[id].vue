<template>
    <div class="product-card" style="margin-top: 30px;">
        <!-- Encabezado -->
        <div class="header">
            <button class="back-button">←</button>
            <div>
                <h2 class="store-name">{{ producto.comercio[1] }}</h2>
                <p class="product-header">FICHA DE PRODUCTO</p>
            </div>
            <div class="icons">
                <button class="icon-button">
                    <img src="@/assets/heart.svg" alt="Favorito" class="icon-image" />
                </button>
            </div>
        </div>

        <!-- Imágenes -->
        <div class="image-gallery">
            <button class="nav-button left" @click="prevImage">‹</button>
            <div class="image-carousel" :style="carouselStyle">
                <img
                    v-for="(imagen, index) in producto.imagenes"
                    :key="index"
                    :src="imagen"
                    :alt="'Imagen ' + index"
                    :class="{ active: currentImage === index }"
                />
            </div>
            <button class="nav-button right" @click="nextImage">›</button>
            <div class="dots">
                <span
                    v-for="(dot, index) in producto.imagenes"
                    :key="index"
                    class="dot"
                    :class="{ active: currentImage === index }"
                    @click="setImage(index)"
                ></span>
            </div>
        </div>

        <!-- Información del producto -->
        <div class="details">
            <p><strong>Valoración:</strong> ★ {{ producto.valoracion }}</p>
            <p class="product-description">{{ producto.descripcion }}</p>

            <div class="options">
                <div class="info-div">
                    <h1>Size</h1>
                    <div class="options-grid">
                        <button
                            id="tallas"
                            v-for="size in producto.tamaños"
                            :key="size"
                            class="option-button"
                        >
                            {{ size }}
                        </button>
                    </div>
                </div>
                <div class="info-div" style="margin-top: 20px;">
                    <h1>Color</h1>
                    <div class="options-grid">
                        <button
                            id="colores"
                            v-for="color in producto.colores"
                            :key="color.nombre"
                            class="option-button"
                            :style="{ backgroundColor: color.codigo }"
                        ></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Precio y botón -->
        <div class="footer">
            <p class="price">€{{ producto.precio.toFixed(2) }}</p>
            <ButtonBasketComp />
        </div>
    </div>
</template>

<script>
import ButtonBasketComp from "./components/ButtonBasketComp.vue";

export default {
    components: {
        ButtonBasketComp,
    },
    data() {
        return {
            currentImage: 0, // Índice de la imagen actual
            producto: {
                id: 1,
                nombre: "Camiseta de Algodón",
                descripcion: "Camiseta cómoda y ligera, ideal para el verano.",
                stock_general: 150,
                precio: 19.99,
                valoracion: 4.9,
                imagenes: [
                    "https://imgs.search.brave.com/zLz9LQZ7X_HueDRlt4jt4hM7bd8DNZAS5fU2qTI2FTA/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9zdGF0/aWMud2l4c3RhdGlj/LmNvbS9tZWRpYS9m/OTE5NWZfNjY0OTI0/MzYwNTk3NGZkYzg4/OWFiZjRlMzA4NzM4/NzV-bXYyLnBuZy92/MS9maWxsL3dfNzQz/LGhfNzQzLGFsX2Ms/cV85MCx1c21fMC42/Nl8xLjAwXzAuMDEs/ZW5jX2F2aWYscXVh/bGl0eV9hdXRvL3Jv/bGV4LnBuZw",
                    "camiseta2.jpg",
                    "camiseta3.jpg"
                ],
                comercio: ["1", "Nombre del Comercio"],
                tamaños: ["S", "M", "L", "XL"],
                colores: [
                    { nombre: "Red", codigo: "#ff0000" },
                    { nombre: "Blue", codigo: "#0000ff" },
                    { nombre: "Green", codigo: "#008000" },
                    { nombre: "Black", codigo: "#000000" }
                ]
            }
        };
    },
    methods: {
        nextImage() {
            this.currentImage = (this.currentImage + 1) % this.producto.imagenes.length;
        },
        prevImage() {
            this.currentImage = (this.currentImage - 1 + this.producto.imagenes.length) % this.producto.imagenes.length;
        },
        setImage(index) {
            this.currentImage = index;
        },
    },
    computed: {
        carouselStyle() {
            return {
                transform: `translateX(-${this.currentImage * 100}%)`
            };
        }
    }
};
</script>

<style scoped>
h1{
    font-size: 20px;
}
#colores{
    border-radius: 3000000px;
}
/* Contenedor principal */
.product-card {
    display: flex;
    flex-direction: column;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 10px;
    max-width: 400px;
    margin: auto;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Encabezado */
svg {
    width: 50px;
    height: 50px;
}

#tallas{
    background: black;
    color: white;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.store-name {
    font-size: 1.2em;
    font-weight: bold;
    margin: 0;
    text-align: center;
}

.product-header {
    font-size: 0.9em;
    color: gray;
    text-align: center;
}

.back-button,
.icon-button {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 1.5em;
}

/* Galería de imágenes */
.image-gallery {
    position: relative;
}

.image-carousel {
    display: flex;
    width: 100%;
    transition: transform 0.3s ease-in-out;
}

.image-carousel img {
    min-width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
}

.dots {
    display: flex;
    justify-content: center;
    margin-top: 5px;
}

.dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #ddd;
    margin: 0 3px;
}

.dot.active {
    background-color: #007bff;
}

/* Detalles del producto */
.details {
    margin-top: 10px;
}

.product-description {
    font-size: 0.9em;
    margin: 5px 0;
}

.options {
    justify-content: space-between;
    margin: 10px 0;
}

.options-grid {
    display: flex;
}

.option-button {
    border: 1px solid #ddd;
    width: 40px;
    height: 40px;
    margin-right: 5px;
    text-align: center;
    cursor: pointer;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.option-button:hover {
    background-color: #007bff;
    color: white;
}

.footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
}

.price {
    font-size: 1.5em;
    font-weight: bold;
    margin: 0;
    color: #333;
}

@media (min-width: 600px) {
    .product-card {
        max-width: 600px;
    }
}

.image-gallery {
    position: relative;
    overflow: hidden;
    width: 100%;
    height: 300px;
    /* Ajusta según sea necesario */
}

.nav-button {
    position: absolute;
    top: 25%;
    transform: translateY(-50%);
    background: black;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 30px;
}

.nav-button.left {
    left: 10px;
}

.nav-button.right {
    right: 10px;
}

.dots {
    display: flex;
    justify-content: center;
    margin-top: 5px;
}

.dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #ddd;
    margin: 0 3px;
    cursor: pointer;
}

.dot.active {
    background-color: #007bff;
}
</style>
