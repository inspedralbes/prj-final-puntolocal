<script setup>
    import { ref } from 'vue';
    import AddProducts from './add-products.vue';

    definePageMeta({
        layout: false,
    });

    const currentView = ref('default');

    const changeView = (view) => {
        currentView.value = view;
    };
</script>

<template>
    <div id="general">
        <div id="menu">
            <div id="productes" class="menu-section">
                <button class="menu-button" @click="changeView('addProducts')">Afegir producte</button>
                <button class="menu-button">Veure productes</button>
            </div>

            <div id="categories" class="menu-section">
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
        width: 100%;
        height: 100vh;
        display: flex;
        flex-wrap: wrap;
        font-family: Arial, sans-serif;
        color: #333;
    }

    #menu {
        width: 20%;
        height: 100vh;
        min-width: 250px;
        background: rgb(234, 234, 234);
    }

    .menu-section {
        margin: 20px 0;
        border-bottom: 1px solid black;
    }

    .menu-section h1 {
        color: #4a4a4a;
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    .menu-button {
        width: 90%;
        border: none;
        display: block;
        font-size: 1rem;
        cursor: pointer;
        margin: 10px auto;
        border-radius: 5px;
        transition: background 0.3s;
    }

    .menu-button:hover {
        background: #554dff;
    }

    #contenido {
        flex: 1;
        padding: 0;
        display: flex;
        height: 100vh;
        overflow-y: auto;
        justify-content: center;
        align-items: flex-start;
    }

    #contenido > * {
        width: 100%;
        padding: 20px;
    }

    #contenido p {
        color: #333;
        font-size: 1.2rem;
    }
</style>