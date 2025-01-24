<script setup>
definePageMeta({
    layout: false,
});
</script>

<template>
    <div>
        <!-- Header -->
        <div id="header">
            <div>
                <p id="flecha">←</p>
            </div>

            <div>
                <h3 id="nombre-local"> {{ nombre_local }} </h3>
                <p id="subtitulo">Ficha de producto</p>
            </div>

            <div id="corazon">
                <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                    </path>
                </svg>

            </div>
        </div>

        <div class="product-carousel" @touchstart="handleTouchStart" @touchmove="handleTouchMove"
            @touchend="handleTouchEnd">
            <img :src="selectedVariant.imagenes[currentImage]" :alt="`Imagen del producto (${selectedVariant.color})`"
                class="carousel-image" />
        </div>

        <div class="carousel-pagination">
            <span v-for="(imagen, index) in selectedVariant.imagenes" :key="index"
                :class="{ 'active-dot': currentImage === index }" @click="currentImage = index"></span>
        </div>

        <!-- Product Images -->
        <div class="product-container">


            <!-- Product Details -->
            <div id="nombre-valoracion">
                <h1>{{ producto.nombre }}</h1>
                <div id="puntuacion">
                    <span class="star">★</span> {{ producto.valoracion }}
                </div>
            </div>

            <p id="descripcion">{{ producto.descripcion }}</p>

            <div class="colors-container">
                <p>Color:</p>
                <div class="colors">
                    <button v-for="(color, index) in displayedColors" :key="index" :style="{ backgroundColor: color }"
                        class="color-btn" @click="filterByColor(color)"
                        :class="{ 'active-color': color === selectedColor }">
                    </button>
                </div>
            </div>

            <div class="sizes-container">
                <p>Talla:</p>
                <ul>
                    <li v-for="(variant, index) in filteredVariants" :key="index">
                        <button @click="selectSize(variant)" :class="{ 'active-size': variant === selectedSize }"
                            class="size-btn">
                            {{ variant.size }}
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-content">
                <p id="precio" v-if="selectedSize">{{ selectedSize.price.toFixed(2) }}€</p>
            </div>
            <div class="footer-content">
                <button class="add-to-cart-btn">
                    <ButtonBasketComp />
                </button>
            </div>
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
            currentImage: 0,
            startX: 0,
            endX: 0,
            selectedColor: null,
            selectedSize: null,
            nombre_local: "Los Pollos Hermanos",
            producto: {
                id: 1,
                nombre: "Camiseta de Algodón",
                descripcion: "quia sapiente ratione quas provident fugit, aspernatur iusto!",
                valoracion: 4.9,
                varientes: [
                    {
                        size: "M",
                        color: "red",
                        stock: 10,
                        price: 19.99,
                        imagenes: [
                            "https://imgs.search.brave.com/uXq6fdSqx6oo_Agh0JgoHF71Cy9jVUlC6wgl4-Ox2FQ/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9jb250/ZW50LnRoZXdvc2dy/b3VwLmNvbS9wcm9k/dWN0aW1hZ2UvMTc5/MjEwNzMvMTc5MjEw/NzNfMS5qcGc_aW1w/b2xpY3k9bGlzdGVy",
                            "https://imgs.search.brave.com/kv5cMdd4NJeWH_ElJLsg76i4p_x-91dQGlmHgIL7rko/rs:fit:500:0:0:0/g:ce/aHR0cHM6Ly9zdGF0/aWMucGF0ZWsuY29t/L2ltYWdlcy9hcnRp/Y2xlcy9mYWNlX3do/aXRlLzIyMC81MjA0/R18wMDFfMS5qcGc",
                        ],
                    },
                    {
                        size: "S",
                        color: "blue",
                        stock: 5,
                        price: 40,
                        imagenes: [
                            "https://imgs.search.brave.com/Xgysk_DiRHk7waITeVjN03Mmm1208Al0A1FNj67iw4Y/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/c2Vla3BuZy5jb20v/cG5nL2RldGFpbC8x/NTUtMTU1MTY0N19y/aWNoYXJkLW1pbGxl/LXJtLTUwLTAzLnBu/Zw",
                            "https://imgs.search.brave.com/_rcGOA_4pmDw6pMYpHl3dXmHGJ1sTNxvRT9xl2PrKcU/rs:fit:500:0:0:0/g:ce/aHR0cHM6Ly93d3cu/c2Vla3BuZy5jb20v/cG5nL2RldGFpbC84/MTUtODE1NzI5NF9y/aWNoYXJkLW1pbGxl/LTUwLTAyLnBuZw",
                        ],
                    },
                    {
                        size: "M",
                        color: "blue",
                        stock: 5,
                        price: 40,
                        imagenes: [
                            "https://imgs.search.brave.com/Xgysk_DiRHk7waITeVjN03Mmm1208Al0A1FNj67iw4Y/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/c2Vla3BuZy5jb20v/cG5nL2RldGFpbC8x/NTUtMTU1MTY0N19y/aWNoYXJkLW1pbGxl/LXJtLTUwLTAzLnBu/Zw",
                            "https://imgs.search.brave.com/_rcGOA_4pmDw6pMYpHl3dXmHGJ1sTNxvRT9xl2PrKcU/rs:fit:500:0:0:0/g:ce/aHR0cHM6Ly93d3cu/c2Vla3BuZy5jb20v/cG5nL2RldGFpbC84/MTUtODE1NzI5NF9y/aWNoYXJkLW1pbGxl/LTUwLTAyLnBuZw",
                        ],
                    },
                    {
                        size: "L",
                        color: "blue",
                        stock: 5,
                        price: 40,
                        imagenes: [
                            "https://imgs.search.brave.com/Xgysk_DiRHk7waITeVjN03Mmm1208Al0A1FNj67iw4Y/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/c2Vla3BuZy5jb20v/cG5nL2RldGFpbC8x/NTUtMTU1MTY0N19y/aWNoYXJkLW1pbGxl/LXJtLTUwLTAzLnBu/Zw",
                            "https://imgs.search.brave.com/_rcGOA_4pmDw6pMYpHl3dXmHGJ1sTNxvRT9xl2PrKcU/rs:fit:500:0:0:0/g:ce/aHR0cHM6Ly93d3cu/c2Vla3BuZy5jb20v/cG5nL2RldGFpbC84/MTUtODE1NzI5NF9y/aWNoYXJkLW1pbGxl/LTUwLTAyLnBuZw",
                        ],
                    },
                ],
            },
        };
    },
    computed: {
        displayedColors() {
            const uniqueColors = new Set(this.producto.varientes.map((v) => v.color));
            return [...uniqueColors];
        },
        selectedVariant() {
            return this.filteredVariants[0] || this.producto.varientes[0];
        },
        filteredVariants() {
            return this.producto.varientes.filter((v) => v.color === this.selectedColor);
        },
    },
    methods: {
        filterByColor(color) {
            this.selectedColor = color;
            this.currentImage = 0;
            this.selectedSize = this.filteredVariants[0] || null;
        },
        selectSize(variant) {
            this.selectedSize = variant;
        },
        handleTouchStart(event) {
            // Guarda la posición inicial del toque
            this.startX = event.touches[0].clientX;
        },
        handleTouchMove(event) {
            // Guarda la posición actual del toque mientras se mueve
            this.endX = event.touches[0].clientX;
        },
        handleTouchEnd() {
            // Calcula la diferencia de deslizamiento
            const diffX = this.startX - this.endX;

            if (diffX > 50) {
                // Deslizar a la izquierda (siguiente imagen)
                this.nextImage();
            } else if (diffX < -50) {
                // Deslizar a la derecha (imagen anterior)
                this.prevImage();
            }

            // Reinicia las posiciones
            this.startX = 0;
            this.endX = 0;
        },
        nextImage() {
            // Aumenta el índice de la imagen, con límites
            if (this.currentImage < this.selectedVariant.imagenes.length - 1) {
                this.currentImage++;
            }
        },
        prevImage() {
            // Disminuye el índice de la imagen, con límites
            if (this.currentImage > 0) {
                this.currentImage--;
            }
        },
    },
    mounted() {
        // Mantén la lógica para inicializar color y talla seleccionados
        const firstVariant = this.producto.varientes[0];
        if (firstVariant) {
            this.selectedColor = firstVariant.color;
            this.selectedSize = firstVariant;
        }
    },
};
</script>

