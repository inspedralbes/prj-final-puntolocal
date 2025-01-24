<script setup>
import { ref } from 'vue';
import AddProducts from './add-products.vue'; // Importamos el componente

definePageMeta({
    layout: false,
});

// Estado para gestionar el contenido actual
const currentView = ref('default');

// Función para cambiar la vista
const changeView = (view) => {
    currentView.value = view;
};
</script>

<template>
    <div id="general">
        <div id="menu">
            <div id="productes" class="menu-section">
                <h1>Productes</h1>
                <button class="menu-button" @click="changeView('addProducts')">Afegir producte</button>
                <button class="menu-button">Veure productes</button>
            </div>

            <div id="categories" class="menu-section">
                <h1>Categorias</h1>
                <button class="menu-button">Afegir categories</button>
                <button class="menu-button">Veure categorias</button>
            </div>
        </div>

        <div id="contenido">
            <template v-if="currentView === 'addProducts'">
                <AddProducts />
            </template>
            <template v-else-if="currentView === 'viewProducts'">
                <p>Vista de productos</p>
            </template>
            <template v-else-if="currentView === 'addCategories'">
                <p>Formulario para agregar categorías</p>
            </template>
            <template v-else-if="currentView === 'viewCategories'">
                <p>Listado de categorías</p>
            </template>
            <template v-else>
                <p>Contenido principal</p>
            </template>
        </div>
    </div>
</template>

<style scoped>
    #general {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
        height: 100vh;
        font-family: Arial, sans-serif;
        color: #333;
    }

    /* Menú lateral */
    #menu {
        height: 100vh;
        width: 20%;
        min-width: 250px;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }

    .menu-section {
        margin-bottom: 20px;
        background: #ffffff;
        border-radius: 10px;
    }

    .menu-section h1 {
        font-size: 1.5rem;
        margin-bottom: 10px;
        color: #4a4a4a;
    }

    .menu-button {
        display: block;
        width: 90%;
        margin: 10px auto;
        font-size: 1rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .menu-button:hover {
        background: #554dff;
    }

    /* Contenido principal */
    #contenido {
        flex: 1; /* Ocupa todo el espacio restante */
        height: 100vh; /* Asegura la altura completa de la ventana */
        overflow-y: auto; /* Activa el desplazamiento solo en el eje vertical */
        padding: 0; /* Quita padding para que los componentes ocupen todo el espacio */
        display: flex;
        justify-content: center; /* Centra el contenido horizontalmente */
        align-items: flex-start; /* Alinea el contenido en la parte superior */
    }

    #contenido > * {
        width: 100%; /* Asegura que el componente hijo ocupe todo el ancho */
        padding: 20px; /* Añade espacio interno en el contenido */
    }

    #contenido p {
        font-size: 1.2rem;
        color: #333;
    }
</style>