<template>
    <div class="form-container">
        <h2 class="form-title">Afegir Producte</h2>

        <form @submit.prevent="submitForm" class="product-form">
            <div class="input-group">
                <label for="nombre" class="label">Nom del Producte</label>
                <input type="text" v-model="form.nombre" id="nombre" placeholder="Introdueix el nom del producte"
                    class="input-field" required />
            </div>

            <div class="input-group">
                <label for="categoria" class="label">Categoria</label>
                <select v-model="form.categoriaSeleccionada" id="categoria" class="input-field">
                    <option value="" disabled selected>Selecciona una categoria</option>
                    <!-- Mostrar las categorías en el desplegable -->
                    <option v-for="(categoria, index) in form.categorias" :key="index" :value="categoria.id">
                        {{ categoria.name }}
                    </option>
                </select>
            </div>

            <!-- Descripció -->
            <div class="input-group">
                <label for="descripcion" class="label">Descripció</label>
                <textarea v-model="form.descripcion" id="descripcion" placeholder="Introdueix una descripció"
                    class="input-field" required></textarea>
            </div>

            <!-- Imatges Generals -->
            <div class="input-group">
                <label for="imagenesGenerales" class="label">Imatges Generals (màxim 4)</label>
                <input type="file" accept="image/*" @change="handleGeneralImageChange" multiple id="imagenesGenerales"
                    class="file-input" />
                <div v-if="form.imagenesGenerales.length > 0" class="image-preview">
                    <p class="preview-text">Imatges generals carregades:</p>
                    <div class="image-wrapper">
                        <div v-for="(image, imgIndex) in form.imagenesGenerales" :key="imgIndex" class="image-item">
                            <img :src="image" alt="Vista prèvia" class="image-thumbnail" />
                            <button type="button" @click="removeGeneralImage(imgIndex)" class="remove-btn">X</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preu General -->
            <div class="input-group">
                <label for="precioGeneral" class="label">Preu General (€)</label>
                <input type="number" v-model="form.precioGeneral" id="precioGeneral"
                    placeholder="Introdueix el preu general" class="input-field" />
            </div>

            <!-- Variants -->
            <div class="variants-group">
                <h3 class="variants-title">Variants</h3>
                <div v-for="(variant, index) in form.varientes" :key="index" class="variant-item">
                    <!-- Color -->
                    <div class="input-group">
                        <label :for="'color-' + index" class="label">Color</label>
                        <input type="text" v-model="variant.color" :id="'color-' + index"
                            placeholder="Introdueix un color" class="input-field" required />
                    </div>

                    <!-- Mides -->
                    <div class="sizes-group">
                        <label :for="'sizes-' + index" class="label">Mides</label>
                        <div v-for="(size, sizeIndex) in variant.sizes" :key="sizeIndex" class="size-item">
                            <input type="text" v-model="size.name" placeholder="Introdueix una mida"
                                class="input-field" />
                            <input type="number" v-model="size.precio" placeholder="Preu (€)" class="input-number" />
                            <button type="button" @click="removeSize(index, sizeIndex)" class="remove-size-btn">
                                Eliminar Mida
                            </button>
                        </div>
                        <button type="button" @click="addSize(index)" class="add-size-btn">Afegir Mida</button>
                    </div>

                    <!-- Imatges de Variants -->
                    <div class="input-group">
                        <label for="imagenesVariante" class="label">Imatges (màxim 4)</label>
                        <input type="file" accept="image/*" @change="handleImageChange($event, index)" multiple
                            id="imagenesVariante" class="file-input" />
                        <div v-if="variant.imagenes.length > 0" class="image-preview">
                            <p class="preview-text">Imatges carregades:</p>
                            <div class="image-wrapper">
                                <div v-for="(image, imgIndex) in variant.imagenes" :key="imgIndex" class="image-item">
                                    <img :src="image" alt="Vista prèvia" class="image-thumbnail" />
                                    <button type="button" @click="removeImage(index, imgIndex)" class="remove-btn">
                                        X
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" @click="addVariant" class="add-variant-btn">Afegir Variant</button>
            </div>

            <!-- Botó d'Enviar -->
            <div class="submit-btn-container">
                <button type="submit"
                    :disabled="form.varientes.length === 0 || form.varientes.some(variant => variant.imagenes.length === 0)"
                    class="submit-btn">
                    Guardar Producte
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
definePageMeta({
    layout: false,
});
import { ref, onMounted } from "vue";
const { $communicationManager } = useNuxtApp();

// Función para obtener las subcategorías y mostrar en consola
const fetchSubcategorias = async () => {
    const categoria_id = 1; // O el ID que deseas pasar
    const result = await $communicationManager.getSubcategoriasByCategoriaId(categoria_id);

    // Mostramos los resultados en la consola
    console.log('Subcategorías obtenidas:', result);

    // Asignamos las subcategorías al formulario (form.categorias)
    if (result && result.success && result.data) {
        form.value.categorias = result.data; // Usamos el campo `data` para obtener las subcategorías
    } else {
        console.error('No se pudieron obtener las subcategorías');
    }
};

const form = ref({
    nombre: "",
    descripcion: "",
    categoriaSeleccionada: "",
    categorias: [], // Se inicializa vacío, se llenará con las subcategorías
    precioGeneral: null,
    imagenesGenerales: [],
    varientes: [
        {
            color: "",
            sizes: [
                {
                    name: "",
                    precio: null,
                },
            ],
            imagenes: [],
        },
    ],
});

const addVariant = () => {
    form.value.varientes.push({
        color: "",
        sizes: [
            {
                name: "",
                precio: null,
            },
        ],
        imagenes: [],
    });
};

