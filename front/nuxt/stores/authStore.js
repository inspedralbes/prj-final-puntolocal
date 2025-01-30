import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    isAuthenticated: false, 
    token: typeof window !== 'undefined' ? sessionStorage.getItem('token') || null : null, 
    user: typeof window !== 'undefined' ? JSON.parse(sessionStorage.getItem('user')) || null : null,
  }),
  getters: {
    userName: (state) => state.user ? state.user.name : '',
    userEmail: (state) => state.user ? state.user.email : '',
  },
  actions: {
    login(userData, userToken) {
      this.isAuthenticated = true;
      this.user = userData; 
      this.token = userToken; 
      if (typeof window !== 'undefined') {
        sessionStorage.setItem('token', userToken);
        sessionStorage.setItem('user', JSON.stringify(userData));
      }
    },
    logout() {
      this.isAuthenticated = false;
      this.user = null;
      this.token = null;
      if (typeof window !== 'undefined') {
        sessionStorage.removeItem('token'); 
        sessionStorage.removeItem('user'); 
      }
    },
    initialize() {
      if (typeof window !== 'undefined') {
        const token = sessionStorage.getItem('token');
        const user = JSON.parse(sessionStorage.getItem('user'));
        if (token && user) {
          this.login(user, token);
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

