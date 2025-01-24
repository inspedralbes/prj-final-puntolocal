// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2024-11-01',
  devtools: { enabled: true },
  modules: [
    '@nuxtjs/tailwindcss',
    '@pinia/nuxt'],
  // css: ['@/assets/main.css'], // Confirma que estás enlazando el archivo CSS
  
  devServer: {
    host: '0.0.0.0', // Asegura que escuche todas las interfaces
    port: 3000, // Cambia este puerto si lo necesitas
  },
})