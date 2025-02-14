import { useAuthStore } from '@/stores/authStore';

export default defineNuxtRouteMiddleware((to) => {
  const authStore = useAuthStore();

  // if (!authStore.isAuthenticated && to.path !== '/login' && to.path !== '/register') {
  //   return navigateTo('/login');
  // }
  // else if (!authStore.comercio && to.path !== '/admin') {
  //   return navigateTo('/');
  // }
});