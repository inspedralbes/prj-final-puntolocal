<script setup>
import { navigateTo } from '#app';
import { useAuthStore } from '@/stores/authStore';
import { errorMessages } from 'vue/compiler-sfc';
definePageMeta({
    layout: 'default',
});

import { useRuntimeConfig } from "#imports";
const config = useRuntimeConfig();
const baseUrl = config.public.apiBaseUrl;

const authStore = useAuthStore();
const errorMessage = ref('');
const formData = reactive({
    email: '',
    password: '',
});

async function login() {
    const { $communicationManager } = useNuxtApp(); // Acceder al communicationManager

    // Verificar si los campos están vacíos
    if (!formData.email || !formData.password) {
        console.error('És necessari completar tots els camps');
        errorMessage.value = 'És necessari completar tots els camps';
        return;
    }

    // Verificar que la contraseña tenga al menos 8 caracteres
    if (formData.password.length < 8) {
        console.error('La contrasenya es incorrecta');
        errorMessage.value = 'La contrasenya es incorrecta';
        return;
    }
    // Llamar al plugin communicationManager para registrar
    const response = await $communicationManager.login(formData);

    if (response) {
        authStore.login(response.user, response.token, response.comercio);
        const res = await $communicationManager.getFavoritos(response.user.id);
        authStore.setFavoritos(res);
        navigateTo('/');
    } else {
        console.log('Hi ha hagut algun error, revisi les seves dades');
        errorMessage.value = 'Hi ha hagut algun error, revisi les seves dades';
    }
}

function loginWithGoogle() {
    window.location.href = `${baseUrl}/auth/google`;
};

onBeforeMount(() => {
    if (authStore.isAuthenticated) {
        navigateTo('/');
    }
});
</script>

<template>
    <div class="bg-gray-100">
        <div class="flex min-h-[85vh] flex-col justify-center py-12 sm:px-6 lg:px-8">
            <div class="text-center sm:mx-auto sm:w-full sm:max-w-md">
                <h1 class="text-3xl font-extrabold text-gray-900">
                    Inicia sessió
                </h1>
            </div>
            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                <div class="bg-white mx-5 px-4 pb-4 pt-8 sm:rounded-lg sm:px-10 sm:pb-6 sm:shadow rounded-md">
                    <form @submit.prevent="login" class="space-y-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Correu
                                electrònic /
                                Usuari</label>
                            <div class="mt-1">
                                <input id="email" v-model="formData.email" type="text" data-testid="username"
                                    required=""
                                    class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Contrasenya</label>
                            <div class="mt-1">
                                <input id="password" name="password" v-model="formData.password" type="password"
                                    data-testid="password" autocomplete="current-password"
                                    class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>
                        <div class="text-red-600">
                            {{ errorMessage }}
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember_me" name="remember_me" type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 disabled:cursor-wait disabled:opacity-50">
                                <label for="remember_me" class="ml-2 block text-sm text-gray-900">Recorda'm</label>
                            </div>
                            <div class="text-sm">
                                <NuxtLink to="/reset" class="font-medium text-indigo-400 hover:text-indigo-500">Has
                                    oblidat la teva contrasenya?</NuxtLink>
                            </div>
                        </div>
                        <div>
                            <ButtonComp test-id="login" @submit.prevent="login">
                                Iniciar sessió
                            </ButtonComp>
                        </div>
                    </form>
                    <div class="mt-6">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="bg-white px-2 text-gray-500">O continua amb</span>
                            </div>
                        </div>
                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <button @click="loginWithGoogle"
                                class="inline-flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 shadow-sm hover:bg-gray-50 disabled:cursor-wait disabled:opacity-50">
                                <span class="sr-only">Inicia sessió amb Google</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="-3 -2 24 24" aria-hidden="true">
                                    <clipPath id="p.0">
                                        <path d="m0 0l20.0 0l0 20.0l-20.0 0l0 -20.0z" clip-rule="nonzero"></path>
                                    </clipPath>
                                    <g clip-path="url(#p.0)">
                                        <path fill="currentColor" fill-opacity="0.0" d="m0 0l20.0 0l0 20.0l-20.0 0z"
                                            fill-rule="evenodd"></path>
                                        <path fill="currentColor"
                                            d="m19.850197 8.270351c0.8574047 4.880001 -1.987587 9.65214 -6.6881847 11.218641c-4.700598 1.5665016 -9.83958 -0.5449295 -12.08104 -4.963685c-2.2414603 -4.4187555 -0.909603 -9.81259 3.1310139 -12.6801605c4.040616 -2.867571 9.571754 -2.3443127 13.002944 1.2301085l-2.8127813 2.7000687l0 0c-2.0935059 -2.1808972 -5.468274 -2.500158 -7.933616 -0.75053835c-2.4653416 1.74962 -3.277961 5.040613 -1.9103565 7.7366734c1.3676047 2.6960592 4.5031037 3.9843292 7.3711267 3.0285425c2.868022 -0.95578575 4.6038647 -3.8674583 4.0807285 -6.844941z"
                                            fill-rule="evenodd"></path>
                                        <path fill="currentColor"
                                            d="m10.000263 8.268785l9.847767 0l0 3.496233l-9.847767 0z"
                                            fill-rule="evenodd"></path>
                                    </g>
                                </svg>
                            </button>
                            <button
                                class="inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 shadow-sm hover:bg-gray-50 disabled:cursor-wait disabled:opacity-50">
                                <span class="sr-only">Inicia sessió amb Facebook</span>
                                <svg class="h-6 w-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                    width="800px" height="800px" viewBox="2 2 28 28" version="1.1">
                                    <path
                                        d="M21.95 5.005l-3.306-.004c-3.206 0-5.277 2.124-5.277 5.415v2.495H10.05v4.515h3.317l-.004 9.575h4.641l.004-9.575h3.806l-.003-4.514h-3.803v-2.117c0-1.018.241-1.533 1.566-1.533l2.366-.001.01-4.256z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="m-auto mt-6 w-fit md:mt-8">
                        <span class="m-auto">No tens compte?
                            <NuxtLink class="font-semibold text-indigo-600" to="/register">Crear compte</NuxtLink>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>