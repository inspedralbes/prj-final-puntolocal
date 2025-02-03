<script setup>
import { useAuthStore } from '#imports';
import Loading from "@/components/loading.vue";
definePageMeta({
    layout: 'admin',
});

let formData = reactive({});
let formComercio = reactive({});
const authStore = useAuthStore();
const loading = ref(true);

async function getComercioData() {
    loading.value = true;
    const {
        $communicationManager
    } = useNuxtApp();

    const response = await $communicationManager.getComercio(authStore.comercio.id);

    if (response) {
        Object.assign(formData, response)
        Object.assign(formComercio, response)
        console.log(formData)
    } else {
        console.log('Hi ha hagut algun error');
    }

    loading.value = false;
}

async function updateComercio() {

    console.log(formComercio)
}

onMounted(async () => {
    getComercioData();
})

</script>

<template>
    <div>
        <main>
            <div class="mx-4">


                <div
                    class="mb-6 rounded-lg p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
                    <div class="w-full mb-1 mt-16">
                        <div class="mb-4 flex">
                            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Tots els
                                productes
                            </h1>
                            <button class="ml-auto" @click="updateComercio"> Guardar </button>
                        </div>
                    </div>

                </div>
                <div class="mb-6 bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Información Básica</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div><label class="block text-sm font-medium text-gray-600 mb-1">Nombre del
                                Comercio</label><input type="text" name="nombre"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                v-model="formComercio.nombre"></div>
                        <div><label class="block text-sm font-medium text-gray-600 mb-1">Email</label><input
                                type="email" name="email"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                v-model="formComercio.email"></div>
                        <div><label class="block text-sm font-medium text-gray-600 mb-1">Teléfono</label><input
                                type="tel" name="phone"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                v-model="formComercio.phone"></div>
                        <div><label class="block text-sm font-medium text-gray-600 mb-1">Gestión de Stock</label>
                            <div class="flex items-center mt-4"><input type="checkbox"
                                    v-model="formComercio.gestion_stock" name="gestion_stock"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                    :true-value="1" :false-value="0"><span class="ml-2 text-sm text-gray-600">Activar
                                    gestión de stock</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Dirección</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div><label class="block text-sm font-medium text-gray-600 mb-1">Calle y Número</label><input
                                type="text" name="calle_num"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="Calle Principal 123"></div>
                        <div><label class="block text-sm font-medium text-gray-600 mb-1">Ciudad</label><input
                                type="text" name="ciudad"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="Madrid"></div>
                        <div><label class="block text-sm font-medium text-gray-600 mb-1">Provincia</label><input
                                type="text" name="provincia"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="Madrid"></div>
                        <div><label class="block text-sm font-medium text-gray-600 mb-1">Código Postal</label><input
                                type="text" name="codigo_postal"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="28001"></div>
                        <div><label class="block text-sm font-medium text-gray-600 mb-1">Planta</label><input
                                type="text" name="num_planta"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="4"></div>
                        <div><label class="block text-sm font-medium text-gray-600 mb-1">Puerta</label><input
                                type="text" name="num_puerta"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="B"></div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<style scoped></style>