<script setup>
import { useAuthStore } from '#imports';
import ButtonComp from '@/components/ButtonComp.vue';
import Loading from "@/components/loading.vue";
definePageMeta({
    layout: 'admin',
});

import { useRuntimeConfig } from "#imports";
const config = useRuntimeConfig();
const baseUrl = config.public.apiBaseUrl;

let formData = reactive({});
let formComercio = reactive({});
const authStore = useAuthStore();
const loading = ref(true);
const categorias = ref('');

async function getCategorias() {
    const { $communicationManager } = useNuxtApp();
    categorias.value = await $communicationManager.getCategorias();
}

async function getComercioData() {
    const { $communicationManager } = useNuxtApp();
    const response = await $communicationManager.getComercio(authStore.comercio.id);

    if (response) {
        if (response.comercio.imagenes) {
            try {
                const parsed = JSON.parse(response.comercio.imagenes);
                response.comercio.imagenes = parsed.map(img => `${baseUrl}/storage/${img}`);
            } catch (error) {
                console.error("Error parsing imagenes:", error);
            }
            console.log(response.comercio.imagenes)
        }
        Object.assign(formData, response.comercio);
        Object.assign(formComercio, response.comercio);
        console.log(formComercio)
    } else {
        console.log('Hi ha hagut algun error');
    }
}

async function updateComercio() {
    const { $communicationManager } = useNuxtApp();

    // Update JSON data
    if (JSON.stringify(formComercio) != JSON.stringify(formData)) {
        const jsonResponse = await $communicationManager.updateComercio(formComercio, authStore.comercio.id);

        if (jsonResponse) {
            console.log('Informació del comerç actualitzada amb èxit')
            Object.assign(formData, jsonResponse.comercio);
        } else {
            console.log('Hi ha hagut algun error');
        }
    } else {
        console.log('No hay cambios en la información del comercio.');
    }

    // Update images with actual file objects
    if (formComercio.selectedFiles && formComercio.selectedFiles.length > 0) {
        const formD = new FormData();
        formComercio.selectedFiles.forEach((file, index) => {
            formD.append(`imagenes[${index}]`, file);
        });

        const imageResponse = await $communicationManager.updateComercioImagenes(formD, authStore.comercio.id);

        if (imageResponse) {
            console.log('Imatge actualitzada amb èxit');
        } else {
            console.log('Hi ha hagut algun error');
        }
    } else {
        console.log(`No s'ha selecionat cap imatge.`)
    }
}

function handleImageUpload(event) {
    const files = event.target.files;
    const allowedTypes = ["image/jpeg", "image/png", "image/svg+xml", "image/webp"];

    // Prepare array for actual file objects
    if (!formComercio.selectedFiles) {
        formComercio.selectedFiles = [];
    }

    // Base64 for preview
    // PARA CUANDO SE PUEDA SUBIR VARIAS IMAGENES
    // if (!Array.isArray(formComercio.imagenes)) {
    //     formComercio.imagenes = [];
    // }
    // for (let i = 0; i < files.length; i++) {
    //     if (!allowedTypes.includes(files[i].type)) {
    //         console.log("Solo se permiten imágenes en formato JPG, PNG, SVG o WEBP.");
    //         continue;
    //     }

    //     const reader = new FileReader();
    //     reader.onload = (e) => {
    //         formComercio.imagenes.push(e.target.result);
    //     };
    //     reader.readAsDataURL(files[i]);
    // }


    //SOLO 1 IMAGEN
    if (files.length === 0) return;

    const file = files[0];

    if (!allowedTypes.includes(file.type)) {
        console.log("Solo se permiten imágenes en formato JPG, PNG, SVG o WEBP.");
        return;
    }

    const reader = new FileReader();
    reader.onload = (e) => {
        // Reemplaza la imagen en lugar de agregar más
        formComercio.imagenes = [e.target.result];
    };
    reader.readAsDataURL(file);

    // Evita duplicaciones y solo añade el nuevo archivo
    if (files.length > 0) {
        formComercio.selectedFiles = [...files].filter(file => allowedTypes.includes(file.type));
    }
}

async function removeImage(index) {
    const { $communicationManager } = useNuxtApp();
    const fullUrl = formComercio.imagenes[index];
    const prefix = `${baseUrl}/storage/`;
    const imagePath = fullUrl.replace(prefix, '');

    const response = await $communicationManager.deleteComercioImagen(authStore.comercio.id, imagePath);
    if (response && !response.error) {
        formComercio.imagenes.splice(index, 1);
    }
}

onMounted(() => {
    loading.value = true;
    if (!authStore.isAuthenticated) {
        navigateTo('/login');
    }
    getComercioData();
    getCategorias();
    loading.value = false;
})

</script>

