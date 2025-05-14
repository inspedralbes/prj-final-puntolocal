<template>
    <div>
      <Loading />
    </div>
  </template>
  
  <script setup>
  import { useAuthStore } from '@/stores/authStore';
  import Loading from '@/components/loading.vue';
  
  const authStore = useAuthStore();
  const route = useRoute();
  const router = useRouter();
  
  const handleCallback = async () => {
    try {
      // Obtener parámetros de la URL de forma segura
      const userParam = route.query.user;
      const tokenParam = route.query.token;
  
      if (!userParam || !tokenParam) {
        throw new Error('Faltan parámetros en la URL');
      }
  
      // Decodificar y parsear
      const userData = JSON.parse(decodeURIComponent(userParam));
      const authToken = decodeURIComponent(tokenParam);
  
      // Guardar en el store
      await authStore.login(userData, authToken, ''); 
      
      // Redirigir después de 1 segundo para visualizar el loading
      setTimeout(() => {
        router.push('/');
      }, 1000);
  
    } catch (error) {
      console.error('Error en el callback:', error.message);
      router.push('/login?error=auth_failed');
    }
  };
  
  // Ejecutar al montar el componente
  onMounted(() => {
    handleCallback();
  });
  </script>