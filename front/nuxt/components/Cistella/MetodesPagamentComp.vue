<script setup>
import { computed, onMounted, ref, nextTick } from 'vue';
import { loadStripe } from '@stripe/stripe-js'

const { $communicationManager } = useNuxtApp();
const stripe = ref(null);
const divAfegirTargetaShow = ref(false);
const savedPaymentCards = ref(null);
const elements = ref(null);
const cardElement = ref(null);
const cardHolderName = ref('');
const containerCardElement = null;
const paymentOption = ref('1');
const newPaymentMethodShow = ref(false);
const selectedCard = ref(null);

onMounted(async () => {
    savedPaymentCards.value = await getPaymentsCards();
});

const emit = defineEmits(['chooseMethod', 'choosePaymentCard']);

function chooseMethod(option) {
    emit('chooseMethod', option)
}

function choosePaymentCard(card_id) {
    emit('choosePaymentCard', card_id)
}

function choosePayment(event) {
    paymentOption.value = event.target.value;
    chooseMethod(paymentOption.value)
    if (paymentOption.value === '1') {
        newPaymentMethodShow.value = false;
        stripe.value = null;
    } else if (savedPaymentCards.value !== null && savedPaymentCards.value.length === 0) {
        agregarTarjeta();
    }
}

async function restoreStripe() {
    stripe.value = await loadStripe('pk_test_51RGaqjRtaTRoDEKmV6KQUqgfOzfnIovnlBLrG6A3YJ9W6VgGMR0nS7QsOSNtQO4bHHGFbjhRl4p9w5hSytie5a7F00h6uhTBRG')
    elements.value = stripe.value.elements()
    cardElement.value = elements.value.create('card')
    cardElement.value.mount('#card-element')
}

async function agregarTarjeta() {
    newPaymentMethodShow.value = true;

    // if (!stripe.value) {
    await restoreStripe();
    // }
}

const updatePaymentMethod = async () => {
    //loader 
    try {
        // Realizas la llamada a tu API para crear el SetupIntent y obtener el client_secret
        const response = await $communicationManager.createSetUpIntent();
        console.log("Response: ", response);  // Verifica la respuesta de tu API
        const clientSecret = response.client_secret;  // Asegúrate de acceder a client_secret correctamente

        if (!response || !response.client_secret) {
            console.error('No client_secret in the response');
            return;
        }

        // Usas el clientSecret en el método de Stripe
        const { setupIntent, error } = await stripe.value.confirmCardSetup(
            clientSecret,
            {
                payment_method: {
                    card: cardElement.value,
                    billing_details: { name: cardHolderName.value }
                }
            }
        );

        if (error) {
            console.error(error.message);
            // Manejo de errores
        } else {
            console.log('Card verified successfully');
            let paymentMethodResponse = await $communicationManager.addPaymentMethod(setupIntent.payment_method)
            // Manejo de verificación exitosa
            await getPaymentsCards();
            savedPaymentCards.value = await getPaymentsCards();
            newPaymentMethodShow.value = false;
        }
    } catch (error) {
        console.error('Error creating SetupIntent: ', error);
    }
    //loader 
};

const getPaymentsCards = async () => {
    try {
        const response = await $communicationManager.retrievePaymentCards();
        return response.paymentMethods;
    } catch (error) {
        console.error(error);
        return null;
    }
}

const selectPaymentMethod = async (card) => {
    try {
        const response = await $communicationManager.selectPaymentMethod(card);
        selectedCard.value = response;
        choosePaymentCard(selectedCard.value)
    } catch (error) {
        console.error("Error: ", error);
    }
}
</script>

