import { defineStore } from 'pinia';
import { useRuntimeConfig } from "#app";

export const useAuthStore = defineStore('auth', {
  state: () => ({
    isAuthenticated: typeof window !== 'undefined' ? localStorage.getItem('isAuthenticated') || false : false,
    token: typeof window !== 'undefined' ? localStorage.getItem('token') || null : null,
    user: typeof window !== 'undefined' ? JSON.parse(localStorage.getItem('user')) || null : null,
    comercio: typeof window !== 'undefined' ? JSON.parse(localStorage.getItem('comercio')) || null : null,
    favoritos: typeof window !== 'undefined' ? new Set(JSON.parse(localStorage.getItem('favoritos')) || []) : new Set(),
    favoritosComercio: typeof window !== 'undefined' ? new Set(JSON.parse(localStorage.getItem('favoritosComercio')) || []) : new Set(),
  }),
  getters: {
    userName: (state) => state.user ? state.user.name : '',
    userEmail: (state) => state.user ? state.user.email : '',
    userAuthenticated: (state) => state.isAuthenticated,
  },
  actions: {
    login(userData, userToken, comercioData) {
      this.isAuthenticated = true;
      this.user = userData;
      this.token = userToken;
      this.comercio = comercioData;
      if (typeof window !== 'undefined') {
        localStorage.setItem('isAuthenticated', this.isAuthenticated);
        localStorage.setItem('token', userToken);
        localStorage.setItem('user', JSON.stringify(userData));
        localStorage.setItem('comercio', JSON.stringify(comercioData));
      }
    },
    logout() {
      this.isAuthenticated = false;
      this.user = null;
      this.token = null;
      this.comercio = null;
      this.favoritos = null
      this.favoritosComercio = null
      if (typeof window !== 'undefined') {
        localStorage.removeItem('isAuthenticated');
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        localStorage.removeItem('comercio');
        localStorage.removeItem('favoritos');
        localStorage.removeItem('favoritosComercio');
      }
    },
    initialize() {
      if (typeof window !== 'undefined') {
        const isAuthenticated = localStorage.getItem('isAuthenticated');
        const token = localStorage.getItem('token');
        const user = JSON.parse(localStorage.getItem('user'));
        const comercio = JSON.parse(localStorage.getItem('comercio'));
        const favoritos = JSON.parse(localStorage.getItem('favoritos'));
        const favoritosComercio = JSON.parse(localStorage.getItem('favoritosComercio'));
        if (token && user && comercio) {
          this.login(user, token, comercio);
        }
      }
    },
    async checkAuth() {
      if (!this.token) return false;

      const config = useRuntimeConfig();
      const Host = config.public.apiBaseLaravelUrl;

      try {
        const user = await $fetch(`${Host}/cliente/check-auth`, {
          headers: { Authorization: `Bearer ${this.token}` }
        });

        this.user = user;
        return true;
      } catch (error) {
        this.logout();
        return false;
      }
    },
    setUser(user) {
      this.user = user;
      if (typeof window !== 'undefined') {
        localStorage.setItem('user', JSON.stringify(user));
      }
    },
    setComercio(comercio) {
      this.comercio = comercio;
      if (typeof window !== 'undefined') {
        localStorage.setItem('comercio', JSON.stringify(comercio));
      }
    },
    setFavoritos(favoritos) {
      this.favoritos = new Set(favoritos);
      if (typeof window !== 'undefined') {
        localStorage.setItem('favoritos', JSON.stringify([...this.favoritos]));
      }
    },
    setComercioFavoritos(favoritosComercio) {
      this.favoritosComercio = new Set(favoritosComercio);
      if (typeof window !== 'undefined') {
        localStorage.setItem('favoritosComercio', JSON.stringify([...this.favoritosComercio]));
      }
    },
    toggleFavorito(id) {
      if (this.favoritos.has(id)) {
        this.favoritos.delete(id);
      } else {
        this.favoritos.add(id);
      }
      if (typeof window !== 'undefined') {
        localStorage.setItem('favoritos', JSON.stringify([...this.favoritos])); // Guardar el Set como Array
      }
    },
    toggleFavoritoComercio(id) {
      if (this.favoritosComercio.has(id)) {
        this.favoritosComercio.delete(id);
      } else {
        this.favoritosComercio.add(id);
      }
      if (typeof window !== 'undefined') {
        localStorage.setItem('favoritosComercio', JSON.stringify([...this.favoritosComercio]));
      }
    }

  },
  persist: {
    enabled: true,
    strategies: [
      {
        key: 'clientStorage',
        storage: typeof window !== 'undefined' ? localStorage : null,
      },
    ],  
  },
});

