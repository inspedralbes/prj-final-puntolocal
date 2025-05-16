<template>
    <main>
        <div
            class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
            <div class="w-full mb-1 mt-16">
                <div class="mb-4">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl">Historial de comandes</h1>
                </div>
                <!-- Barra de búsqueda + botones -->
                <div
                    class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100">
                    <div class="flex items-center mb-4 sm:mb-0">
                        <form class="sm:pr-3" action="#" method="GET">
                            <label for="products-search" class="sr-only">Buscar</label>
                            <div class="flex items-center relative w-48 mt-1 sm:w-64 xl:w-96">
                                <div
                                    class="relative w-full flex items-center shadow-sm rounded-lg overflow-hidden border border-gray-200 focus-within:ring-2 focus-within:ring-blue-400 focus-within:border-blue-400 transition duration-150">
                                    <!-- Icono de búsqueda -->
                                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <!-- Input -->
                                    <input v-model="searchTerm" type="text" name="search" id="order-search"
                                        class="w-full py-3 pl-10 pr-10 text-gray-700 bg-white focus:outline-none placeholder-gray-400"
                                        placeholder="Buscar comandes...">
                                    <!-- Botón de limpiar -->
                                    <button v-if="searchTerm" @click="clearSearch"
                                        class="absolute right-0 h-full px-3 flex items-center justify-center text-red-500 hover:text-red-700 focus:outline-none transition duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="flex items-center w-full sm:justify-end">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase">
                                        ID
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase">
                                        CLIENT
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase">
                                        DATA
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase">
                                        TIPUS
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase">
                                        TOTAL
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase">
                                        ESTAT
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase">
                                        ACCIONS
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 ">
                                <tr v-for="order in filteredOrders" class="hover:bg-gray-100"
                                :class="{ 'bg-green-100': order.estat_compra.id === 4, 'bg-red-100': order.estat_compra.id === 5, 'hover:bg-green-200': order.estat_compra.id === 4, 'hover:bg-red-200': order.estat_compra.id === 5 }">
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap">
                                        #{{ order.id }}</td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap">
                                        {{ order.order.cliente.name }} {{ formatApellido(order.order.cliente.apellidos)
                                        }}</td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap">
                                        {{ formatFecha(order.created_at) }}</td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap">
                                        {{ order.order.tipo_envio.nombre }}</td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap">
                                        {{ order.subtotal }}</td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap">
                                        <div class="p-2 rounded-md">
                                            {{ order.estat_compra.nombre }}
                                        </div>
                                    </td>

                                    <td class="p-4 space-x-2 whitespace-nowrap flex">
                                        <NuxtLink v-if="order?.id" :to="`/admin/comandes/${order.id}`"
                                            id="viewOrder"
                                            class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <g clip-path="url(#clip0_429_11160)">
                                                        <circle cx="12" cy="11.9999" r="9" stroke="#ffffff"
                                                            stroke-width="2.5" stroke-linecap="round"
                                                            stroke-linejoin="round"></circle>
                                                        <rect x="12" y="8" width="0.01" height="0.01" stroke="#ffffff"
                                                            stroke-width="3.75" stroke-linejoin="round"></rect>
                                                        <path d="M12 12V16" stroke="#ffffff" stroke-width="2.5"
                                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_429_11160">
                                                            <rect width="24" height="24" fill="white"></rect>
                                                        </clipPath>
                                                    </defs>
                                                </g>
                                            </svg>
                                            Veure comanda
                                        </NuxtLink>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<style scoped>
.contain-data {
    background-color: rgb(31 41 55 / var(--tw-bg-opacity, 1));
    width: 100%;
    height: 80vh;
    display: flex;
    flex-direction: column;
    padding: 1.5rem;
    overflow-y: auto;
}

.contain-products {
    --tw-bg-opacity: 1;
    border: 1px solid #54585e;
    width: 100%;
    max-height: 50%;
    overflow-y: auto;
}

