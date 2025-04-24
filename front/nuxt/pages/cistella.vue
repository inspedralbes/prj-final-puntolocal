<script setup>
definePageMeta({
    layout: 'footer-only'
});

import { useRuntimeConfig } from "#imports";
const config = useRuntimeConfig();
const baseUrl = config.public.apiBaseUrl;

import { io } from "socket.io-client";
import { computed, onMounted, ref } from 'vue';
import { useAuthStore } from '@/stores/authStore';
import { useComercioStore } from '@/stores/comercioStore';
import { useNuxtApp } from '#app';
import shoppingBasketIcon from '../assets/shopping-basket.svg';
import { Socket } from 'socket.io-client';
import { CistellaCompraRealizadaPopUpComp, CistellaProductoComandaComp } from "#components";
import CistellaBuidaPopUpComp from "~/components/Cistella/CistellaBuidaPopUpComp.vue";

const route = useRoute();
const router = useRouter();
const comercioStore = useComercioStore();
const { $communicationManager } = useNuxtApp();
const socket = io(config.public.baseNodeUrl);

const authStore = useAuthStore();
const errorMessage = ref('');
const formData = reactive({
    email: '',
    password: '',
});

const comercios = ref({});
const groups = reactive([]);
const chooseShipping = ref(false);
const choosed = ref(false);
const payOption = ref(1);
const auth = useAuthStore();
const shipOption = ref(null);
const paymentView = ref(true);
const cistellaView = ref(true);
const isOk = ref(false);
const order_id = ref();
const isLoggued = computed(() => {
    return auth?.user !== null;
});
const loginVisible = ref(false);

// Fetch de los comercios que tienen id en la cesta
onMounted(async () => {
    const uniqueComercioIds = [...new Set(comercioStore.cesta.map(item => item.comercio_id))];
    await Promise.all(uniqueComercioIds.map(async (id) => {
        const comercioData = await $communicationManager.getComercio(id);
        if (comercioData && comercioData.comercio.nombre) {
            comercios.value[id] = comercioData.comercio.nombre;
        }
    }));
});

// Agrupos los productos por el nombre del comercio
const groupedCesta = computed(() => {
    return comercioStore.cesta.reduce((groups, item) => {
        const comercioNombre = comercios.value[item.comercio_id] || 'Cargando...';
        if (!groups[comercioNombre]) {
            groups[comercioNombre] = [];
        }
        groups[comercioNombre].push(item);
        return groups;
    }, {});
});

// Calculate total for a single store
const storeTotal = (storeName) => {
    return groupedCesta.value[storeName].reduce((acc, item) => acc + item.precio * item.cantidad, 0);
};

function toggleCheckout() {
    if (!isLoggued.value) {
        loginVisible.value = !loginVisible.value;
    } else {
        chooseShipping.value = !chooseShipping.value;
        shipOption.value = null;
        choosed.value = false;
    }
}

function chooseShip(event) {
    shipOption.value = event.currentTarget.value;
    choosed.value = shipOption.value !== null;
}

function chooseMethodPayment(option) {
    payOption.value = option;
}

function toPay() {
    chooseShipping.value = false;
    togglePayment();
}

async function crearComanda() {
    try {
        const createdOrder = await $communicationManager.createOrder(orderFiltrada.value);
        if (createdOrder.success) {
            order_id.value = createdOrder.data.order.id;
            const subcomandaInfo = computed(() => {
                return {
                    order_id: order_id.value,
                    suborders: Object.keys(groupedCesta.value).map(comercio => ({
                        comercio_id: groupedCesta.value[comercio][0].comercio_id,
                        subtotal: storeTotal(comercio),
                        productos: groupedCesta.value[comercio].map(({ id, cantidad, precio }) => ({
                            id,
                            cantidad,
                            precio,
                        })),
                    })),
                }
            });
            const createdSuborders = await $communicationManager.createSuborder(subcomandaInfo.value);
            console.log("createdSuborders CREARCOMANDA: ", createdSuborders)

            function agruparOrderSuborders(order, suborders) {
                return {
                    'order_id': order.data.orderCompleta.id,
                    'created_at': order.data.orderCompleta.created_at,
                    'tipo_envio': {
                        'id': order.data.orderCompleta.tipo_envio.id,
                        'nombre': order.data.orderCompleta.tipo_envio.nombre,
                    },
                    'tipo_pago': {
                        'id': order.data.orderCompleta.tipo_pago.id,
                        'nombre': order.data.orderCompleta.tipo_pago.nombre,
                    },
                    'cliente': {
                        'id': order.data.orderCompleta.cliente.id,
                        'nombre': order.data.orderCompleta.cliente.name,
                        'apellidos': order.data.orderCompleta.cliente.apellidos
                    },
                    'subcomandes': suborders.data.subcomandes.map(subcomanda => ({
                        'suborder_id': subcomanda.suborder.id,
                        'comercio_id': subcomanda.suborder.comercio_id,
                        'subtotal': subcomanda.suborder.subtotal,
                        'estat_compra': {
                            'id': subcomanda.suborder.estat_compra.id,
                            'nombre': subcomanda.suborder.estat_compra.nombre
                        }
                    }))
                }
            }

            if (createdOrder && createdSuborders) {
                const orders = agruparOrderSuborders(createdOrder, createdSuborders);
                socket.emit("nuevaOrden", orders);
            }
        } else {
            console.log("ALGUN ERROR CREARCOMANDA: ", createdOrder)
        }

        isOk.value = true;
        comercioStore.emptyBasket();
    } catch (error) {
        console.error("ERROR CREAR COMANDA: ", createdOrder)
    }
}

