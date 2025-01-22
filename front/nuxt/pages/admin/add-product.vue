<template>
    <div class="product-form">
        <form @submit.prevent="handleSubmit">
            <div class="form-group">
                <label for="nombre">Nombre del Producto</label>
                <input type="text" id="nombre" v-model="nombre" required />
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" v-model="descripcion" required></textarea>
            </div>

            <div class="form-group">
                <label for="precio">Precio</label>
                <input type="number" id="precio" v-model="precio" required />
            </div>

            <div class="form-group">
                <label for="id_categoria_concreta">Categoría</label>
                <select v-model="id_categoria_concreta" required>
                    <!-- Aquí debes colocar las categorías disponibles -->
                    <option value="1">Categoria 1</option>
                    <option value="2">Categoria 2</option>
                </select>
            </div>

            <div class="form-group">
                <label for="id_comercio">Comercio</label>
                <select v-model="id_comercio" required>
                    <!-- Aquí debes colocar los comercios disponibles -->
                    <option value="1">Comercio 1</option>
                    <option value="2">Comercio 2</option>
                </select>
            </div>

            <div class="form-group">
                <label for="imagenes">Imagenes del Producto</label>
                <div v-for="(image, index) in imagenes" :key="index">
                    <input type="file" :id="'imagen' + index" @change="handleImageChange(index, $event)"
                        accept="image/*" />
                </div>
                <button type="button" @click="addImage" :disabled="imagenes.length >= 4">
                    Añadir Imagen
                </button>
                <div v-if="imageErrors.length" class="error-messages">
                    <ul>
                        <li v-for="(error, index) in imageErrors" :key="index">{{ error }}</li>
                    </ul>
                </div>
            </div>

            <button type="submit" class="submit-btn">Guardar Producto</button>

            <div v-if="formErrors.length" class="error-messages">
                <ul>
                    <li v-for="(error, index) in formErrors" :key="index">{{ error }}</li>
                </ul>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            nombre: '',
            descripcion: '',
            precio: '',
            id_categoria_concreta: '',
            id_comercio: '',
            imagenes: [null], // Inicialmente un input de imagen vacío
            formErrors: [], // Para errores generales
            imageErrors: [], // Para errores de las imágenes
        };
    },
    methods: {
        addImage() {
            if (this.imagenes.length < 4) {
                this.imagenes.push(null); // Añade un nuevo campo de imagen
            }
        },
        handleImageChange(index, event) {
            // Limpiar los errores de imagen previos al hacer un cambio
            this.imageErrors = [];

            const file = event.target.files[0]; // Toma el primer archivo
            if (file) {
                // Aseguramos que solo se agreguen imágenes
                const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!validTypes.includes(file.type)) {
                    this.imageErrors.push('La imagen debe ser de tipo jpg, jpeg, png o gif.');
                } else if (file.size > 2048 * 1024) {
                    this.imageErrors.push('El tamaño de la imagen no debe superar los 2MB.');
                } else {
                    this.imagenes[index] = file; // Si todo es correcto, se asigna el archivo
                }
            }
        },
        async handleSubmit() {
            // Limpiar errores anteriores
            this.formErrors = [];
            this.imageErrors = [];

            const formData = new FormData();
            formData.append('nombre', this.nombre);
            formData.append('descripcion', this.descripcion);
            formData.append('precio', this.precio);
            formData.append('id_categoria_concreta', this.id_categoria_concreta);
            formData.append('id_comercio', this.id_comercio);

            // Añade las imágenes al FormData
            this.imagenes.forEach((imagen, index) => {
                if (imagen) {
                    formData.append('imagenes[]', imagen); // Aquí se agregan las imágenes (suponiendo que son archivos)
                }
            });

            try {
                const response = await fetch('http://localhost:8000/api/afegir-productes', {
                    method: 'POST',
                    body: formData,
                });

                if (response.ok) {
                    const result = await response.json();
                    console.log('Producto creado:', result);
                } else {
                    const result = await response.json();
                    // Mostrar los errores generales de validación (por ejemplo, nombre, descripción)
                    this.formErrors = result.errors ? Object.values(result.errors).flat() : ['Hubo un error al crear el producto.'];

                    // Mostrar errores relacionados con las imágenes
                    if (result.errors && result.errors.imagenes) {
                        this.imageErrors = result.errors.imagenes;
                    }
                }
            } catch (error) {
                console.error('Error en la solicitud:', error);
            }
        },
    },
};
</script>

<style scoped>
.product-form {
    max-width: 500px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #f9f9f9;
}

.title {
    text-align: center;
    margin-bottom: 20px;
    font-size: 24px;
    color: #276bf2;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input,
select,
textarea {
    width: 100%;
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    background-color: #276bf2;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

button:disabled {
    background-color: #ccc;
}

button[type='submit'] {
    margin-top: 20px;
    width: 100%;
}

textarea {
    height: 100px;
}

.error-messages {
    color: red;
    margin-top: 10px;
}

.error-messages ul {
    list-style-type: none;
    padding: 0;
}

.error-messages li {
    margin-bottom: 5px;
}
</style>
