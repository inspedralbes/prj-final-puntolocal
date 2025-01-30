<!-- PRODUCTOS -->

# API de Producto

## Descripción:

Esta API permite gestionar productos en un sistema de comercio, incluyendo la creación, actualización, eliminación y obtención de productos.

---

## Autenticación:

- **Método de autenticación:** Bearer Token (utilizando Sanctum).
- **Cabecera:** `Authorization: Bearer <token>`

---

## Endpoints

### 1. Obtener todos los productos

- **URL:** `/api/producto`
- **Método:** `GET`
- **Descripción:** Obtiene una lista de todos los productos.
- **Parámetros:** Ninguno.
- **Respuesta:**

  - **Código de estado 200 OK**:

    ```json
    {
        "data": [
            {
                "id": 1,
                "nombre": "Producto 1",
                "descripcion": "Descripción del producto 1",
                "subcategoria_id": 1,
                "subcategoria": "Subcategoría 1",
                "comercio_id": 1,
                "comercio": "Comercio 1",
                "precio": 100.00,
                "stock": 10
            },
            ...
        ]
    }
    ```

  - **Código de estado 404 Not Found** (Si no hay productos):
    ```json
    {
      "message": "No hay productos"
    }
    ```

---

### 2. Obtener todos los productos de un comercio específico

- **URL:** `/api/producto/comercio/{comercioID}`
- **Método:** `GET`
- **Descripción:** Obtiene una lista de todos los productos del comercio.
- **Parámetros:** Ninguno.
- **Respuesta:**

  - **Código de estado 200 OK**:

    ```json
    {
        "data": [
            {
                "id": 1,
                "nombre": "Producto 1",
                "descripcion": "Descripción del producto 1",
                "subcategoria_id": 1,
                "subcategoria": "Subcategoría 1",
                "comercio_id": 1,
                "comercio": "Comercio 1",
                "precio": 100.00,
                "stock": 10
            },
            ...
        ]
    }
    ```

  - **Código de estado 404 Not Found** (Si no hay productos):
    ```json
    {
      "message": "No hay productos"
    }
    ```

---

### 3. Crear un nuevo producto

- **URL:** `/api/producto`
- **Método:** `POST`
- **Descripción:** Crea un nuevo producto.
- **Parámetros (Cuerpo de la solicitud):**

  - `nombre`: (string, requerido) Nombre del producto.
  - `descripcion`: (string, requerido) Descripción del producto.
  - `precio`: (float, requerido) Precio del producto.
  - `subcategoria_id`: (int, requerido) ID de la subcategoría a la que pertenece el producto.
  - `comercio_id`: (int, requerido) ID del comercio donde se encuentra el producto.
  - `stock`: (int) Stock que tiene disponible en el momento de la creación del producto.

  **Ejemplo de cuerpo de la solicitud:**

  ```json
  {
    "nombre": "Producto 1",
    "descripcion": "Descripción del producto 1",
    "precio": 100.0,
    "subcategoria_id": 1,
    "comercio_id": 1,
    "stock": 10
  }
  ```

- **Respuesta:**

  - **Código de estado 200 OK**:

    ```json
    {
      "message": "Producto creado con éxito",
      "data": {
        "id": 1,
        "nombre": "Producto 1",
        "descripcion": "Descripción del producto 1",
        "subcategoria": "Subcategoría 1",
        "comercio": "Comercio 1",
        "precio": 100.0,
        "stock": 10
      }
    }
    ```

  - **Código de estado 400 Bad Request** (Si no hay productos):
    ```json
    {
      "error": "Validación fallida",
      "details": {
        "nombre": "El nombre es obligatorio",
        "precio": "El precio debe ser un número positivo"
      }
    }
    ```

---

### 4. Obtener un producto específico

- **URL:** `/api/producto/{id}`
- **Método:** `GET`
- **Descripción:** Obtiene los detalles de un producto específico.
- **Parámetros:**
  - `id`: (int, requerido) ID del producto.
