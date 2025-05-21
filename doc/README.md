# 📚 Documentació del projecte Holabarri

Aquest directori conté la documentació essencial del projecte **Holabarri**. L'objectiu és proporcionar una guia clara sobre el funcionament, arquitectura i desplegament del sistema.

📌 **És obligatori mantenir aquest document actualitzat.**

---

## 📄 Documents generals

- 👉 [Document comercial d'Holabarri (2024-2025)](https://holabarri.cat/docs/comercial_2425_holabarri.pdf)  
- 👉 [Presentació de funcionalitats d'Holabarri (2024-2025)](https://holabarri.cat/docs/resum_2425_holabarri.pdf)
- 👉 [Manual d'usuari de com funciona l'aplicació per usuaris i administradors](https://holabarri.cat/docs/tecnica_2425_holabarri.pdf)
- 👉 [Document sobre l'evolució del projecte amb el Taiga](https://holabarri.cat/docs/planificacio_2425_holabarri.pdf)
- 👉 [Penpot/Wireframes](https://design.penpot.app/#/view?file-id=96c4bd8e-df43-800f-8005-9d60dfdbab89&page-id=96c4bd8e-df43-800f-8005-9d60dfdbab8a&section=interactions&index=0&share-id=8233eca0-468b-80cb-8005-a12107191a0d)

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

El desplegament del projecte es realitza mitjançant **GitHub Actions**, que automatitza la pujada del codi a la branca `main`. La branca `dev` representa l'entorn de desenvolupament i qualsevol canvi s'ha de testar en aquesta branca abans de fer merge a `main`.
