<template>
    <div>
        <p @click="todasLasCategorias()">Ver todas las categorías</p>
        <button @click="getComerciosCategoria">Obtener Comercios</button>
    </div>
</template>

<script setup>
    import { useRouter, useRoute } from 'vue-router';
    import { onMounted } from 'vue';

    const router = useRouter();
    const route = useRoute();
    const { $communicationManager } = useNuxtApp();

    async function getComerciosCategoria() {
        try {
            const categoriaId = route.params.id;
            const response = await $communicationManager.getComerciosDeCategorias(categoriaId);
            
            console.log("Respuesta del servidor:", response);
        } catch (error) {
            console.error("Error obteniendo comercios:", error);
        }
    }

    function todasLasCategorias() {
        router.push(`/categorias`);
    }

    onMounted(() => {
        getComerciosCategoria();
    });
</script>