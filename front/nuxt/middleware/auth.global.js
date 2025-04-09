import { useAuthStore } from '@/stores/authStore';
import $communicationManager from '../plugins/communicationManager';

export default defineNuxtRouteMiddleware((to) => {
  const authStore = useAuthStore();
  
  // Inicializar el estado de autenticación
  authStore.initialize();

  // Rutas permitidas sin autenticación
  const allowedRoutes = [
    '/login',
    '/register',
    '/auth/callback'
  ];

  // Si no está autenticado y la ruta no está permitida
  if (!authStore.isAuthenticated && !allowedRoutes.includes(to.path)) {
    return navigateTo('/login');
  }

  // Si está autenticado y trata de acceder a login/register
  if (authStore.isAuthenticated && (to.path === '/login' || to.path === '/register')) {
    return navigateTo('/');
  }
});