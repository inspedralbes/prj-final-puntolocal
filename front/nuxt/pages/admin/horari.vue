<template>
    <div class="mt-4 md:mt-16">
        <div class="my-20 mx-10 md:my-40 md:mx-40 border-2 p-6 rounded-lg shadow-lg">
            <h1 class="text-xl font-bold mb-4">Gestió d'Horaris</h1>
            <form @submit.prevent="saveSchedule" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 gap-6">
                    <div v-for="day in days" :key="day" class="flex flex-col">
                        <label class="font-medium">{{ day.charAt(0).toUpperCase() + day.slice(1) }}</label>
                        <input 
                            v-model="horario[day]" 
                            placeholder="Ej: 08:00 - 21:00" 
                            class="border p-2 rounded w-full"
                        />
                    </div>
                </div>
                <div class="flex justify-center mt-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
definePageMeta({
    layout: 'admin',
});

import { reactive } from 'vue';
import { useNuxtApp } from '#app';
import { useAuthStore } from '@/stores/authStore';
import { useToast } from '@/composables/useToast.js';

const { toast } = useToast()
const authStore = useAuthStore();
const days = ['dilluns', 'dimarts', 'dimecres', 'dijous', 'divendres', 'dissabte', 'diumenge'];
const horario = reactive({
    dilluns: '',
    dimarts: '',
    dimecres: '',
    dijous: '',
    divendres: '',
    dissabte: '',
    diumenge: ''
});

const { $communicationManager } = useNuxtApp();

async function saveSchedule() {
    try {
        const response = await $communicationManager.updateHorario(
            { horario }, 
            authStore.comercio.id
        );
        if(response){
            toast("Horari guardat exitosament", "success");
        }else{
            toast("Error al guardar", "error");
        }
    } catch (e) {
        console.error(e);
        alert('Error al guardar el horario');
    }
}
</script>