- **Respuesta:**

  - **Código de estado 200 OK**:

    ```json
    {
      "nombre": "Mesa de comedor",
      "descripcion": "Mesa de comedor de madera maciza, con un diseño elegante y sencillo que encaja perfectamente en cualquier estilo de decoración, ideal para reuniones familiares.",
      "subcategoria_id": 7,
      "subcategoria": "Lencería",
      "comercio_id": 10,
      "comercio": "Hagenes-Zemlak",
      "precio": 628.48,
      "stock": null
    }
    ```

  - **Código de estado 404 Not Found** (Si el producto no existe):
    ```json
    {
      "message": "Producto no encontrado"
    }
    ```

---

### 5. Actualizar un producto

- **URL:** `/api/producto/{id}`
- **Método:** `PUT`
- **Descripción:** Actualiza un producto específico.
- **Parámetros (Cuerpo de la solicitud):**

  - `nombre`: (string, requerido) Nombre del producto.
  - `descripcion`: (string, requerido) Descripción del producto.
  - `precio`: (float, requerido) Precio del producto.
  - `subcategoria_id`: (int, requerido) ID de la subcategoría a la que pertenece el producto.
  - `comercio_id`: (int, requerido) ID del comercio donde se encuentra el producto.

  **Ejemplo de cuerpo de la solicitud:**

  ```json
  {
    "nombre": "Test nombre cambio",
    "descripcion": "Test descripcion",
    "precio": 99.99,
    "subcategoria_id": 1,
    "comercio_id": 1,
    "stock": 10
  }
  ```

- **Respuesta:**

  - **Código de estado 200 OK**:

    ```json
    {
      "message": "Producto actualizado con éxito",
      "data": {
        "id": 30,
        "subcategoria_id": 1,
        "comercio_id": 1,
        "nombre": "Test nombre cambio",
        "descripcion": "Test descripcion",
        "precio": 99.99,
        "stock": 10,
        "imagenes": null
      }
    }
    ```

  - **Código de estado 404 Not Found** (Si el producto no existe):
    ```json
    {
      "message": "Producto no encontrado"
    }
    ```

---

### 6. Eliminar un producto

- **URL:** `/api/producto/{id}`
- **Método:** `DELETE`
- **Descripción:** Elimina un producto específico de la base de datos.
- **Parámetros (en la URL):**

  - `id`: (int, requerido) El ID del producto que se desea eliminar.

- **Respuesta:**

  - **Código de estado 200 OK** (Producto eliminado con éxito):
    ```json
    {
      "message": "Producto eliminado con éxito"
    }
    ```
  - **Código de estado 404 Not Found** (Si el producto no se encuentra):

    ```json
    {
      "message": "Producto no encontrado"
    }
    ```

  - **Código de estado 500 Internal Server Error** (Si ocurre un error al intentar eliminar el producto):
    ```json
    {
      "error": "Producto no eliminado",
      "details": "Mensaje del error específico"
    }
    ```

<!-- AUTH -->

# API de Auth

## Descripción:

Esta API permite gestionar que los clientes se puedan registrar y loguear.

---

## Autenticación:

- **Método de autenticación:** Bearer Token (utilizando Sanctum).
- **Cabecera:** `Authorization: Bearer <token>`

---

## Endpoints

### 1. Registrarse

- **URL:** `/api/auth/register`
- **Método:** `POST`
- **Descripción:** Registra el usuario.
- **Parámetros:** .
  ```json
  {
    "name": "Arnau",
    "apellidos": "Enzo",
    "email": "arnau@gmail.com",
    "password": "12345678",
    "password_confirmation": "12345678"
  }
  ```
- **Respuesta:**

  - **Código de estado 200 OK**:

    ```json
    {
      "message": "Cliente creado exitosamente. Por favor, verifica tu correo electrónico.",
      "cliente": {
        "name": "Arnau",
        "apellidos": "Enzo",
        "email": "arnau@gmail.com",
        "phone": null,
        "street_address": "",
        "ciudad": "",
        "provincia": "",
        "codigo_postal": null,
        "numero_planta": null,
        "numero_puerta": null,
        "updated_at": "2025-01-27T10:42:52.000000Z",
        "created_at": "2025-01-27T10:42:52.000000Z",
        "id": 13
      }
    }
    ```

  - **Código de estado 422**:
    ```json
    {
      "message": "error"
    }
    ```

---

