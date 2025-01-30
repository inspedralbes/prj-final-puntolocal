import { useAuthStore } from '@/stores/authStore';
import { createPinia, setActivePinia } from 'pinia';

const pinia = createPinia();
setActivePinia(pinia);
const Host = 'http://localhost:8000/api';
const user = authStore.user;
const comercio = authStore.comercio;

export default defineNuxtPlugin(nuxtApp => {
  const communicationManager = {
    ///////////////////////////// GET  //////////////////////////////////
    async getCategorias() {
        const authStore = useAuthStore();
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

    async getProductos() {
      try {
        const response = await fetch(`${Host}/producto`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
          }
        });

        if (!response.ok) {
          console.error(`Error en la petición: ${response.status} ${response.statusText}`);
          return null;
        }

        const productos = await response.json();
        return productos;
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return null;
      }
    },

    async getCategoriasGenerales() {
      try {
        const response = await fetch(`${Host}/categoriasGenerales/getCategoriasGenerales`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
          }
        });

        if (!response.ok) {
          console.error(`Error en la petición: ${response.status} ${response.statusText}`);
          return null;
        }

        const data = await response.json();
        return data;
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return null;
      }
    },

    async getSubcategoriasByCategoriaId(categoria_id) {
      try {
        const response = await fetch(`${Host}/subcategorias/${categoria_id}`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
          }
        });

        if (!response.ok) {
          console.error(`Error en la petición: ${response.status} ${response.statusText}`);
          return null;
        }

        const data = await response.json();
        return data;
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return null;
      }
    },

    async getComercio(comercioId) {
        const authStore = useAuthStore();
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
        const authStore = useAuthStore();
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
      async getUserData(userId) {
        const authStore = useAuthStore();
        try {
          const response = await fetch(`${Host}/cliente/${userId}`, {
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

    async getDatosCliente(clienteId) {
      try {
        const response = await fetch(`${Host}/clientes/${clienteId}`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
          }
        });

        if (!response.ok) {
          console.error(`Error en la petición: ${response.status} ${response.statusText}`);
          return null;
        }

        const json = await response.json();
        return json;
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return null;
      }
    },

    async comprasCliente(clienteId) {
      try {
        const response = await fetch(`${Host}/clientes/${clienteId}/compras`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
          }
        });

        if (!response.ok) {
          console.error(`Error en la petición: ${response.status} ${response.statusText}`);
          return null;
        }

        const json = await response.json();
        return json;
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return null;
      }
    },

    async detalleCompra(compraId) {
      try {
        const response = await fetch(`${Host}/clientes/compras/${compraId}`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
          }
        });

        if (!response.ok) {
          console.error(`Error en la petición: ${response.status} ${response.statusText}`);
          return null;
        }

        const json = await response.json();
        return json; // Retorna los detalles de la compra
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

        const data = await response.json();
        return data;
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

    async logout() {
      const authStore = useAuthStore();
      try {
        const response = await fetch(Host + '/auth/logout', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
          }
        });
        if (response.ok) {
          const json = await response.json();
          return json.data;
        } else {
          console.error(`Error en la petición: ${response.status} ${response.statusText}`)
          return null;
        }
    
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return null;
      }
    },

    async changePassword(json) {
        const authStore = useAuthStore();
        try {
          const response = await fetch(Host + '/auth/change-password', {
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

        const data = await response.json();
        return data;
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return null;
      }
    },

    async logout() {
      const authStore = useAuthStore();
      try {
        const response = await fetch(Host + '/auth/logout', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': authStore.token ? `Bearer ${authStore.token}` : ''
          }
        });
        if (response.ok) {
          const json = await response.json();
          return json.data;
        } else {
          console.error(`Error en la petición: ${response.status} ${response.statusText}`)
          return null;
        }
    
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return null;
      }
    },

    async changePassword(json) {
        const authStore = useAuthStore();
        try {
          const response = await fetch(Host + '/auth/change-password', {
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

        const data = await response.json();
        return data;
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return null;
      }
    },

    async registerStore(json) {
        const authStore = useAuthStore();
      try {
        const response = await fetch(`${Host}/comercios/registerComercio`, {
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

        const data = await response.json();
        return data;
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return null;
      }
    },

    async getByComercio() {
      try {
        const response = await fetch(`${Host}/producto/comercio/${comercio.id}`);
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

    async guardarProducto(formData, id) {
      const authStore = useAuthStore();
      for (let [key, value] of formData.entries()) {
        console.log(key, value); // Imprime el nombre del campo y su valor
      }
      try {
        // const id = formData.get('id');
        console.log(id);

        const response = await fetch(`${Host}/producto/${id}`, {
          method: 'POST',
          headers: {
            'Authorization': authStore.token ? `Bearer ${authStore.token}` : '',
          },
          body: formData,
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
      const authStore = useAuthStore();
      for (let [key, value] of formData.entries()) {
        console.log(key, value); // Imprime el nombre del campo y su valor
      }
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

        const data = await response.json();
        return { success: true, data: data };
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return { success: false, message: error.message };
      }
    },

    async eliminarProducto(id) {
      try {
        const response = await fetch(`${Host}/producto/${id}`, {
          method: 'DELETE',
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${authStore.token}`,
          },
        });

        if (!response.ok) {
          console.error(`Error en la petición: ${response.status} ${response.statusText}`);
          return null;
        }

        const data = await response.json();
        return { success: true, data: data };
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return { success: false, message: error.message };
      }
    },

    async getOrders() {
      try {
        const response = await fetch(`${Host}/admin/comandes/`, {
          method: 'GET',
          headers: {
            'Authorization': `Bearer ${authStore.token}`,
          },
        });

        if (!response.ok) {
          console.error(`Error en la petición: ${response.status} ${response.statusText}`);
          return null;
        }

        const data = await response.json();
        return { success: true, data: data };
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return { success: false, message: error.message };
      }
    },

    async infoOrder(id) {
      try {
        const response = await fetch(`${Host}/admin/comandes/${id}`, {
          method: 'GET',
          headers: {
            'Authorization': `Bearer ${authStore.token}`,
          },
        });

        if (!response.ok) {
          console.error(`Error en la petición: ${response.status} ${response.statusText}`);
          return null;
        }

        const data = await response.json();
        return { success: true, data: data };
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return { success: false, message: error.message };
      }
    },

    async updateDatosPersonales(json, id) {
        const authStore = useAuthStore();
        try {
          const response = await fetch(Host + '/cliente/' + id + '/datos-personales', {
            method: 'PUT',
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

    async updateDatosFacturacion(json, id) {
        const authStore = useAuthStore();
        try {
          const response = await fetch(Host + '/cliente/' + id + '/datos-facturacion', {
            method: 'PUT',
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
    async getEstats() {
      try {
        const response = await fetch(`${Host}/admin/estats`);

        if(!response.ok){
          console.error(`Error en la petición: ${response.status} ${response.statusText}`);
          return null;
        }

        const data = await response.json();
        return { success: true, data: data };
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return { success: false, message: error.message };
      }
    }
  };

  // Inyectar el communicationManager en la app
  nuxtApp.provide('communicationManager', communicationManager);
});
