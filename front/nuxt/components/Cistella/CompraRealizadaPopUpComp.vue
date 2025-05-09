<template>
    <div class="bg-white p-6 rounded-2xl shadow-xl max-w-sm text-center animate-fadeIn">
        <!-- Ícono de confirmación -->
        <div class="w-16 h-16 bg-green-500 text-white rounded-full mx-auto mb-4 flex items-center justify-center">
            <span class="text-2xl font-bold">✔</span>
        </div>

        <h2 class="text-2xl font-semibold text-gray-800">Comanda realitzada amb èxit!</h2>
        <p class="text-gray-600 mt-2">Rebràs un correu quan la teva comanda estigui llesta per a recollir.</p>

        <div class="mt-6 flex gap-4">
            <button @click="seguirComprant"
                class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg">
                Seguir comprant
            </button>
            <button @click="veureOrdre"
                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
                Veure la comanda
            </button>
        </div>
    </div>
</template>

<script setup>
import { useRouter } from "vue-router";
const router = useRouter();

defineProps({
    veureOrdre: {
        type: Function
    }
})
const seguirComprant = () => {
    router.push('/'); // Ajusta la ruta segons la teva aplicació
};
</script>