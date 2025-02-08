<script setup>
    import { useNuxtApp, navigateTo } from '#app';
    import { useAuthStore } from '@/stores/authStore';

    definePageMeta({
        layout: 'authentication',
    });

    const authStore = useAuthStore();

    const formData = reactive({
        nombre: '',
        email: '',
        phone: '',
        street_address: '',
        ciudad: '',
        provincia: '',
        codigo_postal: '',
        num_planta: null,
        num_puerta: null,
        descripcion: '',
        categoria: null,
        idUser: null,
        gestion_stock: 0,
    });

    const categorias = ref('')

    async function getCategoriasGenerales() {
        const { $communicationManager } = useNuxtApp();
        categorias.value = await $communicationManager.getCategorias();
    }

    async function register() {
        const { $communicationManager } = useNuxtApp();

        formData.codigo_postal = parseInt(formData.codigo_postal) || null;
        formData.num_planta = parseInt(formData.num_planta) || null;
        formData.num_puerta = parseInt(formData.num_puerta) || null;
        formData.categoria = parseInt(formData.categoria) || null;
        formData.gestion_stock = parseInt(formData.gestion_stock);
        
        if (!formData.idUser) {
            console.error("Error: idUser no está definido.");
            return;
        }

        for (const key in formData) {
            if (formData[key] === null || formData[key] === undefined || formData[key] === '') {
                console.error(`És necessari completar el camp: ${key}`);
                return;
            }
        }

        const response = await $communicationManager.registerStore(formData);

        if (response) {
            navigateTo('/perfil');
        }
    }


    onMounted(() => {
        getCategoriasGenerales();
        formData.idUser = authStore.user.id;
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
            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md md:max-w-lg">
                <div class="bg-white mx-5 px-4 pb-4 pt-8 sm:rounded-lg sm:px-10 md:px-12 sm:pb-6 sm:shadow rounded-md">
                    <form @submit.prevent="register" class="space-y-6">
                        <div class="grid grid-cols-2 gapQueFunciona">
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                                <div class="mt-1">
                                    <input id="nom" name="nom" v-model="formData.nombre" type="text" data-testid="nom"
                                        required=""
                                        class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Correu
                                    electrònic</label>
                                <div class="mt-1">
                                    <input id="email" v-model="formData.email" type="text" data-testid="email"
                                        required=""
                                        class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Telèfon</label>
                                <div class="mt-1">
                                    <input id="phone" v-model="formData.phone" type="text" data-testid="phone"
                                        required=""
                                        class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            <div>
                                <label for="street_address"
                                    class="block text-sm font-medium text-gray-700">Adreça</label>
                                <div class="mt-1">
                                    <input id="street_address" name="street_address" v-model="formData.street_address"
                                        type="text" data-testid="street_address" required=""
                                        class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            <div>
                                <label for="ciudad" class="block text-sm font-medium text-gray-700">Ciutat</label>
                                <div class="mt-1">
                                    <input id="ciudad" name="ciudad" v-model="formData.ciudad" type="text"
                                        data-testid="ciudad" required=""
                                        class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            <div>
                                <label for="provincia" class="block text-sm font-medium text-gray-700">Província</label>
                                <div class="mt-1">
                                    <input id="provincia" name="provincia" v-model="formData.provincia" type="text"
                                        data-testid="provincia" required=""
                                        class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            <div>
                                <label for="codigo_postal" class="block text-sm font-medium text-gray-700">Codi
                                    Postal</label>
                                <div class="mt-1">
                                    <input id="codigo_postal" name="codigo_postal" v-model="formData.codigo_postal"
                                        type="text" data-testid="codigo_postal" required=""
                                        class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            <div>
                                <label for="numero_planta" class="block text-sm font-medium text-gray-700">Número
                                    Planta</label>
                                <div class="mt-1">
                                    <input id="numero_planta" name="numero_planta" v-model="formData.num_planta"
                                        type="number" data-testid="numero_planta" required=""
                                        class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            <div>
                                <label for="numero_puerta" class="block text-sm font-medium text-gray-700">Número
                                    Porta</label>
                                <div class="mt-1">
                                    <input id="numero_puerta" name="numero_puerta" v-model="formData.num_puerta"
                                        type="number" data-testid="numero_puerta" required=""
                                        class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            <div>
                                <label for="gestion_stock" class="block text-sm font-medium text-gray-700">Gestionar
                                    Stock</label>
                                <div class="mt-1">
                                    <select id="gestion_stock" v-model="formData.gestion_stock"
                                        data-testid="gestion_stock" required=""
                                        class="block w-full bg-white appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                        <option value="0">No</option>
                                        <option value="1">Sí</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <label for="categoria" class="block text-sm font-medium text-gray-700">Categoria</label>
                            <div class="mt-1">
                                <select id="categoria" v-model="formData.categoria" data-testid="categoria" required=""
                                    class="block w-full bg-white appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                    <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
                                        {{ categoria.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripció</label>
                            <div class="mt-1">
                                <textarea id="descripcion" name="descripcion" v-model="formData.descripcion" rows="3"
                                    data-testid="descripcion" required=""
                                    class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"></textarea>
                            </div>
                        </div>
                        <div>
                            <ButtonComp test-id="register" @submit.prevent="register">
                                Registrar-se
                            </ButtonComp>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .gapQueFunciona {
        gap: 1rem;
    }
</style>