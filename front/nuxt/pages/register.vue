<script setup>
import { useNuxtApp, navigateTo } from '#app';
import { useAuthStore } from '@/stores/authStore';

definePageMeta({
    layout: 'authentication',
});

const formData = reactive({
    name: '',
    apellidos: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
    street_address: '',
    ciudad: '',
    provincia: '',
    codigo_postal: '',
    numero_planta: '',
    numero_puerta: '',
});

async function register() {
    const { $communicationManager } = useNuxtApp(); 

    // Verificar si los campos están vacíos
    if (!formData.name || !formData.apellidos || !formData.email || !formData.password || !formData.password_confirmation) {
        console.error('És necessari completar tots els camps');
        return;
    }

    // Verificar que la contraseña tenga al menos 8 caracteres
    if (formData.password.length < 8) {
        console.error('La contrasenya ha de tenir mínim 8 caràcters');
        return;
    }

    // Verificar que las contraseñas coincidan
    if (formData.password !== formData.password_confirmation) {
        console.error('Les contrasenyes no coincideixen');
        return;
    }
    
    // Llamar al plugin communicationManager para registrar
    const response = await $communicationManager.register(formData); 

    if(response){
        console.log(`S'ha registrat correctament`)
        navigateTo('/login')
    }else{
        console.log('Hi ha hagut algun error, comprovi les seves dades');
    }

}

onMounted(() => {
    const authStore = useAuthStore();
    if (authStore.isAuthenticated) {
        navigateTo('/');
    }
});

</script>

<template>
    <div class="bg-gray-100">
        <div class="flex min-h-[100vh] flex-col justify-center py-12 sm:px-6 lg:px-8">
            <div class="text-center sm:mx-auto sm:w-full sm:max-w-md">
                <h1 class="text-3xl font-extrabold text-gray-900">
                    Registra't
                </h1>
            </div>
            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                <div class="bg-white mx-5 px-4 pb-4 pt-8 sm:rounded-lg sm:px-10 sm:pb-6 sm:shadow rounded-md">
                    <form @submit.prevent="register" class="space-y-6">
                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                            <div class="mt-1">
                                <input id="nom" name="nom" v-model="formData.name" type="text" data-testid="nom" required=""
                                    class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>
                        <div>
                            <label for="cognoms" class="block text-sm font-medium text-gray-700">Cognoms</label>
                            <div class="mt-1">
                                <input id="cognoms" name="cognoms" v-model="formData.apellidos" type="text" data-testid="cognoms"
                                    required=""
                                    class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Correu electrònic</label>
                            <div class="mt-1">
                                <input id="email" v-model="formData.email" type="text" data-testid="email" required=""
                                    class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Contrasenya</label>
                            <div class="mt-1">
                                <input id="password" name="password" v-model="formData.password" type="password"
                                    data-testid="password" required=""
                                    class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>
                        <div>
                            <label for="password-repeat" class="block text-sm font-medium text-gray-700">Repetir
                                contrasenya</label>
                            <div class="mt-1">
                                <input id="password-repeat" name="password-repeat" type="password" v-model="formData.password_confirmation"
                                    data-testid="password-repeat" required=""
                                    class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>
                        <div>
                            <ButtonComp test-id="register" @submit.prevent="register">
                                Registrar-se
                            </ButtonComp>
                        </div>
                    </form>
                    <div class="m-auto mt-6 w-fit md:mt-8">
                        <span class="m-auto">Ja tens compte?
                            <NuxtLink class="font-semibold text-indigo-600" to="/login">Inicia sessió</NuxtLink>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>