const addSize = (variantIndex) => {
    form.value.varientes[variantIndex].sizes.push({
        name: "",
        precio: null,
    });
};

const removeSize = (variantIndex, sizeIndex) => {
    form.value.varientes[variantIndex].sizes.splice(sizeIndex, 1);
};

const handleGeneralImageChange = (event) => {
    const files = Array.from(event.target.files);
    const maxFiles = 4;
    if (files.length + form.value.imagenesGenerales.length > maxFiles) {
        alert(`Solo puedes subir hasta ${maxFiles} imágenes.`);
        return;
    }
    const fileURLs = files.map((file) => URL.createObjectURL(file));
    form.value.imagenesGenerales.push(...fileURLs);
};

const removeGeneralImage = (imgIndex) => {
    form.value.imagenesGenerales.splice(imgIndex, 1);
};

const handleImageChange = (event, index) => {
    const files = Array.from(event.target.files);
    const maxFiles = 4;
    if (files.length + form.value.varientes[index].imagenes.length > maxFiles) {
        alert(`Solo puedes subir hasta ${maxFiles} imágenes por variante.`);
        return;
    }
    const fileURLs = files.map((file) => URL.createObjectURL(file));
    form.value.varientes[index].imagenes.push(...fileURLs);
};

const removeImage = (variantIndex, imageIndex) => {
    form.value.varientes[variantIndex].imagenes.splice(imageIndex, 1);
};

const submitForm = () => {
    console.log("Formulario enviado:", form.value);
};

// Llamamos a la función cuando el componente se monta
onMounted(fetchSubcategorias);
</script>



<style scoped>
body {
    margin: 0;
    padding: 0;
    color: #333;
    line-height: 1.6;
    background-color: #f9f9f9;
    font-family: 'Arial', sans-serif;
}

select.input-field {
    appearance: none;
    background-color: #fff;
    background-image: url("data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'><path fill='none' d='M0 0h20v20H0z'/><path fill='%23333' d='M7 8l3 3 3-3H7z'/></svg>");
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 12px 12px;
}

.form-container {
    padding: 20px;
    max-width: 1200px;
    margin: 20px auto;
    border-radius: 8px;
    background-color: #fff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.form-title {
    color: #444;
    font-size: 1.8rem;
    text-align: center;
    margin-bottom: 20px;
}

.product-form {
    gap: 20px;
    display: flex;
    flex-direction: column;
}

.input-group {
    display: flex;
    flex-direction: column;
}

.label {
    color: #555;
    font-size: 1rem;
    margin-bottom: 8px;
}

.input-field,
.input-number,
.file-input {
    padding: 10px;
    outline: none;
    font-size: 1rem;
    border-radius: 4px;
    border: 1px solid #ddd;
    transition: border 0.3s ease;
}

.input-field:focus,
.input-number:focus,
.file-input:focus {
    border-color: #007bff;
}

.file-input {
    padding: 6px;
}

.image-preview {
    margin-top: 10px;
}

.preview-text {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 10px;
}

.image-wrapper {
    gap: 10px;
    display: flex;
    flex-wrap: wrap;
}

.image-item {
    width: 80px;
    height: 80px;
    overflow: hidden;
    border-radius: 4px;
    position: relative;
    border: 1px solid #ddd;
}

.image-thumbnail {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.remove-btn {
    top: 4px;
    right: 4px;
    width: 20px;
    height: 20px;
    border: none;
    color: #fff;
    cursor: pointer;
    font-size: 0.8rem;
    border-radius: 50%;
    position: absolute;
    background: #ff4d4d;
}

.remove-btn:hover {
    background: #e60000;
}

.variants-group {
    margin-top: 20px;
}

.variants-title {
    color: #444;
    font-size: 1.5rem;
    margin-bottom: 10px;
}

.variant-item {
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    background-color: #f8f8f8;
}

.sizes-group {
    margin-top: 15px;
}

.size-item {
    gap: 10px;
    display: flex;
    margin-bottom: 10px;
}

.add-size-btn,
.add-variant-btn {
    border: none;
    color: #fff;
    cursor: pointer;
    padding: 8px 12px;
    font-size: 0.9rem;
    border-radius: 4px;
    background-color: #007bff;
    transition: background 0.3s ease;
}

.add-size-btn:hover,
.add-variant-btn:hover {
    background-color: #0056b3;
}

.remove-size-btn {
    border: none;
    padding: 8px;
    color: #fff;
    cursor: pointer;
    border-radius: 4px;
    background-color: #ff4d4d;
}

.remove-size-btn:hover {
    background-color: #e60000;
}

.submit-btn-container {
    display: flex;
    margin-top: 20px;
    justify-content: center;
}

.submit-btn {
    border: none;
    color: #fff;
    font-size: 1rem;
    cursor: pointer;
    border-radius: 4px;
    padding: 10px 20px;
    background-color: #28a745;
    transition: background 0.3s ease;
}

.submit-btn:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

.submit-btn:hover:enabled {
    background-color: #218838;
}

@media (max-width: 768px) {
    .form-container {
        padding: 15px;
    }

    .form-title {
        font-size: 1.5rem;
    }

    .input-field,
    .input-number,
    .file-input {
        font-size: 0.9rem;
    }

    .variant-item {
        padding: 10px;
    }

    .submit-btn {
        padding: 8px 16px;
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    .image-wrapper {
        flex-direction: column;
    }

    .size-item {
        gap: 5px;
        flex-direction: column;
    }

    .add-size-btn,
    .add-variant-btn {
        font-size: 0.8rem;
        padding: 6px 10px;
    }

    .submit-btn {
        font-size: 0.8rem;
        padding: 6px 12px;
    }
}
</style>