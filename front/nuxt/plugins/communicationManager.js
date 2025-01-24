import { useAuthStore } from '@/stores/authStore';
import { createPinia, setActivePinia } from 'pinia';

const pinia = createPinia();
setActivePinia(pinia);
const authStore = useAuthStore();
const Host = 'http://localhost:8000/api'

export default defineNuxtPlugin(nuxtApp => {
    const communicationManager = {
      ///////////////////////////// GET  //////////////////////////////////
      async getCategoriasGenerales() {
        try {
          const response = await fetch(Host + '/categoriasGenerales',{
            method: 'GET',
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
              'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
            },
          });
          if (response.ok) {
            const json = await response.json();
            return json;
          } else {
            console.error(`Error en la petición: ${response.status} ${response.statusText}`)
            return null;
          }
      
        } catch (error) {
          console.error('Error al realizar la petición:', error);
          return null;
        }
      },
      async getComercio(comercioId) {
        try {
          const response = await fetch(`${Host}/comercios/${comercioId}`, {
            method: 'GET',
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
              'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
            },
          });
          if (response.ok) {
            const json = await response.json();
            return json;
          } else {
            console.error(`Error en la petición: ${response.status} ${response.statusText}`);
            return null;
          }
        } catch (error) {
          console.error('Error al realizar la petición:', error);
          return null;
        }
      },
      async getComercios() {
        try {
          const response = await fetch(Host + '/comercios',{
            method: 'GET',
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
              'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
            },
          });
          if (response.ok) {
            const json = await response.json();
            return json;
          } else {
            console.error(`Error en la petición: ${response.status} ${response.statusText}`)
            return null;
          }
      
        } catch (error) {
          console.error('Error al realizar la petición:', error);
          return null;
        }
      },

      ///////////////////////////// POST //////////////////////////////////
      async register(json) {
        try {
          const response = await fetch(Host + '/auth/register', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(json)
          });

          if (response.ok) {
            const json = await response.json();
            return json;
          } else {
            console.error(`Error en la petición: ${response.status} ${response.statusText}`)
            return null;
          }

        } catch (error) {
          console.error('Error al realizar la petición:', error);
          return null;
        }
      },

      async login(json) {
        try {
          const response = await fetch(Host + '/auth/login', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(json)
          });
      
          if (response.ok) {
            const json = await response.json();
            return json;
          } else {
            console.error(`Error en la petición: ${response.status} ${response.statusText}`)
            return null;
          }
      
        } catch (error) {
          console.error('Error al realizar la petición:', error);
          return null;
        }
      },

      async registerStore(json) {
        try {
          const response = await fetch(Host + '/comercios', {
            method: 'POST',
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
              'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
            },
            body: JSON.stringify(json)
          });

          if (response.ok) {
            const json = await response.json();
            return json;
          } else {
            console.error(`Error en la petición: ${response.status} ${response.statusText}`)
            return null;
          }

        } catch (error) {
          console.error('Error al realizar la petición:', error);
          return null;
        }
      },
        
    };
  
    // Inyectar el communicationManager en la app
    nuxtApp.provide('communicationManager', communicationManager);
  });