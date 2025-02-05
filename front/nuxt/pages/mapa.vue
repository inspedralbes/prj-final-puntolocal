<template>
    <div>
        <MapComponent />
    </div>
</template>

<script setup>
    definePageMeta({
        layout: false,
    });
    
    import MapComponent from '../components/MapComponent.vue';
</script>