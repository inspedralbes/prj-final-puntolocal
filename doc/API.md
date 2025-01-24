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
                "subcategoria": "Subcategoría 1",
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

### 2. Crear un nuevo producto

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
      "precio": 100.00,
      "subcategoria_id": 1,
      "comercio_id": 1,
      "stock": 10
  }

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
            "precio": 100.00,
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

### 3. Obtener un producto específico

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

### 4. Actualizar un producto

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
        "nombre" : "Test nombre cambio",
        "descripcion" : "Test descripcion",
        "precio" : 99.99,
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

### 5. Eliminar un producto

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
---
    