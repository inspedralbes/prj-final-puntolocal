# Tutorial de creación de ghactions

## Creación de las llaves:


comando: ssh-keygen -t ed25519 -f ~/.ssh/clouding_id_ed25519 -C "clouding-deploy-key"

Las llaves se generan en la carpta ./ssh del usuario con el qual las generas. (ej. /home/llorens/.ssh/clouding_id_ed25519.pub)

Se generan 2 llaves:

Llave publica: clouding_id_ed25519.pub
LLave privada: clouding_id_ed25519

---

## Copiar la llave publica al servidor:

Se debera conectarse al servidor y copiar a la carpeta .ssh/authorized_keys del usuario contectado el contenido del archivo clouding_id_ed25519.pub.

---

## Configurar el ghactions

Se debera configurar el ghactions para que haga las acciones pertinentes. En ternminos simples nuestro ghactions hace lo siguiente:

  * Instalar Dependencias Nuxt
  * Hacer el Build de Nuxt
  * Instalar Dependendias Laravel
  * Instalar Dependencias Node
  * Configurar Acceso SSH
  * Transferir los archivos con rsync
  * Ejecutar comandos post-despliegue

## Configurar los secrets en Github

Se debe ir a la configuración del proyecto de Github y añadir las Respository Secrets necesarios.