### 2. Login

- **URL:** `/api/auth/login`
- **Método:** `POST`
- **Descripción:** Permite logearse al usuario.
- **Parámetros:**
  ```json
  {
    "email": "lorenzo@gmail.com",
    "password": "12345678"
  }
  ```
- **Respuesta:**

  - **Código de estado 200 OK**:

    ```json
    {
      "message": "Inicio de sesión exitoso.",
      "user": {
        "id": 12,
        "name": "Lorenzo",
        "apellidos": "Moll",
        "email": "lorenzo@gmail.com",
        "email_verified_at": null,
        "phone": "603397347",
        "phone_verified_at": null,
        "street_address": "Carrer Confiança 32",
        "ciudad": "Ciutadella",
        "provincia": "Menorca",
        "codigo_postal": 7760,
        "numero_planta": 1,
        "numero_puerta": 1,
        "puntos": null,
        "created_at": null,
        "updated_at": null
      },
      "token": "2|QrNkofujnS2qH10oa9KTTmWwYgYMMdyDSYOfpJBK921c2e49"
    }
    ```

  - **Código de estado 404 Not Found** (Si no esta registrado):

    ```json
    {
      "message": "Cliente no encontrado"
    }
    ```

  - **Código de estado 401** (Si el password es incorrecto):
    ```json
    {
      "message": "Credenciales incorrectas"
    }
    `
    ```

---

### 3. Logout

- **URL:** `/api/auth/logout`
- **Método:** `POST`
- **Descripción:** Permite deslogearse al usuario.
- **Parámetros:**
- **Respuesta:**

  - **Código de estado 200 OK**:

    ```json
    {
      "message": "Sesión cerrada exitosamente."
    }
    ```

---

### 4. Change Password

- **URL:** `/api/auth/change-password`
- **Método:** `POST`
- **Descripción:** Permite cambiar el password al usuario.
- **Parámetros:**
  ```json
  {
    "currentPassword": "12345678",
    "newPassword": "123456789",
    "confirmPassword": "123456789"
  }
  ```
- **Respuesta:**

  - **Código de estado 200 OK**:

    ```json
    {
      "message": "Contraseña cambiada exitosamente."
    }
    ```

  - **Código de estado 404 Not Found** (Si no esta registrado):

    ```json
    {
      "message": "Contraseña actual incorrecta."
    }
    ```

  - **Código de estado 422** (Si los datos recibidos son incorrectos):
    ```json
    {
      "message": "error"
    }
    `
    ```

---

<!-- COMERCIOS -->

# API de Comercios

## Descripción:

Esta API permite gestionar el registro de los comercios y obtener los datos de los comercios registrados.

---

## Autenticación:

- **Método de autenticación:** Bearer Token (utilizando Sanctum).
- **Cabecera:** `Authorization: Bearer <token>`

---

## Endpoints

### 1. Registrar Comercio

- **URL:** `/api/comercios`
- **Método:** `POST`
- **Descripción:** Registra el comercio.
- **Parámetros:** .
  ```json
  {
    "nombre": "Test",
    "email": "test@test.com",
    "phone": "12345678",
    "street_address": "C/ Falsa, 123",
    "ciudad": "Barcelona",
    "provincia": "Barcelona",
    "codigo_postal": 28,
    "num_planta": "1",
    "num_puerta": "19",
    "descripcion": "aDASDASFD",
    "categoria": 12,
    "idUser": 12,
    "gestion_stock": "1",
    "numero_planta": null,
    "numero_puerta": null
  }
  ```
- **Respuesta:**

  - **Código de estado 200 OK**:

    ```json
    {
      "nombre": "Test",
      "idUser": 12,
      "email": "test@test.com",
      "phone": "12345678",
      "calle_num": "C/ Falsa, 123",
      "ciudad": "Barcelona",
      "provincia": "Barcelona",
      "codigo_postal": 28,
      "num_planta": null,
      "num_puerta": null,
      "categoria_id": 12,
      "descripcion": "aDASDASFD",
      "gestion_stock": "1",
      "puntaje_medio": 0,
      "updated_at": "2025-01-27T11:42:25.000000Z",
      "created_at": "2025-01-27T11:42:25.000000Z",
      "id": 11
    }
    ```

  - **Código de estado 422**:
    ```json
    {
      "message": "error"
    }
    ```

