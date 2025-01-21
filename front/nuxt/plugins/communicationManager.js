export default defineNuxtPlugin(nuxtApp => {
    const communicationManager = {

        


        
    };
  
    // Inyectar el communicationManager en la app
    nuxtApp.provide('communicationManager', communicationManager);
  });