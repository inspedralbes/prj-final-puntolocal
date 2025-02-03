<template>
    <div>
      <p>Procesando inicio de sesión...</p>
    </div>
  </template>
  
  <script>
  import { useAuthStore } from '@/stores/authStore';
  
  definePageMeta({
    layout: 'authentication',
  });
  
  export default {
    setup() {
      const authStore = useAuthStore();
  
      // Procesar el token del callback
      async function handleCallback() {
        const urlParams = new URLSearchParams(window.location.search);
        const userParam = urlParams.get('user');
  
  
        if (userParam) {
          try {
            const userData = JSON.parse(decodeURIComponent(userParam));
            const { token, ...user } = userData;
  
            // Guardar token y usuario en el store
            authStore.login(user, token);
            navigateTo('/');
          } catch (error) {
            console.log('Hubo un problema con el inicio de sesión.');
            navigateTo('/login');
          }
        } else {
          console.log('Inicio de sesión fallido.');
          navigateTo('/login');
        }
      }
  
      handleCallback();
  
      return {};
    },
  };
  </script>
  