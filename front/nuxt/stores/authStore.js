import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    isAuthenticated: typeof window !== 'undefined' ? localStorage.getItem('isAuthenticated') || false : false,
    token: typeof window !== 'undefined' ? localStorage.getItem('token') || null : null, 
    user: typeof window !== 'undefined' ? JSON.parse(localStorage.getItem('user')) || null : null,
    comercio: typeof window !== 'undefined' ? JSON.parse(localStorage.getItem('comercio')) || null : null,
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
      if (typeof window !== 'undefined') {
        localStorage.removeItem('isAuthenticated');
        localStorage.removeItem('token'); 
        localStorage.removeItem('user'); 
        localStorage.removeItem('comercio'); 
      }
    },
    initialize() {
      if (typeof window !== 'undefined') {
        const isAuthenticated = localStorage.getItem('isAuthenticated');
        const token = localStorage.getItem('token');
        const user = JSON.parse(localStorage.getItem('user'));
        const comercio = JSON.parse(localStorage.getItem('comercio'));
        if (token && user && comercio) {
          this.login(user, token, comercio);
        }
      }
    },
    setUser(user) {
      this.user = user;
      if (typeof window !== 'undefined') {
        localStorage.setItem('user', JSON.stringify(user));
      }
    },
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

