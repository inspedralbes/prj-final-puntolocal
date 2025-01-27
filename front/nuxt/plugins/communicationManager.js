import { useAuthStore } from '@/stores/authStore';
import { createPinia, setActivePinia } from 'pinia';

const pinia = createPinia();
setActivePinia(pinia);
const authStore = useAuthStore();
const Host = 'http://localhost:8000/api';

export default defineNuxtPlugin(nuxtApp => {
    const communicationManager = {
      ///////////////////////////// GET  //////////////////////////////////
      async getCategorias() {
        try {
          const response = await fetch(Host + '/categorias',{
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
        const response = await fetch(`${Host}/auth/register`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(json)
        });

        if (!response.ok) {
          console.error(`Error en la petición: ${response.status} ${response.statusText}`);
          return null;
        }

        const jsonResponse = await response.json();
        return jsonResponse;
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return null;
      }
    },

    async login(json) {
      try {
        const response = await fetch(`${Host}/auth/login`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(json)
        });

        if (!response.ok) {
          console.error(`Error en la petición: ${response.status} ${response.statusText}`);
          return null;
        }

        const jsonResponse = await response.json();
        return jsonResponse;
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

        if (!response.ok) {
          console.error(`Error en la petición: ${response.status} ${response.statusText}`);
          return null;
        }

        const jsonResponse = await response.json();
        return jsonResponse;
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return null;
      }
    },

    async getByComercio() {
      try {
        const response = await fetch(`${Host}/producto/comercio/1`);
        if (!response.ok) {
          console.error(`Error en la petición: ${response.status} ${response.statusText}`)
          return null;
        }
        const json = await response.json();
        return json;
      } catch (error) {
        console.error('Error al realizar la petición:', error);
      }
    },

    async infoProducto(id) {
      try {
        const response = await fetch(`${Host}/producto/${id}`);
        if (!response.ok) {
          console.error(`Error en la petición: ${response.status} ${response.statusText}`)
          return null;
        }
        const json = await response.json();
        return json;
      } catch (error) {
        console.error('Error al realizar la petición:', error);
      }
    },

    async guardarProducto(producto) {
      try {
        const id = producto.id;
        const response = await fetch(`${Host}/producto/${id}`, {
          method: 'PUT',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
          },
          body: JSON.stringify(producto)
        });
        if (!response.ok) {
          console.error(`Error en la petición: ${response.status} ${response.statusText}`)
          return null;
        }
        const json = await response.json();
        return json;
      } catch (error) {
        console.error('Error al realizar la petición:', error);
      }
    },

    async createProducto(formData) {
      try {
        const response = await fetch(`${Host}/producto`, {
          method: 'POST',
          headers: {
            'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
          },
          body: formData
        });

        if (!response.ok) {
          console.error(`Error en la petición: ${response.status} ${response.statusText}`);
          return null;
        }

        const jsonResponse = await response.json();
        return { success: true, data: jsonResponse };
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return { success: false, message: error.message };
      }
    },

  };

  // Inyectar el communicationManager en la app
  nuxtApp.provide('communicationManager', communicationManager);
});