<template>
    <div id="methodsPay" class="mt-3 rounded-md bg-white p-2 mb-[80px]">
        <div class="w-full flex items-center mb-3">
            <svg width="1.7em" height="1.7em" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path
                        d="M19 8V8C20.1046 8 21 8.89543 21 10V18C21 19.1046 20.1046 20 19 20H6C4.34315 20 3 18.6569 3 17V7C3 5.34315 4.34315 4 6 4H17C18.1046 4 19 4.89543 19 6V8ZM19 8H7M17 14H16"
                        stroke="#276BF2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </g>
            </svg>
            <h3 class="ml-1 text-xl">Mètodes de pagament</h3>
        </div>
        <div>
            <label for="efectiu" name="status"
                class="font-medium text-lg h-14 relative hover:bg-zinc-100 flex items-center pl-3 gap-2 rounded-lg has-[:checked]:text-[#276BF2] has-[:checked]:bg-blue-50 has-[:checked]:ring-[#276BF2] has-[:checked]:ring-1 select-none">
                <div class="w-5 fill-[#276BF2]">
                    <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        class="bi bi-cash-coin">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                        </g>
                        <g id="SVGRepo_iconCarrier">
                            <path fill-rule="evenodd"
                                d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z">
                            </path>
                            <path
                                d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z">
                            </path>
                            <path
                                d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z">
                            </path>
                            <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z">
                            </path>
                        </g>
                    </svg>
                </div>
                <p>Efectiu</p>
                <input checked="" type="radio" name="status" class="peer/html w-4 h-4 absolute accent-current right-3"
                    id="efectiu" value=1 @change="choosePayment" />
            </label>
            <label for="targeta"
                class="font-medium text-lg h-14 relative flex items-center pl-3 gap-2 rounded-lg has-[:checked]:text-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:ring-blue-300 has-[:checked]:ring-1 select-none">
                <div class="w-5">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                        </g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M3 8C3 6.34315 4.34315 5 6 5H18C19.6569 5 21 6.34315 21 8V16C21 17.6569 19.6569 19 18 19H6C4.34315 19 3 17.6569 3 16V8Z"
                                stroke="currentColor" stroke-width="2">
                            </path>
                            <path d="M3 10H21" stroke="currentColor" stroke-width="2"></path>
                            <path d="M14 15L17 15" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            </path>
                        </g>
                    </svg>
                </div>
                <p>Targeta</p>
                <input type="radio" name="status" class="peer/html w-4 h-4 absolute accent-current right-3" id="targeta"
                    value=2 @change="choosePayment" />
            </label>

            <div v-if="paymentOption === '2' && savedPaymentCards">
                <div v-if="savedPaymentCards.length > 0 && !newPaymentMethodShow"
                    class="flex flex-col w-full justify-center items-center">
                    <button @click="agregarTarjeta" class="my-2 bg-[#276BF2] text-white p-3 rounded-md">
                        Afegir nou mètode de pagament
                    </button>
                    <div v-for="(creditCard, index) in savedPaymentCards" :key="index"
                        @click="selectPaymentMethod(creditCard)"
                        class="shadow rounded mb-2 cursor-pointer w-full" :class="creditCard.id === selectedCard?.defaultPaymentMethod.id ? 'bg-blue-100' : 'bg-white'">
                        <div class="p-4">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <i class="bi bi-credit-card text-xl mr-3"></i>
                                    <div>
                                        <p class="text-base font-semibold">{{
                                            creditCard.billing_details.name }}</p>
                                        <p class="text-sm">{{ creditCard.card.exp_month }}/{{
                                            creditCard.card.exp_year }}</p>
                                        <p class="text-xs">**** {{ creditCard.card.last4 }}</p>
                                    </div>
                                </div>
                                <button class="p-0 text-sm" @click.stop="deletePaymentMethod(creditCard)"
                                    aria-label="Eliminar">
                                    <i class="bi bi-trash3 text-xl"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else-if="savedPaymentCards.length === 0 || newPaymentMethodShow"
                    class="mt-4 p-4 border border-gray-300 bg-gray-100">
                    <div class="flex justify-center">
                        <div class="w-full max-w-md">
                            <div class="rounded-lg shadow-sm border border-gray-200 bg-white">
                                <div class="p-6">
                                    <h4 class="text-xl font-semibold mb-4">Afegir mètode de pagament</h4>
                                    <form>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1"
                                                for="card-holder-name">Titular de la targeta</label>
                                            <div class="relative">
                                                <input
                                                    class="peer block w-full rounded-md border border-gray-300 py-2 px-3 placeholder-transparent focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                                    id="card-holder-name" placeholder="Introduce el nombre del titular"
                                                    type="text" v-model="cardHolderName" />
                                                <label for="card-holder-name"
                                                    class="absolute left-3 -top-2.5 text-sm text-gray-500 bg-white px-1 transition-all peer-placeholder-shown:top-2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-gray-500">
                                                    Nom del titular
                                                </label>
                                            </div>
                                        </div>

                                        <div class="mb-6">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Informació de la targeta</label>
                                            <div id="card-element"
                                                class="border border-gray-300 rounded-md px-3 py-3 bg-white">
                                            </div>
                                        </div>

                                        <button @click="updatePaymentMethod" type="button"
                                            class="w-full bg-blue-600 text-white font-medium py-2 rounded-md hover:bg-blue-700 transition">
                                            Afegir mètode de pagament
                                        </button>
                                        <button v-if="savedPaymentCards.length > 0"
                                            @click="newPaymentMethodShow = false" type="button"
                                            class="mt-1 w-full text-gray-600 font-medium py-2 rounded-md border border-gray-300">
                                            Cancel·lar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>