<style scoped>
/* General */
body {
    margin: 0;
    font-family: Arial, sans-serif;
    display: flex;
    flex-direction: column;
    height: 100vh;
    /* Altura completa de la pantalla */
}

#header {
    width: 100%;
    display: grid;
    grid-template-columns: 1fr 5fr 1fr;
    align-items: center;
    padding: 10px 20px;
    gap: 10px;
    text-align: center;
    background: #f5f5f5;
    border-bottom: 1px solid #ddd;
}

#nombre-local {
    font-size: 18px;
    font-weight: bold;
}

#subtitulo {
    font-size: 12px;
    color: #888;
}

/* Contenedor principal */
.product-container {
    flex: 1;
    /* Ocupa todo el espacio entre header y footer */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    /* Espaciado uniforme entre los elementos */
    padding: 20px;
    overflow-y: auto;
    /* Habilitar desplazamiento si el contenido excede la altura */
}

/* Carrusel de Imágenes */
.product-carousel {
    position: relative;
    width: 100%;
    height: 400px;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
}

.carousel-image {
    width: 100%;
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.carousel-pagination {
    display: flex;
    justify-content: center;
    margin-top: 10px;
    gap: 5px;
}

.carousel-pagination span {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #ddd;
    cursor: pointer;
}

.carousel-pagination .active-dot {
    background-color: #555;
}

/* Detalles del Producto */
#nombre-valoracion {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 90%;
    margin: 10px auto;
    font-size: 18px;
    font-weight: bold;
}

.star {
    color: gold;
}

#descripcion {
    margin: 10px auto;
    width: 90%;
    color: #555;
    font-size: 14px;
    text-align: center;
}

/* Colores del Producto */
.colors-container {
    width: 90%;
    margin: 0 auto 15px;
}

.colors {
    display: flex;
    justify-content: flex-start;
    gap: 10px;
    margin: 10px 0;
}

.color-btn {
    width: 30px;
    height: 30px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

/* Tallas del Producto */
.sizes-container {
    width: 90%;
    margin: 0 auto 15px;
}

.sizes-container ul {
    display: flex;
    justify-content: flex-start;
    gap: 10px;
    list-style: none;
    padding: 0;
    margin: 0;
}

.sizes-container p,
.colors-container p {
    font-size: 16px;
    font-weight: bold;
}

.size-btn {
    padding: 8px 10px;
    border: none;
    margin-top: 8px;
    border-radius: 5px;
    cursor: pointer;
    background-color: #4f4f4f;
    color: white;
}

.size-btn.active-size {
    background-color: #ddd;
    font-weight: bold;
    color: black;
}

/* Footer */
.footer {
    display: flex;
    justify-content: space-between;
    padding: 10px 20px;
    background-color: #f5f5f5;
    border-top: 1px solid #ddd;
    align-items: center;
    position: fixed;
    bottom: 0;
    width: 100%;
}

.footer-content {
    margin: 0 auto;
    text-align: center;
}


#precio {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    text-align: center;
}
</style>