---

### 2. Obtener comercio por id

- **URL:** `/api/comercios/{id}`
- **Método:** `GET`
- **Descripción:** Permite obtener la información de un comercio por su id.
- **Parámetros:**
  - `id`: (int, requerido) El ID del cliente que se desea obtener.
- **Respuesta:**

  - **Código de estado 200 OK**:

    ```json
    {
      "id": 1,
      "nombre": "Bradtke, Dare and Leuschke",
      "idUser": 10,
      "email": "iliana12@farrell.com",
      "email_verified_at": null,
      "phone": "603689215",
      "phone_verified_at": null,
      "calle_num": "5971 Herzog Motorway",
      "ciudad": "Castelldefels",
      "provincia": "Barcelona",
      "codigo_postal": "08860",
      "categoria_id": 1,
      "num_planta": 5,
      "num_puerta": 4,
      "descripcion": "Commodi odit corrupti quos est. Velit ut ut incidunt ipsa provident dicta. Est quae ea ut. Cupiditate iste nobis optio sequi similique numquam.",
      "gestion_stock": 1,
      "puntaje_medio": 4.6,
      "imagenes": "[\"https://via.placeholder.com/640x480.png/008855?text=debitis\"]",
      "horario": "{\"lunes\": \"09:00 - 18:00\", \"jueves\": \"09:00 - 18:00\", \"martes\": \"09:00 - 18:00\", \"domingo\": \"Cerrado\", \"sábado\": \"10:00 - 14:00\", \"viernes\": \"09:00 - 18:00\", \"miércoles\": \"09:00 - 18:00\"}",
      "created_at": null,
      "updated_at": null
    }
    ```

  - **Código de estado 404 Not Found** (Si no esta registrado):

    ```json
    {
      "message": "Comercio no encontrado"
    }
    ```

---

### 3. Obtener comercios

- **URL:** `/api/comercios`
- **Método:** `GET`
- **Descripción:** Permite obtener la información de los comercios.
- **Parámetros:** Ninguno.
- **Respuesta:**

  - **Código de estado 200 OK**:

    ```json
    {
      "id": 1,
      "nombre": "Bradtke, Dare and Leuschke",
      "idUser": 10,
      "email": "iliana12@farrell.com",
      "email_verified_at": null,
      "phone": "603689215",
      "phone_verified_at": null,
      "calle_num": "5971 Herzog Motorway",
      "ciudad": "Castelldefels",
      "provincia": "Barcelona",
      "codigo_postal": "08860",
      "categoria_id": 1,
      "num_planta": 5,
      "num_puerta": 4,
      "descripcion": "Commodi odit corrupti quos est. Velit ut ut incidunt ipsa provident dicta. Est quae ea ut. Cupiditate iste nobis optio sequi similique numquam.",
      "gestion_stock": 1,
      "puntaje_medio": 4.6,
      "imagenes": "[\"https://via.placeholder.com/640x480.png/008855?text=debitis\"]",
      "horario": "{\"lunes\": \"09:00 - 18:00\", \"jueves\": \"09:00 - 18:00\", \"martes\": \"09:00 - 18:00\", \"domingo\": \"Cerrado\", \"sábado\": \"10:00 - 14:00\", \"viernes\": \"09:00 - 18:00\", \"miércoles\": \"09:00 - 18:00\"}",
      "created_at": null,
      "updated_at": null
    }
    ```

---

<!-- CATEGORIAS -->

# API de Categorias

## Descripción:

Esta API permite gestionar las categorias.

---

## Autenticación:

- **Método de autenticación:** Bearer Token (utilizando Sanctum).
- **Cabecera:** `Authorization: Bearer <token>`

---

## Endpoints

### 1. Obtener categorias

- **URL:** `/api/categorias`
- **Método:** `GET`
- **Descripción:** Obtiene todas las categorias.
- **Parámetros:** Ninguno.
- **Respuesta:**

  - **Código de estado 200 OK**:

    ```json
    [
      {
        "id": 1,
        "name": "Indumentaria"
      },
      {
        "id": 2,
        "name": "Tecnología"
      },
      {
        "id": 3,
        "name": "Hogar y Decoración"
      },
      {
        "id": 4,
        "name": "Salud y Belleza"
      },
      "..."
    ]
    ```

