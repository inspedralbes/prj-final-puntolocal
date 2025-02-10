<template>
    <div class="p-6">
        <p @click="todasLasCategorias()" class="text-blue-500 cursor-pointer hover:underline mb-4">
            Ver todas las categorías
        </p>

        <div v-if="comercios.length" class="space-y-4">
            <h2 class="text-xl font-bold">Lista de Comercios</h2>

            <div class="overflow-x-auto whitespace-nowrap">
                <ul class="flex space-x-4">
                    <li v-for="comercio in comercios" :key="comercio.id"
                        class="min-w-[300px] bg-white shadow-lg rounded-xl p-4 border border-gray-200 flex-shrink-0">
                        <h3 class="text-lg font-semibold text-gray-800">{{ comercio.nombre }}</h3>
                        <p class="text-sm text-gray-600">{{ comercio.descripcion }}</p>
                        <p class="text-sm"><strong>Dirección:</strong> {{ comercio.calle_num }}, {{ comercio.ciudad }}
                        </p>
                        <p class="text-sm"><strong>Teléfono:</strong> {{ comercio.phone }}</p>
                        <p class="text-sm"><strong>Email:</strong> {{ comercio.email }}</p>
                        <p class="text-sm"><strong>Puntaje Medio:</strong> ⭐ {{ comercio.puntaje_medio }}</p>
                        <img v-if="comercio.imagenes" :src="JSON.parse(comercio.imagenes)[0]" alt="Imagen del comercio"
                            class="w-full h-40 object-cover rounded-lg mt-2">
                    </li>
                </ul>
            </div>
        </div>

        <p v-else class="text-gray-500">No hay comercios disponibles.</p>
    </div>
</template>

<script setup>
import { useRouter, useRoute } from 'vue-router';
import { ref, onMounted } from 'vue';

const router = useRouter();
const route = useRoute();
const { $communicationManager } = useNuxtApp();
const comercios = ref([]);

async function getComerciosCategoria() {
    try {
        const categoriaId = route.params.id;
        const response = await $communicationManager.getComerciosDeCategorias(categoriaId);
        console.log("Respuesta del servidor:", response);

        if (Array.isArray(response)) {
            comercios.value = response;
        } else {
            console.error("La respuesta no es un array de comercios");
        }
    } catch (error) {
        console.error("Error obteniendo comercios:", error);
    }
}

function todasLasCategorias() {
    router.push(`/categorias`);
}

onMounted(() => {
    getComerciosCategoria();
});
</script>