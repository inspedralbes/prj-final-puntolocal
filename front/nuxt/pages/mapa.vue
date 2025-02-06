<template>
    <div>
      <button @click="getLocation" class="px-4 py-2 bg-blue-500 text-white rounded-lg">
        Obtener Ubicación
      </button>
      <p v-if="location">Ubicación: {{ location }}</p>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const location = ref(null);
  
  const getLocation = () => {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          location.value = `Lat: ${position.coords.latitude}, Lng: ${position.coords.longitude}`;
        },
        (error) => {
          location.value = `Error: ${error.message}`;
        }
      );
    } else {
      location.value = 'La geolocalización no es compatible con este navegador.';
    }
  };
  </script>
  