.producto {
    display: flex;
    background-color: rgb(55 65 81 / var(--tw-bg-opacity, 1));
    padding: 0.85rem;
    /* align-items: center; */
    justify-content: space-between;
}

.contain-text {
    margin-left: 1rem;
}

.contain-image {
    width: 80px;
    height: 80px;
    overflow: hidden;
}
</style>

<script setup>
const { $communicationManager } = useNuxtApp();
import socket from '~/socket';
const auth = useAuthStore();
const searchTerm = ref('');

definePageMeta({
    layout: 'admin',
});

const backgroundShadow = ref(false);

if (socket.connected) {
    // console.log("Socket está conectado correctamente.");
    socket.emit("identificarUsuario", { user_id: auth.user.id });
}

const isOpen = reactive({
    'info': false,
});

function toggleCard(menu) {
    isOpen[menu] = !isOpen[menu];
    backgroundShadow.value = !backgroundShadow.value
}

const orders = ref([]);
const actualOrder = reactive({});
const estats = reactive([]);
const estatsOriginals = reactive([])

const subtotal = computed(() => {
    if (!actualOrder.productos_compra) {
        return 0;
    }
    return actualOrder.productos_compra.reduce((total, productoInfo) => {
        return total + productoInfo.cantidad * productoInfo.precio;
    }, 0);
});

const formatFecha = (fecha) => {
    if (!fecha) return ""; // Manejar el caso de fecha nula o indefinida
    const date = new Date(fecha);

    const dia = String(date.getDate()).padStart(2, "0");
    const mes = String(date.getMonth() + 1).padStart(2, "0"); // Los meses empiezan en 0
    const año = date.getFullYear();

    const horas = String(date.getHours()).padStart(2, "0");
    const minutos = String(date.getMinutes()).padStart(2, "0");

    return `${dia}/${mes}/${año} ${horas}:${minutos}`;
};

const formatApellido = (apellidos) => {
    if (!apellidos) return ""; // Maneja casos donde no hay apellidos
    return `${apellidos[0].toUpperCase()}.`; // Toma la primera letra y agrega un punto
};

function isDisabled(id) {
    const order = orders.value.find(order => order.id === id);
    if (estatsOriginals[id] !== order.estat_compra.id) {
        return false;
    }
    return true;
}

async function guardarEstat(id) {
    const order = orders.value.find(order => order.id === id);
    order.estat = order.estat_compra.id;
    estatsOriginals[order.id] = order.estat;
    const data = await $communicationManager.updateOrder(order);
}

onMounted(async () => {
    document.addEventListener('keydown', closeAll);
    const data = await $communicationManager.getEstats();
    estats.push(...data.data);
    // console.log(estats);
    socket.on("nuevaOrdenRecibida", (newSuborder) => {
        // console.log("entra en nuevaOrdenRecibida");
        orders.value.push(newSuborder);
        estatsOriginals[newSuborder.id] = newSuborder.estat_compra.id;
    });
})

onBeforeMount(async () => {
    const data = await $communicationManager.getHistorialOrders();
    // console.log(data.data);
    orders.value.push(...data.data);
    orders.value.forEach(order => {
        estatsOriginals[order.id] = order.estat;
    });
    // console.log(orders);
})

const closeAll = (e) => {
    if (e.key === "Escape") {
        isOpen['info'] = false;
        backgroundShadow.value = false;
    }
};

const clearSearch = () => {
    searchTerm.value = '';
};

function removeAccents(str) {
    return str.normalize("NFD").replace(/[\u0300-\u036f]/g, '');
}

const filteredOrders = computed(() => {
    if (!searchTerm.value) return orders.value;
    const st = removeAccents(searchTerm.value.toLowerCase());
    return orders.value.filter(order => {
        const id = String(order.id).toLowerCase();
        const clienteName = removeAccents(order.order?.cliente?.name?.toLowerCase() || '');
        return id.includes(st) || clienteName.includes(st);
    });
});
</script>