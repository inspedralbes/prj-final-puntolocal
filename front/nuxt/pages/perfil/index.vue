<template>
    <div class="flex flex-col items-center p-6 bg-gray-100 min-h-screen">
        <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md text-center">
            <div class="w-24 h-24 bg-gray-300 rounded-full mx-auto mb-4"></div>
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Usuario</h2>
            <p class="text-gray-600 mb-6">Sin foto de perfil</p>
            <div class="space-y-4">
                <button class="w-full bg-blue-500 text-white py-2 rounded-xl hover:bg-blue-600" @click="goToInfo">
                    Información personal
                </button>

                <button class="w-full bg-blue-500 text-white py-2 rounded-xl hover:bg-blue-600" @click="goToCompras">
                    Veure les meves compres
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { useRouter } from 'vue-router';

    const router = useRouter();

    function goToInfo() { router.push('/perfil/info'); }

    function goToCompras() { router.push('/perfil/compras'); }
</script>