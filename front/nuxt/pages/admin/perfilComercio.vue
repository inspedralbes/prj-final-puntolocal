<script setup>
import { useAuthStore } from '#imports';
import ButtonComp from '@/components/ButtonComp.vue';
import Loading from "@/components/loading.vue";
definePageMeta({
    layout: 'admin',
});

import { useRuntimeConfig } from "#imports";
import { useToast } from '@/composables/useToast.js';

const { toast } = useToast();
const config = useRuntimeConfig();
const baseUrl = config.public.apiBaseUrl;

let formData = reactive({});
let formComercio = reactive({
    logoImage: null,
    localImage: null
});
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
        // Procesar imágenes
        if (response.comercio.logo_path) {
            formComercio.logoImage = `${baseUrl}/storage/${response.comercio.logo_path}`;
        } else {
            formComercio.logoImage = null;
        }

        if (response.comercio.imagen_local_path) {
            formComercio.localImage = `${baseUrl}/storage/${response.comercio.imagen_local_path}`;
        } else {
            formComercio.localImage = null;
        }

        // Mantener compatibilidad con el formato antiguo (opcional)
        if (response.comercio.imagenes) {
            try {
                const parsed = JSON.parse(response.comercio.imagenes);
                if (parsed.length > 0 && !formComercio.logoImage) {
                    formComercio.logoImage = `${baseUrl}/storage/${parsed[0]}`;
                }
                if (parsed.length > 1 && !formComercio.localImage) {
                    formComercio.localImage = `${baseUrl}/storage/${parsed[1]}`;
                }
            } catch (error) {
                console.error("Error parsing imagenes:", error);
            }
        }

        // Copiar el resto de los datos
        Object.assign(formData, response.comercio);
        Object.assign(formComercio, {
            ...response.comercio,
            logoImage: formComercio.logoImage,
            localImage: formComercio.localImage
        });

        console.log('logo', formComercio.logoImage);
        console.log('local', formComercio.localImage);
    } else {
        toast('Hi ha hagut algun error carregant les dades del comerç', 'error');
    }
}

async function updateComercio() {
    const { $communicationManager } = useNuxtApp();
    let hasChanges = false;

    // Update datos básicos (excluyendo campos de imágenes)
    const { logoImage, localImage, ...comercioData } = formComercio;
    if (JSON.stringify(comercioData) !== JSON.stringify(formData)) {
        const jsonResponse = await $communicationManager.updateComercio(comercioData, authStore.comercio.id);
        
        if (jsonResponse) {
            toast('Informació del comerç actualitzada amb èxit', 'success');
            Object.assign(formData, jsonResponse.comercio);
            hasChanges = true;
        } else {
            toast('Hi ha hagut algun error', 'error');
        }
    }

    // Manejo de imágenes
    const formD = new FormData();
    let shouldUpdateImages = false;

    // Logo
    if (formComercio.logoFile) {
        formD.append('logo', formComercio.logoFile);
        shouldUpdateImages = true;
    } else if (!formComercio.logoImage && formData.logo_path) {
        // Si se eliminó el logo
        formD.append('logo', ''); // Envía campo vacío para indicar eliminación
        shouldUpdateImages = true;
    }

    // Imagen del local
    if (formComercio.localFile) {
        formD.append('imagen_local', formComercio.localFile);
        shouldUpdateImages = true;
    } else if (!formComercio.localImage && formData.imagen_local_path) {
        // Si se eliminó la imagen del local
        formD.append('imagen_local', ''); // Envía campo vacío para indicar eliminación
        shouldUpdateImages = true;
    }

    // Actualizar imágenes si hay cambios
    if (shouldUpdateImages) {
        const imageResponse = await $communicationManager.updateComercioImagenes(formD, authStore.comercio.id);
        
        if (imageResponse) {
            toast('Imatges actualitzades amb èxit', 'success');
            // Actualizar datos locales con las nuevas rutas
            if (imageResponse.logo_path) {
                formComercio.logoImage = `${baseUrl}/storage/${imageResponse.logo_path}`;
            } else {
                formComercio.logoImage = null;
            }
            
            if (imageResponse.imagen_local_path) {
                formComercio.localImage = `${baseUrl}/storage/${imageResponse.imagen_local_path}`;
            } else {
                formComercio.localImage = null;
            }
            
            hasChanges = true;
        } else {
            toast('Hi ha hagut algun error amb les imatges', 'error');
        }
    }

    if (hasChanges) {
        // Refrescar datos del comercio
        await getComercioData();
    }
}

