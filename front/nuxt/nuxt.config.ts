export default defineNuxtConfig({
  devtools: { enabled: true },
  modules: ['@nuxtjs/tailwindcss', '@pinia/nuxt', '@unlok-co/nuxt-stripe'],
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
      stripePublicKey: process.env.NUXT_PUBLIC_STRIPE_PUBLIC_KEY,
    },
  },

  stripe: {
    client: {
      key: process.env.NUXT_PUBLIC_STRIPE_PUBLIC_KEY,
      options: {}
    }
  },
});