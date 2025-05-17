<script setup>
definePageMeta({
    layout: 'footer-only'
});

import { useRuntimeConfig } from "#imports";
const config = useRuntimeConfig();

import { io } from "socket.io-client";
import { computed, onMounted, ref } from 'vue';
import { useAuthStore } from '@/stores/authStore';
import { useComercioStore } from '@/stores/comercioStore';
import { useNuxtApp } from '#app';
import { CistellaCompraRealizadaPopUpComp, CistellaProductoComandaComp } from "#components";
import CistellaBuidaPopUpComp from "~/components/Cistella/CistellaBuidaPopUpComp.vue";

const router = useRouter();
const comercioStore = useComercioStore();
const dataLoaded = ref(false);
const { $communicationManager } = useNuxtApp();
const socket = io(config.public.baseNodeUrl);

const authStore = useAuthStore();
const errorMessage = ref('');
const formData = reactive({
    email: '',
    password: '',
});

const comercios = ref({});
const choosed = ref(false);
const payOption = ref("1");
const paymentCardID = ref(null);
const auth = useAuthStore();
const groups = reactive([]);
const storesClosed = ref([]);
const comerciosInfo = ref([]);
const paymentView = ref(false);
const cistellaView = ref(true);
const isOk = ref(false);
const order_id = ref();
const chooseShipping = ref(false);
const isLogged = computed(() => {
    return auth?.user !== null;
});
const loginVisible = ref(false);

const goBack = () => {
    router.back();
};

function proximaApertura(horarios) {
    const daysOfWeek = ['diumenge', 'dilluns', 'dimarts', 'dimecres', 'dijous', 'divendres', 'dissabte'];
    const now = new Date();
    const todayIndex = now.getDay();
    const format = (n) => n.toString().padStart(2, '0')
    const nowTime = `${format(now.getHours())}:${format(now.getMinutes())}`;

    for (let index = 0; index < daysOfWeek.length; index++) {
        const dayIndex = (now.getDay() + index) % 7;
        const dayName = daysOfWeek[dayIndex];
        const horario = horarios[dayName];

        if (horario !== 'Cerrado') {
            const [inicio, fin] = horario.split(' - ');

            if (index === 0) {
                if (nowTime < inicio) return `Obre a les ${inicio}`
            } else {
                const tomorrow = index === 1;
                return `Obre ${tomorrow ? 'demà' : 'el ' + dayName} a les ${inicio}`;
            }
        }
    }
    return null;
}

function checkClosedStores() {
    let arrayClosed = [];
    for (const data of comerciosInfo.value) {
        const horarios = JSON.parse(data.comercio.horario);
        if (!data.isOpen) {
            arrayClosed.push({
                comercio_id: data.comercio.id,
                comercio_nombre: data.comercio.nombre,
                comercio_proximo_horario: proximaApertura(horarios),
                isOpen: data.isOpen
            });
        }
    }
    return arrayClosed;
}

onMounted(async () => {
    try {
        const uniqueComercioIds = [...new Set(comercioStore.cesta.map(item => item.comercio_id))];
        await Promise.all(uniqueComercioIds.map(async (id) => {
            const comercioData = await $communicationManager.getComercio(id);
            if (comercioData && comercioData.comercio.nombre) {
                comercios.value[id] = comercioData.comercio.nombre;
                comerciosInfo.value.push(comercioData);
            }
        }));
        storesClosed.value = checkClosedStores();
        console.log("Comercios cerrados:", storesClosed.value);
        dataLoaded.value = true;
    } catch (error) {
        console.error("Error loading basket data:", error);
    }
});

