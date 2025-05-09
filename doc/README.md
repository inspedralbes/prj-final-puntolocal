# 📚 Documentació del projecte Holabarri

Aquest directori conté la documentació essencial del projecte **Holabarri**. L'objectiu és proporcionar una guia clara sobre el funcionament, arquitectura i desplegament del sistema.

📌 **És obligatori mantenir aquest document actualitzat.**

---

## 📄 Documents generals

- 👉 [Document comercial d'Holabarri (2024-2025)](https://holabarri.cat/docs/comercial_2425_holabarri.pdf)  
- 👉 [Presentació de funcionalitats d'Holabarri (2024-2025)](https://holabarri.cat/docs/resum_2425_holabarri.pdf)
- 👉 [Manual d'usuari de com funciona l'aplicació per usuaris i administradors](https://holabarri.cat/docs/tecnica_2425_holabarri.pdf)

---

## 📌 Contingut mínim de la documentació tècnica

A continuació es detallen els punts mínims que cal cobrir en aquest document o en altres fitxers vinculats:

---

### 🔧 Dependències i versions

#### Backend – Laravel (PHP 8.2)

- `laravel/framework` ^11.31  
- `laravel/sanctum` ^4.0  
- `laravel/socialite` ^5.17  
- `laravel/tinker` ^2.9  
- `fakerphp/faker` ^1.23  

#### Frontend – Nuxt.js 3

- `nuxt` ^3.15.2  
- `vue` latest  
- `vue-router` latest  
- `@nuxt/devtools` ^2.0.0  
- `@nuxtjs/tailwindcss` ^6.13.1  
- `@pinia/nuxt` ^0.9.0  
- `pinia` ^2.3.1  
- `pinia-plugin-persistedstate` ^4.2.0  
- `chart.js` ^4.4.9  
- `ol` ^10.4.0  
- `supercluster` ^8.0.1  
- `socket.io-client` ^4.8.1  
- `cors` ^2.8.5  
- `flowbite` ^3.0.0  
- `sweetalert2` ^11.16.0  

#### Eines de desenvolupament

- `cypress` ^14.2.1 (testos E2E frontend)

---

### 🚀 Instruccions de desplegament

El desplegament del projecte es realitza mitjançant **GitHub Actions**, que automatitza la pujada del codi a la branca `dev`. Aquesta branca representa l'entorn de desenvolupament i qualsevol `push` o `pull request` pot desencadenar workflows automàtics definits al fitxer `Ghactions.md`.

#### Passos bàsics per al desplegament:

1. **Clona el repositori:**

   ```bash
   git clone https://github.com/holabarri/holabarri.git
   cd holabarri