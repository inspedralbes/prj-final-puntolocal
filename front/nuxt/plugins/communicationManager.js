import { createPinia, setActivePinia } from 'pinia';
import BusquedaGeneral from '~/pages/busquedaGeneral.vue';

const pinia = createPinia();
setActivePinia(pinia);
const auth = useAuthStore();
const comercio = auth.comercio;
import { useRuntimeConfig } from "#app";

export default defineNuxtPlugin((nuxtApp) => {

  const config = useRuntimeConfig();
  const Host = config.public.apiBaseLaravelUrl;
  const communicationManager = {
    get authStore() {
      return useAuthStore();
    },

    ///////////////////////////// GET  //////////////////////////////////
    async getProvincias() {
      try {
        const response = await fetch(Host + '/poblaciones/provincias', {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
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

    async getComerciosCercanos(lat, lon) {
      const response = await fetch(Host + `/comercios/comercios-cercanos/${lat}/${lon}`);

      if (response.ok) {
        const json = await response.json();
        return json;
      }

      return null;
    },

    async getCiudades($id) {
      try {
        const response = await fetch(Host + `/poblaciones/ciudades/${$id}`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
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

    async getCategorias() {
      try {
        const response = await fetch(Host + '/categorias', {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
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

    async getComerciosDeCategorias(idComercio) {
      try {
        const response = await fetch(Host + `/categorias/${idComercio}/comercios`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
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

    async getProductosDeCategorias(idCategoria) {
      try {
        const response = await fetch(Host + `/producto/categoria/${idCategoria}`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
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

    async getLocations() {
      const response = await fetch(`${Host}/getLocations`, {
        method: 'GET',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
        }
      });

      if (!response.ok) {
        console.error(`Error en la petición: ${response.status} ${response.statusText}`);
        return null;
      }

      const comercios = await response.json();
      return comercios;
    },

    async getProductoById(id) {
      try {
        const response = await fetch(`${Host}/producto/${id}`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
          }
        });

        if (!response.ok) {
          console.error(`Error en la petición: ${response.status} ${response.statusText}`);
          return null;
        }

        const producto = await response.json();
        return producto;
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return null;
      }
    },

    async getComercio(id) {
      try {
        const response = await fetch(`${Host}/comercios/${id}`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
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

    async getProductosComercio(id) {
      try {
        const response = await fetch(`${Host}/comercios/${id}/productos`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
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

    async getRandomProductos() {
      try {
        const response = await fetch(`${Host}/producto/random`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
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

    async getProductosCercanos(comercioIds) {
      try {
        const response = await fetch(`${Host}/cercanos/productos?comercioIds=${comercioIds}`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
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

    async getCategoriasGenerales() {
      try {
        const response = await fetch(`${Host}/categorias`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
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
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
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
      try {
        const response = await fetch(`${Host}/comercios/${comercioId}`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
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
        const response = await fetch(Host + '/comercios', {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
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
      try {
        const response = await fetch(`${Host}/cliente/${userId}`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
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
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
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
        const response = await fetch(`${Host}/comandes`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
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
        const response = await fetch(`${Host}/comandes/${compraId}/suborders`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
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

    async checkUserHasComercio(userId) {
      try {
        const response = await fetch(`${Host}/comercios/${userId}/check`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
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

    async busquedaProductos(search) {
      try {
        const response = await fetch(`${Host}/producto/search/${search}`, {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
          },
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

    async busquedaComercios(search) {
      try {
        const response = await fetch(`${Host}/comercios/search/${search}`, {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
          },
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

    async getFavoritos(clienteID) {
      try {
        const response = await fetch(`${Host}/cliente/${clienteID}/favoritos`, {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : '',
          },
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

    async getFavoritosInfo(clienteID) {
      try {
        const response = await fetch(`${Host}/cliente/${clienteID}/favoritos-info`, {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : '',
          },
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

    async consultarSiTieneLikeComercio(comercioID) {
      try {
        const response = await fetch(`${Host}/favoritos/verificar-seguido/${comercioID}`, {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : '',
          },
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

    async getComercioFavoritos() {
      try {
        const response = await fetch(`${Host}/favoritos/comercios-favoritos`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
          }
        });

        const jsonResponse = await response.json();
        return jsonResponse;
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return null;
      }
    },

    async getStatsSales(selectedPeriod) {
      try {
        const response = await fetch(`${Host}/stats/orders?period=${selectedPeriod}`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
          }
        });

        const jsonResponse = await response.json();
        return jsonResponse;
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return null;
      }
    },
    
    async getProductoRatings(productoID, perPage) {
      try {
        const response = await fetch(`${Host}/producto/${productoID}/ratings?per_page=${perPage}`, {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : '',
          },
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

    async getTopStats() {
      try {
        const response = await fetch(`${Host}/stats/top-products-clients`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
          }
        });

        const jsonResponse = await response.json();
        return jsonResponse;
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return null;
      }
    },

    async getRating() {
      try {
        const response = await fetch(`${Host}/stats/get-comercio-rating`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
          }
        });

        const jsonResponse = await response.json();
        return jsonResponse;
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return null;
      }
    },

    async getRatingData() {
      try {
        const response = await fetch(`${Host}/stats/get-ratings`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
          }
        });

        const jsonResponse = await response.json();
        return jsonResponse;
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return null;
      }
    },

    async getReviewsComercio() {
      try {
        const response = await fetch(`${Host}/stats/reviewsComercio`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
          }
        });

        const jsonResponse = await response.json();
        return jsonResponse;
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return null;
      }
    },

    async getReviewsProducto() {
      try {
        const response = await fetch(`${Host}/stats/reviewsProducto`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
          }
        });

        const jsonResponse = await response.json();
        return jsonResponse;
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

    async darLikeComercio(id) {
      try {
        const response = await fetch(`${Host}/favoritos/like/${id}`, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
          }
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
      try {
        const response = await fetch(Host + '/auth/logout', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
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

    async createSetUpIntent() {
      try {
        const response = await fetch(Host + '/stripe/create-setup-intent', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
          }
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

    async addPaymentMethod(payment_method) {
      try {
        const response = await fetch(Host + '/stripe/add-payment-method', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
          },
          body: JSON.stringify({
            'paymentMethod': payment_method
          })
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

    async retrievePaymentCards() {
      try {
        const response = await fetch(Host + '/stripe/retrieve-payment-method', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
          }
        });

        if (response.ok) {
          const json = await response.json();
          return json;
        } else {
          console.error(`Error en la petición: ${response.status} ${response.statusText}`)
          return null;
        }

      } catch (error) {
        console.error(error);
        return null;
      }
    },

    async changePassword(json) {
      try {
        const response = await fetch(Host + '/auth/change-password', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
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
      try {
        const response = await fetch(Host + '/auth/logout', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
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
      try {
        const response = await fetch(Host + '/auth/change-password', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
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

    async registerStore(formData) {
      try {
        const response = await fetch(`${Host}/comercios/`, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
          },
          body: formData // Se envía FormData en lugar de JSON
        });

        if (!response.ok) {
          const errorData = await response.json();
          console.error(`Error en la petición: ${response.status} ${response.statusText}`, errorData);
          return null;
        }

        return await response.json();
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return null;
      }
    },

    async storeRating(formData) {
      try {
        console.log('FormData:', formData); // Imprime el FormData para depuración
        const response = await fetch(`${Host}/ratings`, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
          },
          body: JSON.stringify(formData)
        });

        if (!response.ok) {
          const errorData = await response.json();
          console.error(`Error en la petición: ${response.status} ${response.statusText}`, errorData);
          return null;
        }

        return await response.json();
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
      for (let [key, value] of formData.entries()) {
        console.log(key, value); // Imprime el nombre del campo y su valor
      }
      try {
        const response = await fetch(`${Host}/producto/${id}`, {
          method: 'POST',
          headers: {
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : '',
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
      for (let [key, value] of formData.entries()) {
        console.log(key, value); // Imprime el nombre del campo y su valor
      }
      try {
        const response = await fetch(`${Host}/producto`, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
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

    async createProductoExcel(formData) {
      try {
        const response = await fetch(`${Host}/producto/crear_excel`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          },
          body: JSON.stringify(formData)
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

    async cambiarVisibilidad(id) {
      try {
        const response = await fetch(`${Host}/producto/visible/${id}`, {
          method: 'POST',
          headers: {
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
          }
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
            'Authorization': `Bearer ${this.authStore.token}`,
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
            'Accept': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
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

    async getHistorialOrders() {
      try {
        const response = await fetch(`${Host}/admin/comandes/historial`, {
          method: 'GET',
          headers: {
            'Authorization': `Bearer ${this.authStore.token}`,
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
            'Authorization': `Bearer ${this.authStore.token}`,
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

    async getEstats() {
      try {
        const response = await fetch(`${Host}/admin/estats`);

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

    async updateOrder(order) {
      try {
        const response = await fetch(`${Host}/admin/comandes/${order.id}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${this.authStore.token}`
          },
          body: JSON.stringify({ estat: order.estat }),
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

    async updateComercioImagenes(formData, id) {
      try {
        const response = await fetch(`${Host}/comercios/${id}/imagenes`, {
          method: 'POST',
          headers: {
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
          },
          body: formData
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

    async createOrder(order) {
      try {
        const response = await fetch(`${Host}/comandes`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${this.authStore.token}`,
          },
          body: JSON.stringify(order),
        });

        if (!response.ok) {
          console.error(`Error en la petición: ${response.status} ${response.statusText}`);
          return null;
        }

        const data = await response.json();
        return { success: true, data: data }
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return { success: false, message: error.message };
      }
    },

    async createSuborder(subcomandes) {
      try {
        const response = await fetch(`${Host}/suborders`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${this.authStore.token}`,
          },
          body: JSON.stringify(subcomandes),
        });

        if (!response.ok) {
          console.error(`Error en la petición: ${response.status} ${response.statusText}`);
          return null;
        }

        const data = await response.json();
        return { success: true, data: data }
      } catch (error) {
        console.error('Error al realizar la petición:', error);
        return { success: false, message: error.message };
      }
    },

    async updateFavorito(clienteID, productoID) {
      try {
        const response = await fetch(`${Host}/cliente/${clienteID}/favoritos`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
          },
          body: JSON.stringify({ producto_id: productoID })
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

    ///////////////////////////// PUT //////////////////////////////////

    async updateDatosPersonales(json, id) {
      try {
        const response = await fetch(Host + '/cliente/' + id + '/datos-personales', {
          method: 'PUT',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${this.authStore.token}`
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
      try {
        const response = await fetch(Host + '/cliente/' + id + '/datos-facturacion', {
          method: 'PUT',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
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

    async updateComercio(json, id) {
      try {
        const response = await fetch(`${Host}/comercios/${id}`, {
          method: 'PUT',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
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

    ///////////////////////////// DELETE //////////////////////////////////

    async deleteComercioImagen(id, tipo_imagen) {
      try {
        const response = await fetch(`${Host}/comercios/${id}/imagenes`, {
          method: 'DELETE',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${this.authStore.token}`
          },
          body: JSON.stringify(tipo_imagen)
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

    ///////////////////////////// OTROS //////////////////////////////////

    // async checkToken() {
    //   try {
    //     const response = 
    //   } catch (error) {
    //     console.error('Error al realizar la peticion: ', error);
    //     return null;
    //   }
    // }


    // STRIPE

    async selectPaymentMethod(card) {
      try {
        const response = await fetch(Host + '/stripe/set-default-payment-method', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
          },
          body: JSON.stringify({ payment_method_id: card.id })
        });
        const data = await response.json();
        return data;
      } catch (error) {
        console.error("Error: ", error);
      }
    },

    async purchaseProducts() {
      try {
        const response = await fetch(Host + '/stripe/purchase', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
          },
          body: JSON.stringify({ payment_method_id: card.id })
        });
        const data = await response.json();
        return data;
      } catch (error) {
        console.error("Error: ", error);
      }
    },

    async createStripeID() {
      try {
        const response = await fetch(Host + '/stripe/create-express-account', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
          }
        })
        const data = await response.json();
        return data;
      } catch (error) {
        console.error("Error: ", error);
      }
    },

    async getStripeOnboardingUrl() {
      try {
        const response = await fetch(Host + '/stripe/generate-onboarding-link', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': this.authStore.token ? `Bearer ${this.authStore.token}` : ''
          }
        })
        const data = await response.json();
        return data;
      } catch (error) {
        console.error("Error: ", error);
      }
    }
  };

  // Inyectar el communicationManager en la app
  nuxtApp.provide('communicationManager', communicationManager);
});
