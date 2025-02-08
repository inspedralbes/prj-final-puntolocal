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
    codigo_postal: null,
    num_planta: null,
    num_puerta: null,
    descripcion: '',
    categoria: null,
    idUser: null,
    gestion_stock: 0,
    latitud: null,  // Se llenará automáticamente
    longitud: null, // Se llenará automáticamente
});

const provincias = ref([
    "Álava", "Albacete", "Alicante", "Almería", "Asturias", "Ávila", "Badajoz",
    "Barcelona", "Burgos", "Cáceres", "Cádiz", "Cantabria", "Castellón", "Ciudad Real",
    "Córdoba", "Cuenca", "Girona", "Granada", "Guadalajara", "Gipuzkoa", "Huelva",
    "Huesca", "Jaén", "La Rioja", "Las Palmas", "León", "Lleida", "Madrid", "Málaga","Ciutadella de Menorca",
    "Murcia", "Navarra", "Ourense", "Palencia", "Pontevedra", "Salamanca", "Santa Cruz de Tenerife",
    "Segovia", "Sevilla", "Soria", "Tarragona", "Teruel", "Toledo", "Valencia", "Valladolid",
    "Vizcaya", "Zamora", "Zaragoza"
]);

const categorias = ref('');

// Obtener categorías
async function getCategoriasGenerales() {
    const { $communicationManager } = useNuxtApp();
    categorias.value = await $communicationManager.getCategorias();
}

// Obtener coordenadas de la API de OpenStreetMap
async function getCoordinates() {
    const address = `${formData.street_address}, ${formData.ciudad}, ${formData.provincia}, ${formData.codigo_postal}, España`;
    const url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(address)}&format=json&limit=1`;

    try {
        const response = await fetch(url);
        const data = await response.json();
        
        if (data.length > 0) {
            formData.latitud = data[0].lat;
            formData.longitud = data[0].lon;
            console.log(`Coordenadas obtenidas: Latitud ${formData.latitud}, Longitud ${formData.longitud}`);
            return true;
        } else {
            console.error("No se encontraron coordenadas para la dirección ingresada.");
            return false;
        }
    } catch (error) {
        console.error("Error al obtener las coordenadas:", error);
        return false;
    }
}

// Registrar usuario
async function register() {
    const { $communicationManager } = useNuxtApp();

    // Verificar campos obligatorios, exceptuando latitud y longitud
    for (const key in formData) {
        if (
            key !== "latitud" &&
            key !== "longitud" &&
            (formData[key] === null || formData[key] === undefined || formData[key] === '')
        ) {
            console.error(`És necessari completar el camp: ${key}`);
            return;
        }
    }

    // Obtener coordenadas antes de continuar con el registro
    const coordenadasObtenidas = await getCoordinates();
    if (!coordenadasObtenidas) {
        console.error("No se puede proceder sin coordenadas.");
        return;
    }

    // Convertir valores a enteros
    formData.codigo_postal = parseInt(formData.codigo_postal) || null;
    formData.num_planta = parseInt(formData.num_planta) || null;
    formData.num_puerta = parseInt(formData.num_puerta) || null;

    // Llamar a la API para registrar
    const response = await $communicationManager.registerStore(formData);

    if (response) {
        console.log(`S'ha registrat correctament`);
        navigateTo('/perfil');
    } else {
        console.log('Hi ha hagut algun error, comprovi les seves dades');
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
                                        required="" place
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
                                        type="text" data-testid="street_address" required="" placeholder="Pau Claris 12"
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
                                    <select id="provincia" v-model="formData.provincia" required=""
                                        class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                        <option value="" disabled selected>Selecciona una província</option>
                                        <option v-for="provincia in provincias" :key="provincia" :value="provincia">
                                            {{ provincia }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="codigo_postal" class="block text-sm font-medium text-gray-700">Codi
                                    Postal</label>
                                <div class="mt-1">
                                    <input id="codigo_postal" name="codigo_postal" v-model="formData.codigo_postal"
                                        type="text" data-testid="codigo_postal" required="" placeholder="83649"
                                        class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            <div>
                                <label for="numero_planta" class="block text-sm font-medium text-gray-700">Número
                                    Planta</label>
                                <div class="mt-1">
                                    <input id="numero_planta" name="numero_planta" v-model="formData.num_planta"
                                        type="text" data-testid="numero_planta" required=""
                                        class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            <div>
                                <label for="numero_puerta" class="block text-sm font-medium text-gray-700">Número
                                    Porta</label>
                                <div class="mt-1">
                                    <input id="numero_puerta" name="numero_puerta" v-model="formData.num_puerta"
                                        type="text" data-testid="numero_puerta" required=""
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
                            <p class="text-blue-600">
                                Ver en donde se ha marcado mi tienda
                            </p>
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