const closedStoresComputed = computed(() => {
    return checkClosedStores();
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

const storeTotal = (storeName) => {
    return groupedCesta.value[storeName].reduce((acc, item) => acc + item.precio * item.cantidad, 0);
};

function toggleCheckout() {
    if (!isLogged.value) {
        loginVisible.value = !loginVisible.value;
    } else {
        console.log("Cerrados: ",storesClosed.value)
        if (storesClosed.value.length > 0) {
            chooseShipping.value = true;
            paymentView.value = false;
        }else{
            paymentView.value = true;
        }
    }
}

function chooseMethodPayment(option) {
    payOption.value = option;
}

function choosePaymentCard(card) {
    paymentCardID.value = card.defaultPaymentMethod.id;
}

function toPay() {
    chooseShipping.value = false;
    togglePayment();
}

async function crearComanda() {
    try {
        const payment_method = orderFiltrada.value.tipo_pago;
        console.log("Tipo de pago: ", payment_method);
        // const total_amount = Math.round(orderFiltrada.value.total * 100);
        console.log('orderFiltrada: ', orderFiltrada.value);
        const total_amount = orderFiltrada.value.total;
        console.log("Payment card: ", paymentCardID?.value);


        // Creamos la orden, da igual si es en efectivo o tarjeta
        const createdOrder = await $communicationManager.createOrder(orderFiltrada.value);
        if (createdOrder.success) {
            order_id.value = createdOrder.data.order.id;
            const subcomandaInfo = computed(() => {
                return {
                    order_id: order_id.value,
                    payment_method_id: payOption.value,
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
            console.log("Subcomandas: ", subcomandaInfo.value);

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
        }

        isOk.value = true;
        comercioStore.emptyBasket();
    } catch (error) {
        console.error("ERROR CREAR COMANDA: ", createdOrder)
    }
}

const orderFiltrada = computed(() => ({
    'total': comercioStore.totalPrice.toFixed(2),
    'tipo_envio': 1,
    'tipo_pago': payOption.value,
    'payment_method_id': paymentCardID.value
}));

const subcomandaInfo = computed(() => {
    return Object.keys(groupedCesta.value).map(comercio => ({
        comercio_id: groupedCesta.value[comercio][0].comercio_id,
        subtotal: storeTotal(comercio),
    }));
});

const togglePayment = () => {
    paymentView.value = !paymentView.value
}
const seguirComprant = () => {
    router.push('/');
};

const veureOrdre = () => {
    router.push(`/perfil/compras/${order_id.value}`);
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
                    <h3 v-if="storesClosed.length > 0" class="text-3xl font-semibold text-center">
                        Hi han comerços tancats
                    </h3>

                    <div v-if="storesClosed.length > 0" class="closed-stores-warning">
                        <div v-for="store in storesClosed" :key="store.comercio_id">
                            {{ store.comercio_nombre }} - {{ store.comercio_proximo_horario }}
                        </div>
                    </div>

                    <button @click="toPay"
                        class="mt-3 w-full h-[60px] justify-center text-white rounded-md border border-transparent px-4 py-2 text-xl font-semibold bg-[#276BF2]">
                        <p v-if="storesClosed.length > 0">Continuar igualment</p>
                    </button>
                </div>
            </div>

            <!-- PAYMENT VIEW CON EL SUBTOTAL Y BOTÓN DE PAGAR -->
            <div v-if="paymentView" class="w-full h-screen bg-white fixed inset-0 z-40">

                <!-- HEADER -->
                <CistellaHeaderComp text="Pagament"
                    class="flex items-center justify-center p-4 h-[80px] fixed inset-0 z-50 bg-white" />

                <div class="mt-[80px] pb-[88px] p-2 h-screen bg-gray-100 overflow-scroll">
                    <!-- RESUMEN DE LA COMANDA -->
                    <CistellaResumComandaComp :productosComercios="groupedCesta"
                        :totalPrice="comercioStore.totalPrice" />

                    <!-- MÉTODOS DE PAGO (EFECTIVO O TARJETA) -->
                    <CistellaMetodesPagamentComp @chooseMethod="chooseMethodPayment"
                        @choosePaymentCard="choosePaymentCard" />
                </div>

                <!-- FOOTER CON LOS BOTONES DE CANCELAR Y PAGAR -->
                <CistellaFooterButtonsComp :togglePayment="togglePayment" :crearComanda="crearComanda"
                    :paymentCardID="paymentCardID" :payOption="payOption" />
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
                    <p class="text-gray-600 font-light text-sm">Preu total:</p>
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