const orderFiltrada = computed(() => ({
    'total': comercioStore.totalPrice.toFixed(2),
    'tipo_envio': 2,
    'tipo_pago': payOption.value,
}));

const subcomandaInfo = computed(() => {
    return Object.keys(groupedCesta.value).map(comercio => ({
        comercio_id: groupedCesta.value[comercio][0].comercio_id,
        subtotal: storeTotal(comercio),
    }));
});

const seguirComprant = () => {
    router.push('/'); // Ajusta la ruta segons la teva aplicació
};

const togglePayment = () => {
    paymentView.value = !paymentView.value
}

const veureOrdre = () => {
    router.push(`/perfil/compras/${order_id.value}`); // Ajusta la ruta segons la teva aplicació
};

</script>

<template>
    <CistellaHeaderComp text="Cistella" />
    <div v-if="isOk" class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
        <CistellaCompraRealizadaPopUpComp :veureOrdre="veureOrdre" />
    </div>

    <div class="mt-[80px] mb-[80px] w-full">
        <div v-if="Object.keys(groupedCesta).length === 0" class="w-full flex flex-col items-center mt-[180px]">
            <!-- EN CASO DE QUE NO HAYA NADA EN LA CESTA, APARECE PANTALLA DE CISTELLA BUIDA -->
            <CistellaBuidaPopUpComp />
        </div>

        <div v-else>
            <!-- PANTALLA DE ELEGIR TIPO DE ENVÍO  -->
            <div v-if="chooseShipping">
                <div class="bg-gray-900/50 fixed inset-0 z-40 animate-appear" @click="toggleCheckout"></div>
                <div id="chooseShipping" class="fixed bottom-0 z-40 flex flex-col items-center justify-center p-4">
                    <h3 class="text-3xl font-semibold text-center" style="color: #1E2026">
                        Com vols rebre la teva comanda?
                    </h3>
                    <div class="flex w-full justify-between contain-buttons mt-3">
                        <button @click="chooseShip" value="1" disabled
                            class="flex items-center rounded-md px-3 py-4 min-w-[48%] text-lg font-bold disabled:opacity-50 cursor-not-allowed"
                            :class="{ 'selected': shipOption === '1', 'noSelected': shipOption !== '1' }">
                            <svg widths="1.8em" height="1.8em" fill="currentColor" version="1.1" id="Layer_1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 512 512" xml:space="preserve" transform="matrix(-1, 0, 0, 1, 0, 0)">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g>
                                        <g>
                                            <polygon
                                                points="438.32,62.807 438.32,109.573 407.95,109.573 407.95,62.807 343.661,62.807 343.661,192.019 502.609,192.019 502.609,62.807 ">
                                            </polygon>
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path
                                                d="M486.376,345.54c-1.198-1.768-2.476-3.476-3.833-5.119c-2.035-2.464-4.243-4.779-6.605-6.928 c-11.815-10.741-27.501-17.296-44.688-17.296c-8.021,0-15.714,1.427-22.841,4.041c-25.45,9.337-43.657,33.81-43.657,62.456 c0,2.292,0.116,4.556,0.344,6.79c0.682,6.698,2.363,13.106,4.89,19.07c0.421,0.994,0.866,1.976,1.333,2.945 c5.143,10.657,13.046,19.742,22.776,26.321c4.423,2.99,9.223,5.464,14.313,7.33c7.126,2.614,14.819,4.041,22.841,4.041 c26.355,0,49.178-15.411,59.931-37.694c0.468-0.969,0.912-1.951,1.333-2.945c2.527-5.965,4.207-12.372,4.891-19.07 c0.228-2.233,0.344-4.498,0.344-6.79C497.748,368.943,493.553,356.154,486.376,345.54z M431.249,403.056 c-11.228,0-20.361-9.134-20.361-20.361s9.134-20.361,20.361-20.361c11.228,0,20.361,9.134,20.361,20.361 S442.477,403.056,431.249,403.056z">
                                            </path>
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path
                                                d="M446.434,256.367v-33.978H259.901v54.282h-81.64V149.607h37.733v-30.37H107.044L35.24,324.023 C14.29,335.229,0,357.321,0,382.695c0,36.667,29.831,66.498,66.498,66.498s66.498-29.831,66.498-66.498 c0-3.845-0.346-7.608-0.976-11.276h172.497h30.525c5.604-48.119,46.608-85.591,96.207-85.591c23.322,0,44.745,8.286,61.482,22.067 L512,284.451C493.705,269.384,471.147,259.321,446.434,256.367z M66.498,403.056c-11.228,0-20.361-9.134-20.361-20.361 c0-11.228,9.134-20.361,20.361-20.361s20.361,9.134,20.361,20.361C86.86,393.923,77.725,403.056,66.498,403.056z">
                                            </path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            <h3 class="ml-3">Enviament</h3>
                        </button>
                        <button @click="chooseShip" value="2"
                            class="flex items-center rounded-md px-3 py-4 min-w-[48%] text-lg font-bold disabled:opacity-50"
                            :class="{ 'selected': shipOption === '2', 'noSelected': shipOption !== '2' }">
                            <svg width="1.8em" height="1.8em" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M16.5276 2H7.47201C6.26919 2 5.66778 2 5.18448 2.2987C4.70117 2.5974 4.43221 3.13531 3.8943 4.21114L2.49068 7.75929C2.16639 8.57905 1.88266 9.54525 2.42854 10.2375C2.79476 10.7019 3.36244 11 3.99978 11C5.10435 11 5.99978 10.1046 5.99978 9C5.99978 10.1046 6.89522 11 7.99978 11C9.10435 11 9.99978 10.1046 9.99978 9C9.99978 10.1046 10.8952 11 11.9998 11C13.1044 11 13.9998 10.1046 13.9998 9C13.9998 10.1046 14.8952 11 15.9998 11C17.1044 11 17.9998 10.1046 17.9998 9C17.9998 10.1046 18.8952 11 19.9998 11C20.6371 11 21.2048 10.7019 21.5711 10.2375C22.117 9.54525 21.8333 8.57905 21.509 7.75929L20.1054 4.21114C19.5674 3.13531 19.2985 2.5974 18.8152 2.2987C18.3319 2 17.7305 2 16.5276 2Z"
                                        fill="currentColor"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M20 21.25H22C22.4142 21.25 22.75 21.5858 22.75 22C22.75 22.4142 22.4142 22.75 22 22.75H2C1.58579 22.75 1.25 22.4142 1.25 22C1.25 21.5858 1.58579 21.25 2 21.25H4L4 12.5C4.74363 12.5 5.43309 12.2681 6 11.8727C6.56692 12.2681 7.25638 12.5 8 12.5C8.74363 12.5 9.43309 12.2681 10 11.8727C10.5669 12.2681 11.2564 12.5 12 12.5C12.7436 12.5 13.4331 12.2681 14 11.8727C14.5669 12.2681 15.2564 12.5 16 12.5C16.7436 12.5 17.4331 12.2681 18 11.8727C18.5669 12.2681 19.2564 12.5 20 12.5L20 21.25ZM9.5 21.25H14.5V18.5C14.5 17.5654 14.5 17.0981 14.299 16.75C14.1674 16.522 13.978 16.3326 13.75 16.2009C13.4019 16 12.9346 16 12 16C11.0654 16 10.5981 16 10.25 16.2009C10.022 16.3326 9.83261 16.522 9.70096 16.75C9.5 17.0981 9.5 17.5654 9.5 18.5V21.25Z"
                                        fill="currentColor"></path>
                                </g>
                            </svg>
                            <h3 class="ml-3">Recollida</h3>
                        </button>
                    </div>
                    <button :disabled="!choosed" @click="toPay"
                        class="mt-3 w-full h-[60px] justify-center rounded-md border border-transparent px-4 py-2 text-xl font-semibold disabled:cursor-not-allowed"
                        :class="{ 'btn-ok': choosed, 'bg-[#6393F2]': !choosed, 'text-white': !choosed }">
                        <h3>Continuar</h3>
                    </button>
                </div>
            </div>

            <!-- PAYMENT VIEW CON EL SUBTOTAL Y BOTÓN DE PAGAR -->
            <div v-if="paymentView" class="w-full h-screen bg-white fixed inset-0 z-40">

                <!-- HEADER -->
                <CistellaHeaderComp
                    text="Pagament"
                    class="flex items-center justify-center p-4 h-[80px] fixed inset-0 z-50 bg-white"
                />

                <div class="mt-[80px] pb-[88px] p-2 h-screen bg-gray-100 overflow-scroll">
                    <!-- RESUMEN DE LA COMANDA -->
                    <CistellaResumComandaComp :productosComercios="groupedCesta"
                        :totalPrice="comercioStore.totalPrice" />

                    <!-- MÉTODOS DE PAGO (EFECTIVO O TARJETA) -->
                    <CistellaMetodesPagamentComp @chooseMethod="chooseMethodPayment" />
                </div>

                <!-- FOOTER CON LOS BOTONES DE CANCELAR Y PAGAR -->
                <CistellaFooterButtonsComp :togglePayment="togglePayment" :crearComanda="crearComanda" />
            </div>

            <!-- CISTELLA VIEW CON TODOS LOS PRODUCTOS -->
            <div class="divide-y divide-gray-300 pb-2">
                <div v-for="(items, storeName) in groupedCesta" :key="storeName" class="px-3 pt-1">
                    <div class="flex justify-between items-center border-b border-gray-200 m-4">
                        <div class="flex items-center">
                            <svg width="1.3em" height="1.3em" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M7.30681 1.24996C6.50585 1.24969 5.95624 1.24951 5.46776 1.38342C4.44215 1.66458 3.58414 2.36798 3.1073 3.31853C2.88019 3.77127 2.77258 4.31024 2.61576 5.0957L1.99616 8.19383C1.76456 9.35186 2.08191 10.4718 2.74977 11.3115L2.74977 14.0564C2.74975 15.8942 2.74974 17.3498 2.9029 18.489C3.06053 19.6614 3.39265 20.6104 4.14101 21.3587C4.88937 22.1071 5.83832 22.4392 7.01074 22.5969C8.14996 22.75 9.60559 22.75 11.4434 22.75H12.5562C14.3939 22.75 15.8496 22.75 16.9888 22.5969C18.1612 22.4392 19.1102 22.1071 19.8585 21.3587C20.6069 20.6104 20.939 19.6614 21.0966 18.489C21.2498 17.3498 21.2498 15.8942 21.2498 14.0564V11.3115C21.9176 10.4718 22.235 9.35187 22.0034 8.19383L21.3838 5.0957C21.227 4.31024 21.1194 3.77127 20.8923 3.31853C20.4154 2.36798 19.5574 1.66458 18.5318 1.38342C18.0433 1.24951 17.4937 1.24969 16.6927 1.24996H7.30681ZM18.2682 12.75C18.7971 12.75 19.2969 12.6435 19.7498 12.4524V14C19.7498 15.9068 19.7482 17.2615 19.61 18.2891C19.4747 19.2952 19.2211 19.8749 18.7979 20.2981C18.3747 20.7213 17.795 20.975 16.7889 21.1102C16.3434 21.1701 15.8365 21.2044 15.2498 21.2239V18.4678C15.2498 18.028 15.2498 17.6486 15.2216 17.3373C15.1917 17.0082 15.1257 16.6822 14.9483 16.375C14.7508 16.0329 14.4668 15.7489 14.1248 15.5514C13.8176 15.3741 13.4916 15.308 13.1624 15.2782C12.8511 15.25 12.4718 15.25 12.032 15.25H11.9675C11.5278 15.25 11.1484 15.25 10.8371 15.2782C10.5079 15.308 10.182 15.3741 9.87477 15.5514C9.53272 15.7489 9.24869 16.0329 9.05121 16.375C8.87384 16.6822 8.80778 17.0082 8.77795 17.3373C8.74973 17.6486 8.74975 18.028 8.74977 18.4678L8.74977 21.2239C8.16304 21.2044 7.6561 21.1701 7.21062 21.1102C6.20453 20.975 5.62488 20.7213 5.20167 20.2981C4.77846 19.8749 4.52479 19.2952 4.38953 18.2891C4.25136 17.2615 4.24977 15.9068 4.24977 14V12.4523C4.70264 12.6435 5.20244 12.75 5.73132 12.75C7.00523 12.75 8.14422 12.1216 8.83783 11.1458C9.54734 12.1139 10.6929 12.75 11.9996 12.75C13.3063 12.75 14.452 12.1138 15.1615 11.1455C15.8551 12.1215 16.9942 12.75 18.2682 12.75ZM10.2498 21.248C10.6382 21.2499 11.0539 21.25 11.4998 21.25H12.4998C12.9457 21.25 13.3614 21.2499 13.7498 21.248V18.5C13.7498 18.0189 13.749 17.7082 13.7277 17.4727C13.7073 17.2476 13.6729 17.1659 13.6493 17.125C13.5835 17.011 13.4888 16.9163 13.3748 16.8505C13.3339 16.8269 13.2522 16.7925 13.027 16.772C12.7916 16.7507 12.4809 16.75 11.9998 16.75C11.5187 16.75 11.208 16.7507 10.9725 16.772C10.7474 16.7925 10.6656 16.8269 10.6248 16.8505C10.5108 16.9163 10.4161 17.011 10.3502 17.125C10.3267 17.1659 10.2922 17.2476 10.2718 17.4727C10.2505 17.7082 10.2498 18.0189 10.2498 18.5V21.248ZM8.67082 2.74999H7.41748C6.46302 2.74999 6.13246 2.75654 5.86433 2.83005C5.24897 2.99874 4.73416 3.42078 4.44806 3.99112C4.3234 4.23962 4.25214 4.56248 4.06496 5.4984L3.46703 8.48801C3.18126 9.91687 4.27415 11.25 5.73132 11.25C6.91763 11.25 7.91094 10.3511 8.02898 9.17063L8.09757 8.48474L8.10155 8.44273L8.67082 2.74999ZM9.59103 8.62499L10.1785 2.74999H13.8208L14.405 8.59198C14.5473 10.0151 13.4298 11.25 11.9996 11.25C10.5804 11.25 9.46911 10.0341 9.59103 8.62499ZM18.1352 2.83005C17.8671 2.75654 17.5365 2.74999 16.5821 2.74999H15.3285L15.9706 9.17063C16.0886 10.3511 17.0819 11.25 18.2682 11.25C19.7254 11.25 20.8183 9.91687 20.5325 8.48801L19.9346 5.4984C19.7474 4.56248 19.6762 4.23962 19.5515 3.99112C19.2654 3.42078 18.7506 2.99874 18.1352 2.83005Z"
                                        fill="#000000"></path>
                                </g>
                            </svg>
                            <h2 class="text-lg ml-2 truncate">{{ storeName }}</h2>
                        </div>
                        <h3 class="font-semibold text-xl">{{ storeTotal(storeName).toFixed(2) }} €</h3>
                    </div>
                    <div v-for="item in items" :key="item.id" class="m-4 flex">
                        <CistellaProductoComandaComp :producto="item" />
                    </div>
                </div>
            </div>
            <div class="footer flex items-center justify-between mt-auto border-t border-gray-300 mb-[60px]">
                <div id="precio" class="font-semibold text-gray-800">
                    <p class="text-gray-600 font-light text-sm">Precio total:</p>
                    <h3 class="text-2xl">
                        <p>{{ comercioStore.totalPrice.toFixed(2) }} €</p>
                    </h3>
                </div>
                <div id="carrito" class="flex items-center space-x-4">
                    <button id="btn-comprar" class="text-xl font-semibold bg-[#276BF2]" @click="toggleCheckout()">
                        Checkout ({{ comercioStore.totalItems }})
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.3s ease-out;
}

#chooseShipping {
    width: 100%;
    height: max-content;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    background-color: white;
}

.btn-ok {
    background-color: #276BF2;
    color: white;
}

.noSelected {
    background-color: #F2F2F2;
    color: #276BF2;
}

.selected {
    background-color: #276BF2;
    color: white;
}

#btn-quantity {
    width: max-content;
}

img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    object-position: center;
}

header {
    height: 80px;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background-color: white;
}

#btn-comprar {
    border: none;
    display: flex;
    color: white;
    cursor: pointer;
    padding: 10px 20px;
    min-width: 200px;
    border-radius: 5px;
    align-items: center;
    justify-content: center;
}

.footer {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: white;
    max-height: 80px;
    box-sizing: border-box;
    padding: 1rem;
}
</style>
