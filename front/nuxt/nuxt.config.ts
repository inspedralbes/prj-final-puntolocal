export default defineNuxtConfig({
  devtools: { enabled: true },
  modules: ['@nuxtjs/tailwindcss'],

  devServer: {
    host: '0.0.0.0',
    port: 3000,
  },

  compatibilityDate: '2025-01-23',
});