import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    isAuthenticated: typeof window !== 'undefined' ? sessionStorage.getItem('isAuthenticated') || false : false,
    token: typeof window !== 'undefined' ? sessionStorage.getItem('token') || null : null, 
    user: typeof window !== 'undefined' ? JSON.parse(sessionStorage.getItem('user')) || null : null,
    comercio: typeof window !== 'undefined' ? JSON.parse(sessionStorage.getItem('comercio')) || null : null,
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
        sessionStorage.setItem('isAuthenticated', this.isAuthenticated);
        sessionStorage.setItem('token', userToken);
        sessionStorage.setItem('user', JSON.stringify(userData));
        sessionStorage.setItem('comercio', JSON.stringify(comercioData));        
      }
    },
    logout() {
      this.isAuthenticated = false;
      this.user = null;
      this.token = null;
      this.comercio = null;
      if (typeof window !== 'undefined') {
        sessionStorage.removeItem('isAuthenticated');
        sessionStorage.removeItem('token'); 
        sessionStorage.removeItem('user'); 
        sessionStorage.removeItem('comercio'); 
      }
    },
    initialize() {
      if (typeof window !== 'undefined') {
        const isAuthenticated = sessionStorage.getItem('isAuthenticated');
        const token = sessionStorage.getItem('token');
        const user = JSON.parse(sessionStorage.getItem('user'));
        const comercio = JSON.parse(sessionStorage.getItem('comercio'));
        if (token && user && comercio) {
          this.login(user, token, comercio);
        }
      }
    },
    setUser(user) {
      this.user = user;
      if (typeof window !== 'undefined') {
        sessionStorage.setItem('user', JSON.stringify(user));
      }
    },
  },
  persist: {
    enabled: true,
    strategies: [
      {
        key: 'clientStorage', 
        storage: typeof window !== 'undefined' ? sessionStorage : null,
      },
    ],
  },
});

