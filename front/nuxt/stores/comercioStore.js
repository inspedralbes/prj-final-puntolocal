import { defineStore } from 'pinia';

export const useComercioStore = defineStore('comercio', {
  state: () => ({
    cesta: [
        {
            id: 1,
            nombre: "Camiseta de Algodón",
            descripcion: "Camiseta cómoda y ligera, ideal para el verano.",
            stock_general: 150,
            precio: 19.99,
            valoracion: 4.9,
            imagenes: [
                "https://imgs.search.brave.com/zLz9LQZ7X_HueDRlt4jt4hM7bd8DNZAS5fU2qTI2FTA/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9zdGF0/aWMud2l4c3RhdGlj/LmNvbS9tZWRpYS9m/OTE5NWZfNjY0OTI0/MzYwNTk3NGZkYzg4/OWFiZjRlMzA4NzM4/NzV-bXYyLnBuZy92/MS9maWxsL3dfNzQz/LGhfNzQzLGFsX2Ms/cV85MCx1c21fMC42/Nl8xLjAwXzAuMDEs/ZW5jX2F2aWYscXVh/bGl0eV9hdXRvL3Jv/bGV4LnBuZw",
                "camiseta2.jpg",
                "camiseta3.jpg"
            ],
            comercio: 1,
            tamaños: ["S", "M", "L", "XL"],
            colores: [
                { nombre: "Red", codigo: "#ff0000" },
                { nombre: "Blue", codigo: "#0000ff" },
                { nombre: "Green", codigo: "#008000" },
                { nombre: "Black", codigo: "#000000" }
            ],
            cantidad: 1,
        },
        {
            id: 2,
            nombre: "Pantalón Vaquero",
            descripcion: "Pantalón denim clásico, cómodo y resistente.",
            stock_general: 200,
            precio: 39.99,
            valoracion: 4.7,
            imagenes: [
              "https://imgs.search.brave.com/2jQ-QXtuzR9Lv9EkKDzMhoFoPQ9cX1QCIxTOpoMHUq4/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/ZXZlcnl0aGluZ2Rp/b2ZmZXJlZC5jb20v/d3AtY29udGVudC91/cGxvYWRzLzIwMjAv/MDQvcGFudC1kZW5p/bS5qcGc",
              "pantalon2.jpg",
              "pantalon3.jpg",
            ],
            comercio: 1,
            tamaños: ["XS", "S", "M", "L", "XL", "XXL"],
            colores: [
              { nombre: "Blue Denim", codigo: "#3b5998" },
              { nombre: "Black", codigo: "#000000" },
            ],
            cantidad: 1,
          },
          {
            id: 3,
            nombre: "Zapatillas Deportivas",
            descripcion: "Zapatillas ligeras y transpirables, perfectas para correr.",
            stock_general: 100,
            precio: 59.99,
            valoracion: 4.8,
            imagenes: [
              "https://imgs.search.brave.com/L_dCWjcNKlZpB12_XwnngqiEyqxz-ywlFtGy0R46R1M/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9zdGF0/aWMuYWxhYmFzdHJh/LmNvbS9jb250ZW50/L3N0b3JhZ2UvaW1h/Z2VzL3Byb2R1Y3Rz/L3Rlc3Qtc2hvZS5q/cGc",
              "zapatillas2.jpg",
              "zapatillas3.jpg",
            ],
            comercio: 1,
            tamaños: ["38", "39", "40", "41", "42", "43", "44"],
            colores: [
              { nombre: "White", codigo: "#ffffff" },
              { nombre: "Black", codigo: "#000000" },
              { nombre: "Gray", codigo: "#808080" },
            ],
            cantidad: 1,
          },
          {
            id: 4,
            nombre: "Sudadera con Capucha",
            descripcion: "Sudadera de algodón con capucha ajustable, ideal para días fríos.",
            stock_general: 120,
            precio: 29.99,
            valoracion: 4.6,
            imagenes: [
              "https://imgs.search.brave.com/Eay7CdaYPzH_ArEojJzzf8VRu3UN_6SV7h9CdUINHEM/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/Y29zYXNsZWFkaXMu/Y29tL3dwLWNvbnRl/bnQvdXBsb2Fkcy8y/MDE5LzA0L2hvb2Rp/ZS1ibGFjay1oYW5k/cy1tZW4uanBn",
              "sudadera2.jpg",
              "sudadera3.jpg",
            ],
            comercio: 2,
            tamaños: ["S", "M", "L", "XL"],
            colores: [
              { nombre: "Black", codigo: "#000000" },
              { nombre: "Gray", codigo: "#808080" },
              { nombre: "Navy", codigo: "#000080" },
            ],
            cantidad: 1,
          },
          {
            id: 5,
            nombre: "Gorra Snapback",
            descripcion: "Gorra clásica snapback con ajuste trasero, estilo urbano.",
            stock_general: 80,
            precio: 14.99,
            valoracion: 4.5,
            imagenes: [
              "https://imgs.search.brave.com/CRX2eBYI6hZg9XNJEVZn7CS3AOBO2LvavJD6yyEtZJk/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/Y2Fwc2h1dC5jb20v/d3AtY29udGVudC91/cGxvYWRzLzIwMjEv/MDEvYmFzZS1jYXAu/anBn",
              "gorra2.jpg",
              "gorra3.jpg",
            ],
            comercio: 2,
            tamaños: ["Único"],
            colores: [
              { nombre: "Black", codigo: "#000000" },
              { nombre: "Red", codigo: "#ff0000" },
              { nombre: "Blue", codigo: "#0000ff" },
            ],
            cantidad: 1,
          },
    ],
  }),
  getters: {
    totalItems: (state) => state.cesta.length,
    totalPrice: (state) => state.cesta.reduce((acc, item) => acc + item.price, 0),
  },
  actions: {
    addToBasket(item) {
        console.log('addToBasket', item);
      const existingItem = this.cesta.find((i) => i.id === item.id);
      
      if (existingItem) {
        existingItem.cantidad += 1;
      } else {
        this.cesta.push({ ...item, cantidad: 1 });
      }
    },
    removeFromBasket(index) {
      this.cesta.splice(index, 1);
    },
    emptyBasket() {
      this.cesta = [];
    },
  },
  persist: {
    enabled: true,
    strategies: [
      {
        key: 'cestaStorage', 
        storage: typeof window !== 'undefined' ? sessionStorage : null,
      },
    ],
  },
});

