<template>
    <main>
        <div
            class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full mb-1 mt-16">
                <div class="mb-4">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Comandes</h1>
                </div>
                <!-- Barra de búsqueda + botones -->
                <div
                    class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                    <div class="flex items-center mb-4 sm:mb-0">
                        <form class="sm:pr-3" action="#" method="GET">
                            <label for="products-search" class="sr-only">Buscar</label>
                            <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                                <input type="text" name="email" id="products-search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Buscar comandes...">
                            </div>
                        </form>
                        <div class="flex items-center w-full sm:justify-end">
                            <div class="flex pl-2 space-x-1">
                                <a href="#"
                                    class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                                <a href="#"
                                    class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                                <a href="#"
                                    class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                                <a href="#"
                                    class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        ID
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        ID GENERAL
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        CLIENTE
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        FECHA
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        TIPO
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        TOTAL
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        ESTAT
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        ACCIONS
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                <tr v-for="order in orders" class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        #{{ order.id }}</td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        #{{ order.order_id }}</td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ order.order.cliente.name }} {{ formatApellido(order.order.cliente.apellidos)
                                        }}</td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ formatFecha(order.created_at) }}</td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ order.order.tipo_envio.nombre }}</td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ order.subtotal }}</td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                        <!-- {{ order.estat_compra.nombre }} -->
                                        <select id="estat" v-model="order.estat_compra.id"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                            <option v-for="estat in estats" :key="estat.id" :value="estat.id"
                                                data-v-inspector="pages/admin/productes.vue:358:29">
                                                {{ estat.nombre }}
                                            </option>
                                        </select>

                                    </td>

                                    <td class="p-4 space-x-2 whitespace-nowrap flex">
                                        <NuxtLink v-if="order?.order?.id" :to="`/admin/comandes/${order.order.id}`"
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
                                        <button type="button" id="updateOrderEstat" :disabled="isDisabled(order.id)"
                                            @click="guardarEstat(order.id)"
                                            class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50 disabled:cursor-not-allowed">
                                            <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M18.1716 1C18.702 1 19.2107 1.21071 19.5858 1.58579L22.4142 4.41421C22.7893 4.78929 23 5.29799 23 5.82843V20C23 21.6569 21.6569 23 20 23H4C2.34315 23 1 21.6569 1 20V4C1 2.34315 2.34315 1 4 1H18.1716ZM4 3C3.44772 3 3 3.44772 3 4V20C3 20.5523 3.44772 21 4 21L5 21L5 15C5 13.3431 6.34315 12 8 12L16 12C17.6569 12 19 13.3431 19 15V21H20C20.5523 21 21 20.5523 21 20V6.82843C21 6.29799 20.7893 5.78929 20.4142 5.41421L18.5858 3.58579C18.2107 3.21071 17.702 3 17.1716 3H17V5C17 6.65685 15.6569 8 14 8H10C8.34315 8 7 6.65685 7 5V3H4ZM17 21V15C17 14.4477 16.5523 14 16 14L8 14C7.44772 14 7 14.4477 7 15L7 21L17 21ZM9 3H15V5C15 5.55228 14.5523 6 14 6H10C9.44772 6 9 5.55228 9 5V3Z"
                                                        fill="#ffffff"></path>
                                                </g>
                                            </svg>
                                            Guardar
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div v-if="backgroundShadow" class="bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40"></div>
        <div v-if="isOpen['info']"
            class="fixed left-0 right-0 z-50 items-center justify-center overflow-x-hidden overflow-y-auto top-4 md:inset-0 h-modal sm:h-full flex"
            id="edit-user-modal" aria-modal="true" role="dialog">
            <div class="relative w-full h-full max-w-2xl px-4 md:h-auto">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                    <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
                        <h3 class="text-xl font-bold dark:text-white">
                            #{{ actualOrder.order_id }} Informació comanda
                        </h3>
                        <button type="button" @click="toggleCard('info')"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white"
                            data-modal-toggle="edit-user-modal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>

                    <div v-if="actualOrder && actualOrder.order" class="contain-data">
                        <h3 class="text-xl font-semibold dark:text-white mb-2">Productes</h3>
                        <div class="contain-products divide-y divide-gray-200 dark:divide-gray-600">
                            <div class="producto" v-for="productoOrder in actualOrder.productos_compra">
                                <div class="flex">
                                    <div class="contain-image rounded-md">
                                        <img class="image object-cover w-full h-full"
                                            src="https://cdn-images.farfetch-contents.com/22/90/42/91/22904291_52923841_600.jpg"
                                            alt="image">
                                    </div>
                                    <div class="contain-text">
                                        <h3 class="font-medium text-gray-900 dark:text-white">{{
                                            productoOrder.producto.nombre }} <span
                                                class="font-large font-bold text-md text-gray-200 ml-1">x {{
                                                productoOrder.cantidad }} UDS</span></h3>
                                        <h4 class="font-small text-gray-900 dark:text-white">Opciones de producto</h4>
                                    </div>
                                </div>
                                <div>
                                    <h2 class="text-base font-medium text-gray-900 dark:text-white"> {{
                                        (productoOrder.precio * productoOrder.cantidad).toFixed(2) }} €</h2>
                                </div>
                            </div>
                        </div>
                        <div class="contain-products flex justify-end">
                            <h3 class="px-3 py-1">
                                <span class="text-l font-semibold dark:text-white mt-3 mb-2">
                                    Subtotal:
                                </span>
                                <span class="text-xl font-bold dark:text-white mt-3 mb-2">
                                    {{ subtotal }} €
                                </span>
                            </h3>
                        </div>
                        <h3 class="text-xl font-semibold dark:text-white mt-3 mb-2">Informació de comanda</h3>
                        <div>
                            <h3>
                                <span class="font-medium text-gray-900 dark:text-white">
                                    Cliente:
                                </span>
                                <span class="font-small text-gray-900 dark:text-white">
                                    {{ actualOrder.order.cliente.name }} {{
                                        formatApellido(actualOrder.order.cliente.apellidos) }}
                                </span>
                            </h3>
                            <h3>
                                <span class="font-medium text-gray-900 dark:text-white">
                                    Fecha y hora:
                                </span>
                                <span class="font-small text-gray-900 dark:text-white">
                                    {{ formatFecha(actualOrder.created_at) }}
                                </span>
                            </h3>
                            <h3>
                                <span class="font-medium text-gray-900 dark:text-white">
                                    Tipo:
                                </span>
                                <span class="font-small text-gray-900 dark:text-white">
                                    {{ actualOrder.order.tipo_envio.nombre }}
                                </span>
                            </h3>
                            <span v-if="actualOrder.order.tipo === 2">
                                <h3>
                                    <span class="font-medium text-gray-900 dark:text-white">
                                        Dirección de entrega:
                                    </span>
                                    <span class="font-small text-gray-900 dark:text-white">
                                        {{ actualOrder.order.cliente.street_address }}, {{
                                        actualOrder.order.cliente.numero_planta }}º {{
                                        actualOrder.order.cliente.numero_puerta }}
                                    </span>
                                </h3>
                                <h3>
                                    <span class="font-medium text-gray-900 dark:text-white">
                                        Comentario:
                                    </span>
                                    <span class="font-small text-gray-900 dark:text-white">
                                        Comentario de prueba
                                    </span>
                                </h3>
                            </span>
                        </div>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="overflow-x-auto max-h-[400px]">
                            <div class="space-y-4">
                                <div
                                    class="flex items-center p-4 bg-white rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 transition-colors">
                                    <div class="h-16 w-16 flex-shrink-0">
                                        <img class="h-full w-full object-cover rounded"
                                            alt="Product image">
                                    </div>

                                    <div class="ml-4 flex-1">
                                        <h3 class="font-medium text-gray-900 dark:text-white">
                                            product.name
                                            <span class="text-sm text-gray-500 ml-1">
                                                x product.quantity unidades
                                            </span>
                                        </h3>
                                    </div>

                                    <div class="ml-4">
                                        <span class="text-base font-medium text-gray-900 dark:text-white">
                                             product.price.toFixed(2) €
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="width: 100px;">
                            <div>
                                <label for="nom-producte"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom del
                                    producte</label>
                                <input type="text" name="nom-producte" id="nom-producte"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    v-model="actualOrder.id" placeholder="Samarreta blanca" required>
                            </div>
                        </div>

                        <div style="width: 100px;"
                            class="items-center pt-5 border-t border-gray-200 rounded-b dark:border-gray-700">
                            <button
                                class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded">
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div> -->
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