---

<!-- CLIENTES -->

# API de Clientes

## Descripción:

Esta API permite gestionar los clientes.

---

## Autenticación:

- **Método de autenticación:** Bearer Token (utilizando Sanctum).
- **Cabecera:** `Authorization: Bearer <token>`

---

## Endpoints

### 1. Obtener cliente por id

- **URL:** `/api/cliente/{id}`
- **Método:** `GET`
- **Descripción:** Permite obtener la información de un cliente por su id.
- **Parámetros:**
  - `id`: (int, requerido) El ID del cliente que se desea obtener.
- **Respuesta:**

  - **Código de estado 200 OK**:

    ```json
    {
      "id": 12,
      "name": "Lorenzo",
      "apellidos": "Moll",
      "email": "lorenzo@gmail.com",
      "email_verified_at": null,
      "phone": "603397347",
      "phone_verified_at": null,
      "street_address": "Carrer Confiança 32",
      "ciudad": "Ciutadella",
      "provincia": "Menorca",
      "codigo_postal": 7760,
      "numero_planta": 1,
      "numero_puerta": 4,
      "puntos": null,
      "created_at": null,
      "updated_at": "2025-01-30T08:26:31.000000Z"
    }
    ```

  - **Código de estado 404 Not Found** (Si no esta registrado):

    ```json
    {
      "message": "Cliente no encontrado"
    }
    ```

---

### 2. Actualizar información de personal del cliente

- **URL:** `/api/cliente/{id}/datos-personales`
- **Método:** `GET`
- **Descripción:** Permite actualizar la información personal de un cliente.
- **Parámetros:**
  - `id`: (int, requerido) El ID del cliente que se desea obtener.
- **Respuesta:**

  - **Código de estado 200 OK**:

    ```json
    {
      "id": 12,
      "name": "Lorenzo",
      "apellidos": "Moll Anglada",
      "email": "lorenzo@gmail.com",
      "email_verified_at": null,
      "phone": "603397347",
      "phone_verified_at": null,
      "street_address": "Carrer Confiança 32",
      "ciudad": "Ciutadella",
      "provincia": "Menorca",
      "codigo_postal": 7760,
      "numero_planta": 1,
      "numero_puerta": 4,
      "puntos": null,
      "created_at": null,
      "updated_at": "2025-01-30T09:12:06.000000Z"
    }
    ```

  - **Código de estado 404 Not Found** (Si no esta registrado):

    ```json
    {
      "message": "Cliente no encontrado"
    }
    ```

  - **Código de estado 400 Not Found** (Si los datos enviados son incorrectos):

    ```json
    {
      "message": "Datos incorrectos"
    }
    ```

---

### 3. Actualizar información de facturación del cliente

- **URL:** `/api/cliente/{id}/datos-personales`
- **Método:** `GET`
- **Descripción:** Permite actualizar la información de facturación de un cliente.
- **Parámetros:**
  - `id`: (int, requerido) El ID del cliente que se desea obtener.
- **Respuesta:**

  - **Código de estado 200 OK**:

    ```json
    {
      "id": 12,
      "name": "Lorenzo",
      "apellidos": "Moll Anglada",
      "email": "lorenzo@gmail.com",
      "email_verified_at": null,
      "phone": "603397347",
      "phone_verified_at": null,
      "street_address": "Carrer Confiança 32",
      "ciudad": "Ciutadella",
      "provincia": "Menorca",
      "codigo_postal": 7760,
      "numero_planta": 1,
      "numero_puerta": 5,
      "puntos": null,
      "created_at": null,
      "updated_at": "2025-01-30T09:12:06.000000Z"
    }
    ```

  - **Código de estado 404 Not Found** (Si no esta registrado):

    ```json
    {
      "message": "Cliente no encontrado"
    }
    ```

  - **Código de estado 400 Not Found** (Si los datos enviados son incorrectos):

    ```json
    {
      "message": "Datos incorrectos"
    }
    ```

---