function handleLogoUpload(event) {
    const files = event.target.files;
    const allowedTypes = ["image/jpeg", "image/png", "image/svg+xml", "image/webp"];

    if (files.length === 0) return;

    const file = files[0];

    if (!allowedTypes.includes(file.type)) {
        toast("Solo se permiten imágenes en formato JPG, PNG, SVG o WEBP.", "error");
        return;
    }

    const reader = new FileReader();
    reader.onload = (e) => {
        formComercio.logoImage = e.target.result;
    };
    reader.readAsDataURL(file);
    
    formComercio.logoFile = file;
}

function handleLocalImageUpload(event) {
    const files = event.target.files;
    const allowedTypes = ["image/jpeg", "image/png", "image/svg+xml", "image/webp"];

    if (files.length === 0) return;

    const file = files[0];

    if (!allowedTypes.includes(file.type)) {
        toast("Solo se permiten imágenes en formato JPG, PNG, SVG o WEBP.", "error");
        return;
    }

    const reader = new FileReader();
    reader.onload = (e) => {
        formComercio.localImage = e.target.result;
    };
    reader.readAsDataURL(file);
    
    formComercio.localFile = file;
}

async function removeImage(imageType) {
    const { $communicationManager } = useNuxtApp();
    
    if (imageType === 'logo') {
        formComercio.logoImage = null;
        formComercio.logoFile = null;
    } else {
        formComercio.localImage = null;
        formComercio.localFile = null;
    }

    try {
        const response = await $communicationManager.deleteComercioImagen(
            authStore.comercio.id, 
            { tipo_imagen: imageType }
        );

        if (response) {
            toast('Imatge eliminada amb èxit', 'success');
        }
    } catch (error) {
        toast('Hi ha hagut algun error eliminant la imatge', 'error');
        console.error('Error deleting image:', error);
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
                <div
                    class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 ">
                    <div class="w-full mb-1 mt-16">
                        <div class="mb-4">
                            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl">Informació del
                                comerç</h1>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="bg-white p-6 rounded-lg shadow-sm ">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 ">Informació bàsica</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl ">Nom del comerç</label><input type="text" name="nombre"
                                    class="w-full px-3 py-2 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500  "
                                    v-model="formComercio.nombre">
                            </div>
                            <div><label
                                    class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl ">Email</label><input
                                    type="email" name="email"
                                    class="w-full px-3 py-2 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500  "
                                    v-model="formComercio.email"></div>
                            <div><label
                                    class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl ">Telèfon</label><input
                                    type="tel" name="phone" id="telefono"
                                    class="w-full px-3 py-2 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500  "
                                    v-model="formComercio.phone"></div>
                            <div><label
                                    class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl ">Gestió d'estoc</label>
                                <div class="flex items-center mt-4"><input type="checkbox"
                                        v-model="formComercio.gestion_stock" name="gestion_stock"
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                        :true-value="1" :false-value="0"><span
                                        class="ml-2 text-sm text-gray-600 sm:text-xl ">Activar gestió d'estoc</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm lg:mt-1.5 ">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 ">Adreça</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div><label
                                    class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl ">Carrer i nombre</label><input type="text" name="calle_num"
                                    class="w-full px-3 py-2 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500  "
                                    v-model="formComercio.calle_num"></div>
                            <div><label
                                    class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl ">Ciutat</label><input
                                    type="text" name="ciudad"
                                    class="w-full px-3 py-2 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500  "
                                    v-model="formComercio.ciudad"></div>
                            <div><label
                                    class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl ">Provincia</label><input
                                    type="text" name="provincia"
                                    class="w-full px-3 py-2 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500  "
                                    v-model="formComercio.provincia"></div>
                            <div><label
                                    class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl ">Codi
                                    postal</label><input type="text" name="codigo_postal"
                                    class="w-full px-3 py-2 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500  "
                                    v-model="formComercio.codigo_postal"></div>
                            <div><label
                                    class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl ">Pis</label><input
                                    type="number" name="num_planta"
                                    class="w-full px-3 py-2 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500  "
                                    v-model="formComercio.num_planta"></div>
                            <div><label
                                    class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl ">Porta</label><input
                                    type="number" name="num_puerta"
                                    class="w-full px-3 py-2 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500  "
                                    v-model="formComercio.num_puerta"></div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm lg:mt-1.5 ">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 ">Informació addicional</h3>
                        <div class="space-y-6">
                            <div><label
                                    class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl ">Descripció</label><textarea
                                    name="descripcion" rows="4" v-model="formComercio.descripcion"
                                    class="w-full px-3 py-2 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500  "></textarea>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div><label for="categoria"
                                        class="block text-sm font-medium text-gray-600 mb-1 sm:text-xl ">Categoria</label>
                                    <div class="mt-1">
                                        <select id="categoria" v-model="formComercio.categoria_id"
                                            data-testid="categoria" required=""
                                            class="w-full px-3 py-2 bg-white border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500  ">
                                            <option v-for="categoria in categorias" :key="categoria.id"
                                                :value="categoria.id">
                                                {{ categoria.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-6">Imatges del comerç</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Logo del comercio -->
                                    <div class="mb-6">
                                        <label class="block text-sm font-medium text-gray-600 mb-2 sm:text-xl">Logo del comerç</label>
                                        
                                        <div v-if="formComercio.logoImage" class="relative group w-48 h-48 mb-4">
                                            <img :src="formComercio.logoImage" alt="Logo del comercio"
                                                class="w-full h-full object-contain rounded-lg border border-gray-300">
                                            <div
                                                class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                                <button type="button" @click="removeImage('logo')"
                                                    class="p-2 bg-red-600 text-white rounded-full hover:bg-red-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                        <path
                                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                        <path
                                                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <input type="file" @change="handleLogoUpload" class="hidden" ref="logoFileInput"
                                            accept=".jpg,.jpeg,.png,.svg,.webp">
                                        <button type="button" style="font-size: 16px;" @click="$refs.logoFileInput.click()"
                                            class="flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-image w-4 h-4 mr-2">
                                                <rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect>
                                                <circle cx="9" cy="9" r="2"></circle>
                                                <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
                                            </svg>
                                            {{ formComercio.logoImage ? 'Cambiar Logo' : 'Añadir Logo' }}
                                        </button>
                                    </div>
                                    
                                    <!-- Imagen del local -->
                                    <div class="mb-6">
                                        <label class="block text-sm font-medium text-gray-600 mb-2 sm:text-xl">Imatge del comerç</label>
                                        
                                        <div v-if="formComercio.localImage" class="relative group w-48 h-48 mb-4">
                                            <img :src="formComercio.localImage" alt="Logo del comercio"
                                                class="w-full h-full object-contain rounded-lg border border-gray-300">
                                            <div
                                                class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                                <button type="button" @click="removeImage('imagen_local')"
                                                    class="p-2 bg-red-600 text-white rounded-full hover:bg-red-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                        <path
                                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                        <path
                                                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <input type="file" @change="handleLocalImageUpload" class="hidden" ref="localFileInput"
                                            accept=".jpg,.jpeg,.png,.svg,.webp">
                                        <button type="button" style="font-size: 16px;" @click="$refs.localFileInput.click()"
                                            class="flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-image w-4 h-4 mr-2">
                                                <rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect>
                                                <circle cx="9" cy="9" r="2"></circle>
                                                <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
                                            </svg>
                                            {{ formComercio.localImage ? 'Cambiar Imagen del Local' : 'Añadir Imagen del Local' }}
                                        </button>
                                    </div>
                                </div>
                                <div class="w-full flex justify-end items-center mt-6">
                                    <ButtonComp
                                        style="width: 150px; height: 50px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 18px;"
                                        @click="updateComercio">Guardar</ButtonComp>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<style scoped></style>