definePageMeta({
    layout: 'admin',
});

const backgroundShadow = ref(false);

const isOpen = reactive({
    'info': false,
});

function toggleCard(menu) {
    isOpen[menu] = !isOpen[menu];
    backgroundShadow.value = !backgroundShadow.value
}

const orders = reactive([]);
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

// async function showOrder(id) {
//     toggleCard('info');
//     const data = await $communicationManager.infoOrder(id);
//     Object.assign(actualOrder, data.data);
//     console.log(actualOrder);
// }

function isDisabled(id) {
    const order = orders.find(order => order.id === id);
    if(estatsOriginals[id] !== order.estat_compra.id){
        return false;
    }
    return true;
}

async function guardarEstat(id) {
    const order = orders.find(order => order.id === id);
    order.estat = order.estat_compra.id;
    estatsOriginals[order.id] = order.estat;
    console.log(order);
    const data = await $communicationManager.updateOrder(order);
    console.log(data);
    
}

onMounted(async () => {
    document.addEventListener('keydown', closeAll);
    const data = await $communicationManager.getEstats();
    estats.push(...data.data);
    // console.log(estats);

})

onBeforeMount(async () => {
    const data = await $communicationManager.getOrders();
    orders.push(...data.data);
    orders.forEach(order => {
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
</script>