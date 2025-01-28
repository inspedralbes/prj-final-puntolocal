<script setup>
import {
    navigateTo
} from '#app';
import {
    useAuthStore
} from '@/stores/authStore';
import { ref } from 'vue';

definePageMeta({
    layout: 'default',
});

const authStore = useAuthStore();

let formData = reactive([]);
const currentSection = ref('personal');

function showSection(section) {
    console.log(currentSection)
    currentSection.value = section;
}

async function getUserData() {
    const {
        $communicationManager
    } = useNuxtApp(); // Acceder al communicationManager

    // Llamar al plugin communicationManager para registrar
    const response = await $communicationManager.getUserData(authStore.user.id);

    if (response) {
        formData = response;
    } else {
        console.log('Hi ha hagut algun error');
    }
}

onMounted(() => {
    if (!authStore.isAuthenticated) {
        navigateTo('/login');
    }
    getUserData();
});
</script>

<template>
    <div class="bg-gray-100 p-2">
        <div class="flex flex-col mt-4 sm:flex-row gap-2 mb-6 px-4">
            <button @click="showSection('personal')"
                class="w-full md:w-auto px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 bg-blue-600 text-white">
                Datos Personales
            </button>
            <button @click="showSection('password')"
                class="w-full md:w-auto px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 bg-gray-100 text-gray-600 hover:bg-gray-200">
                Contraseña
            </button>
            <button @click="showSection('address')"
                class="w-full md:w-auto px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 bg-gray-100 text-gray-600 hover:bg-gray-200">
                Dirección
            </button>
        </div>
        <div class="relative">
            <div v-if="currentSection === 'personal'" class="mx-3">
                <!-- Contenido de Datos Personales -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-user h-5 w-5 text-gray-400">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <input type="text" name="nombre"
                        class="pl-10 w-full h-11 rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm"
                        value="">
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-user h-5 w-5 text-gray-400">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <input type="text" name="apellidos"
                        class="pl-10 w-full h-11 rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm"
                        value="">
                </div>
            </div>
            <div v-else-if="currentSection === 'password'">
                <!-- Contenido de Contraseña -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-user h-5 w-5 text-gray-400">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <input type="text" name="password"
                        class="pl-10 w-full h-11 rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm"
                        value="">
                </div>
            </div>
            <div v-else-if="currentSection === 'address'">
                <!-- Contenido de Dirección -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-user h-5 w-5 text-gray-400">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <input type="text" name="calle"
                        class="pl-10 w-full h-11 rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm"
                        value="">
                </div>
            </div>
        </div>
    </div>
</template>
