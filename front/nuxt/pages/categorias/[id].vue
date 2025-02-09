<template>
    <div>
        <p @click="todasLasCategorias()">Ver todas las categorías</p>
    </div>
</template>

<script setup>
    import { useRouter } from 'vue-router';

    const router = useRouter();

    function todasLasCategorias() {
        router.push(`/categorias`);
    }
</script>