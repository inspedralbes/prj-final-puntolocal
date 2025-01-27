<template>
    <div id="general">
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


        <div id="centrado">
            <div id="centrado-imagen">
                <div class="product-carousel" @touchstart="handleTouchStart" @touchmove="handleTouchMove"
                    @touchend="handleTouchEnd">
                    <img :src="selectedVariant.imagenes[currentImage]"
                        :alt="`Imagen del producto (${selectedVariant.color})`" class="carousel-image" />
                </div>

                <div class="carousel-pagination">
                    <span v-for="(imagen, index) in selectedVariant.imagenes" :key="index"
                        :class="{ 'active-dot': currentImage === index }" @click="currentImage = index"></span>
                </div>
            </div>


            <div class="product-container">
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
                        <button v-for="(color, index) in displayedColors" :key="index"
                            :style="{ backgroundImage: `url(${getFirstImageForColor(color)})` }" class="color-btn"
                            @click="filterByColor(color)" :class="{ 'active-color': color === selectedColor }">
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
        </div>

        <div class="footer">
            <div class="footer-content">
                <p id="precio" v-if="selectedSize">{{ selectedSize.price.toFixed(2) }}€</p>
            </div>
            <div class="footer-content">
                <button class="add-to-cart-btn">
                    <ButtonBasketComp :producto="producto" />
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    definePageMeta({
        layout: false,
    });

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
            getFirstImageForColor(color) {
                const variant = this.producto.varientes.find(v => v.color === color);
                return variant ? variant.imagenes[0] : '';
            },
            filterByColor(color) {
                this.selectedColor = color;
                this.currentImage = 0;
                this.selectedSize = this.filteredVariants[0] || null;
            },
            selectSize(variant) {
                this.selectedSize = variant;
            },
            handleTouchStart(event) {
                this.startX = event.touches[0].clientX;
            },
            handleTouchMove(event) {
                this.endX = event.touches[0].clientX;
            },
            handleTouchEnd() {
                const diffX = this.startX - this.endX;

                if (diffX > 50) {
                    this.nextImage();
                } else if (diffX < -50) {
                    this.prevImage();
                }

                this.startX = 0;
                this.endX = 0;
            },
            nextImage() {
                if (this.currentImage < this.selectedVariant.imagenes.length - 1) {
                    this.currentImage++;
                }
            },
            prevImage() {
                if (this.currentImage > 0) {
                    this.currentImage--;
                }
            },
        },

        mounted() {
            const firstVariant = this.producto.varientes[0];
            if (firstVariant) {
                this.selectedColor = firstVariant.color;
                this.selectedSize = firstVariant;
            }
        },
    };
</script>

<style scoped>
    body {
        margin: 0;
        display: flex;
        height: 100vh;
        flex-direction: column;
        font-family: Arial, sans-serif;
    }

    #general {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    #header {
        gap: 10px;
        width: 100%;
        display: grid;
        padding: 10px 20px;
        text-align: center;
        align-items: center;
        background: #f5f5f5;
        border-bottom: 1px solid #ddd;
        grid-template-columns: 1fr 5fr 1fr;
    }

    #nombre-local {
        font-size: 18px;
        font-weight: bold;
    }

    #subtitulo {
        color: #888;
        font-size: 12px;
    }

    .product-container {
        flex: 1;
        display: flex;
        padding: 20px;
        overflow-y: auto;
        flex-direction: column;
        justify-content: space-between;
    }

    .product-carousel {
        width: 100%;
        display: flex;
        height: 400px;
        overflow: hidden;
        position: relative;
        align-items: center;
        justify-content: center;
    }

    .carousel-image {
        width: 100%;
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .carousel-pagination {
        gap: 5px;
        display: flex;
        margin-top: 10px;
        justify-content: center;
    }

    .carousel-pagination span {
        width: 10px;
        height: 10px;
        cursor: pointer;
        border-radius: 50%;
        background-color: #ddd;
    }

    .carousel-pagination .active-dot {
        background-color: #555;
    }

    #nombre-valoracion {
        width: 90%;
        display: flex;
        font-size: 18px;
        font-weight: bold;
        margin: 10px auto;
        align-items: center;
        justify-content: space-between;
    }

    .star {
        color: gold;
    }

    #descripcion {
        width: 90%;
        color: #555;
        font-size: 14px;
        margin: auto auto 20px auto;
    }

    .colors-container {
        width: 90%;
        margin: 0 auto 15px;
    }

    .colors {
        gap: 10px;
        display: flex;
        margin: 10px 0;
        justify-content: flex-start;
    }

    .color-btn {
        width: 35px;
        height: 35px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        background-size: cover;
        border: 1px solid black;
        background-position: center;
    }

    .sizes-container {
        width: 90%;
        margin: 0 auto 15px;
    }

    #centrado {
        flex: 1;
    }

    .sizes-container ul {
        margin: 0;
        gap: 10px;
        padding: 0;
        display: flex;
        list-style: none;
        justify-content: flex-start;
    }

    .sizes-container p,
    .colors-container p {
        font-size: 16px;
        font-weight: bold;
    }

    .size-btn {
        border: none;
        color: white;
        cursor: pointer;
        margin-top: 8px;
        padding: 8px 10px;
        border-radius: 5px;
        background-color: #4f4f4f;
    }

    .size-btn.active-size {
        color: black;
        font-weight: bold;
        background-color: #ddd;
    }

    .footer {
        width: 100%;
        display: flex;
        position: relative;
        padding: 10px 20px;
        align-items: center;
        background-color: #f5f5f5;
        border-top: 1px solid #ddd;
        justify-content: space-between;
    }


    .footer-content {
        margin: 0 auto;
        text-align: center;
    }


    #precio {
        color: #333;
        font-size: 24px;
        font-weight: bold;
        text-align: center;
    }

    @media (min-width: 768px) {
        #centrado {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        #centrado-imagen {
            width: 40%;
            border: 1px solid black;
        }
    }
</style>