<template>
    <div>
        <main>
            <div v-if="loading" class="flex justify-center items-center">
                <Loading />
            </div>
            <div v-else>
                <div class="mx-4">
                    <div
                        class="mb-6 rounded-lg p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
                        <div class="w-full mb-1 mt-16">
                            <div class="mb-4 flex">
                                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Tots els
                                    productes
                                </h1>
                                <ButtonComp
                                    class="group relative flex ml-auto justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50"
                                    @click="updateComercio"> Guardar </ButtonComp>
                            </div>
                        </div>

                    </div>
                    <div class="mb-6 bg-white p-6 rounded-lg shadow-sm lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 dark:text-white">Información Básica</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div><label
                                    class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl dark:text-white">Nombre
                                    del
                                    Comercio</label><input type="text" name="nombre"
                                    class="w-full px-3 py-2 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:text-white"
                                    v-model="formComercio.nombre"></div>
                            <div><label
                                    class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl dark:text-white">Email</label><input
                                    type="email" name="email"
                                    class="w-full px-3 py-2 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:text-white"
                                    v-model="formComercio.email"></div>
                            <div><label
                                    class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl dark:text-white">Teléfono</label><input
                                    type="tel" name="phone"
                                    class="w-full px-3 py-2 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:text-white"
                                    v-model="formComercio.phone"></div>
                            <div><label
                                    class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl dark:text-white">Gestión
                                    de Stock</label>
                                <div class="flex items-center mt-4"><input type="checkbox"
                                        v-model="formComercio.gestion_stock" name="gestion_stock"
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                        :true-value="1" :false-value="0"><span
                                        class="ml-2 text-sm text-gray-600 sm:text-xl dark:text-white">Activar
                                        gestión de stock</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-6 bg-white p-6 rounded-lg shadow-sm lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 dark:text-white">Dirección</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div><label
                                    class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl dark:text-white">Calle
                                    y
                                    Número</label><input type="text" name="calle_num"
                                    class="w-full px-3 py-2 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:text-white"
                                    v-model="formComercio.calle_num"></div>
                            <div><label
                                    class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl dark:text-white">Ciudad</label><input
                                    type="text" name="ciudad"
                                    class="w-full px-3 py-2 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:text-white"
                                    v-model="formComercio.ciudad"></div>
                            <div><label
                                    class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl dark:text-white">Provincia</label><input
                                    type="text" name="provincia"
                                    class="w-full px-3 py-2 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:text-white"
                                    v-model="formComercio.provincia"></div>
                            <div><label
                                    class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl dark:text-white">Código
                                    Postal</label><input type="text" name="codigo_postal"
                                    class="w-full px-3 py-2 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:text-white"
                                    v-model="formComercio.codigo_postal"></div>
                            <div><label
                                    class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl dark:text-white">Planta</label><input
                                    type="number" name="num_planta"
                                    class="w-full px-3 py-2 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:text-white"
                                    v-model="formComercio.num_planta"></div>
                            <div><label
                                    class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl dark:text-white">Puerta</label><input
                                    type="number" name="num_puerta"
                                    class="w-full px-3 py-2 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:text-white"
                                    v-model="formComercio.num_puerta"></div>
                        </div>
                    </div>
                    <div class="mb-6 bg-white p-6 rounded-lg shadow-sm lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 dark:text-white">Información Adicional</h3>
                        <div class="space-y-6">
                            <div><label
                                    class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl dark:text-white">Descripción</label><textarea
                                    name="descripcion" rows="4" v-model="formComercio.descripcion"
                                    class="w-full px-3 py-2 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:text-white"></textarea>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div><label
                                        class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl dark:text-white">Puntaje
                                        Medio</label><input type="number" name="puntaje_medio" min="0" max="5"
                                        step="0.1"
                                        class="w-full px-3 py-2 bg-white border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:text-white cursor-not-allowed"
                                        v-model="formComercio.puntaje_medio" disabled></div>
                                <div><label for="categoria"
                                        class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl dark:text-white">Categoria</label>
                                    <div class="mt-1">
                                        <select id="categoria" v-model="formComercio.categoria_id"
                                            data-testid="categoria" required=""
                                            class="w-full px-3 py-2 bg-white border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:text-white">
                                            <option v-for="categoria in categorias" :key="categoria.id"
                                                :value="categoria.id">
                                                {{ categoria.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div><label class="text-lg font-semibold text-gray-800 mb-4 dark:text-white">Imágenes del
                                    Comercio</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div v-for="(imagen, index) in formComercio.imagenes" :key="index"
                                        class="relative group">
                                        <img :src="imagen" alt="Imagen del comercio"
                                            class="w-full h-48 object-cover rounded-lg">
                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                            <button type="button" @click="removeImage(index)"
                                                class="p-2 bg-red-600 text-white rounded-full hover:bg-red-700"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path
                                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                    <path
                                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                                </svg></button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Incluir "multiple" para varias imagenes -->
                                <input type="file" @change="handleImageUpload" class="hidden" ref="fileInput"
                                    accept=".jpg,.jpeg,.png,.svg,.webp">
                                <button type="button" @click="$refs.fileInput.click()"
                                    class="mt-4 flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-500 dark:text-white"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-image w-4 h-4 mr-2">
                                        <rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect>
                                        <circle cx="9" cy="9" r="2"></circle>
                                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
                                    </svg>Añadir Imagen</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<style scoped></style>