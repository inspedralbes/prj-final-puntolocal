export default defineNuxtConfig({
  devtools: { enabled: true },
  modules: [
    '@nuxtjs/tailwindcss',
    '@pinia/nuxt'],
  // css: ['@/assets/main.css'], // Confirma que estás enlazando el archivo CSS
  devServer: {
    host: '0.0.0.0',
    port: 5173,
  },
  
  vite: {
    optimizeDeps: {
      exclude: ['ol']
    }
  },

  ssr: false,
  compatibilityDate: '2025-01-23',

  runtimeConfig: {
    public: {
      apiBaseUrl: process.env.NUXT_PUBLIC_BASE_URL,
      apiBaseLaravelUrl: process.env.NUXT_PUBLIC_API_LARAVEL_URL,
      baseNodeUrl: process.env.NUXT_PUBLIC_NODE_URL,
    },
  },
});