<script setup>

import { useAuthStore } from '#imports';

const authStore = useAuthStore();

function logout() {
    authStore.logout();
    navigateTo('/login');
}

</script>

<template>
    <div class="flex flex-col">
        Perfil
        <NuxtLink class="font-semibold text-indigo-600" to="/perfilCliente">Editar Perfil</NuxtLink>
        <button @click="logout" class="text-left">
            LOGOUT
        </button>
        
    </div>
</template>
