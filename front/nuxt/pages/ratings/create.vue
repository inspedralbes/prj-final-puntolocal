<template>
    <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6">Valorar {{ ratingType === 'comercio' ? 'Comercio' : 'Producto' }}</h1>

        <form @submit.prevent="submitRating">
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Puntuació (1-5)</label>
                <select v-model="form.rating" class="w-full p-2 border rounded">
                    <option v-for="i in 5" :key="i" :value="i">{{ i }}</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Comentari (opcional)</label>
                <textarea v-model="form.comment" class="w-full p-2 border rounded"></textarea>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">
                Enviar Valoració
            </button>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useAuthStore } from '~/stores/authStore';

const { $communicationManager } = useNuxtApp();
const route = useRoute();
const router = useRouter();
const authStore = useAuthStore();

const ratingType = ref(route.query.type);
const ratingId = ref(route.query.id);
const orderId = ref(route.query.order_id);

const form = ref({
    rating: 5,
    comment: ''
});

const submitRating = async () => {
    try {
        const valoracion = {
            rateable_type: ratingType.value,
            rateable_id: ratingId.value,
            rating: form.value.rating,
            comment: form.value.comment
        };

        console.log('Valoración a enviar:', valoracion);

        const response = await $communicationManager.storeRating(valoracion);

        // Redirigir de vuelta a la página de la compra
        router.push(`/perfil/compras/${orderId.value}`);
    } catch (error) {
        console.error('Error al enviar valoración:', error);
    }
};
</script>