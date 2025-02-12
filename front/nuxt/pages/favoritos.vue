<template>
    <header>
        <h1 class="font-bold text-2xl m-4">Mis Favoritos</h1>
    </header>
    <hr class="mb-2">
    <div v-if="authStore?.isAuthenticated">
        <div v-if="loading" class="flex justify-center items-center">
            <Loading />
        </div>
        <div v-else>
            <div class="grid grid-cols-2 m-3 gap-2">
                <div v-for="(producto, index) in favoritos" :key="producto.id" class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img :src="`http://localhost:8000/storage/${producto.imagen}`" :alt=producto.nombre class="w-full h-32 object-cover">
                    <div class="p-3">
                        <h3 class="font-medium text-gray-800 text-sm line-clamp-2 break-all">{{ producto.nombre }}</h3>
                        <p class="text-gray-500 text-xs mt-1 line-clamp-2 break-all">{{ producto.descripcion }}</p>
                        <div class="flex justify-between items-center mt-3">
                            <span class="font-semibold text-sm">{{ producto.precio }}€</span>
                            <span @click.stop="toggleFavoritos(producto?.id)">
                                <svg width="1.2em" height="1.2em"
                                    viewBox="0 0 24 24" fill="#ea4823" stroke="#ea4823" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    style="position: relative; top: 5px; margin-left: 5px; margin-right: 5px;">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                    </path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else>

    </div>
</template>

<script setup>
import { useAuthStore } from '@/stores/authStore';
import Loading from "@/components/loading.vue";

definePageMeta({
    layout: 'default',
});

const authStore = useAuthStore();
const loading = ref(true);
let favoritos = reactive([]);

async function toggleFavoritos(productoID) {
    const { $communicationManager } = useNuxtApp();
    try {
        const response = await $communicationManager.updateFavorito(authStore.user.id, productoID);

        if (response) {
            authStore.toggleFavorito(productoID)

            const index = favoritos.findIndex(producto => producto.id === productoID);
            if (index !== -1) {
                favoritos.splice(index, 1); 
            }
        }

    } catch (error) {
        console.error("Error en la petición:", error);
    }
}

async function getFavoritos() {

    const {
        $communicationManager
    } = useNuxtApp();

    const response = await $communicationManager.getFavoritosInfo(authStore.user.id);

    if (!response) {
        console.log('Error al obtenir les dades')
        return;
    }
    Object.assign(favoritos, response);

}

onMounted(() => {
    loading.value = true;
    getFavoritos();
    loading.value = false;
});
</script>