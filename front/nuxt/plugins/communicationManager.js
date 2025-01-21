const Host = 'http://localhost:8000/api'

export default defineNuxtPlugin(nuxtApp => {
    const communicationManager = {
      ///////////////////////////// GET  //////////////////////////////////

      ///////////////////////////// POST //////////////////////////////////
      async register(json) {
        try {
          const response = await fetch(Host + '/auth/register', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(json)
          });

          if (response.ok) {
            const json = await response.json();
            console.log(json)
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
        console.log("AAA", json)
        try {
          const response = await fetch(Host + '/auth/login', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(json)
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
      }
        
    };
  
    // Inyectar el communicationManager en la app
    nuxtApp.provide('communicationManager', communicationManager);
  });