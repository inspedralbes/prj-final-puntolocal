<template>
    <div>
        <button @click="iniciarPago" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            :disabled="isLoading">
            {{ isLoading ? 'Procesando...' : 'Pagar con Stripe' }}
        </button>
        <div id="card-element"></div>
        <p v-if="error" class="text-red-500 mt-2">{{ error }}</p>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
// Importamos directamente la librería de Stripe
import { loadStripe } from '@stripe/stripe-js';

const config = useRuntimeConfig();
const stripePromise = ref(null);
const isLoading = ref(false);
const error = ref(null);

onMounted(() => {
    // Inicializamos Stripe con tu clave pública
    stripePromise.value = loadStripe(config.public.stripePublicKey);
});

async function iniciarPago() {
    try {
        isLoading.value = true;
        error.value = null;

        // Obtenemos la instancia de Stripe
        const stripe = await stripePromise.value;
        if (!stripe) {
            throw new Error("No se pudo cargar Stripe");
        }

        // Llamar a tu API de Laravel para crear una sesión de checkout
        const apiUrl = `http://localhost:8000/api/create-checkout-session`;

        console.log('Enviando solicitud a:', apiUrl);

        const response = await fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                // Datos adicionales si es necesario
            }),
        });

        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            throw new Error(errorData.message || 'Error al crear la sesión de pago');
        }

        const { id: sessionId } = await response.json();
        console.log('Session ID recibido:', sessionId);

        // Redirigir al checkout de Stripe
        const { error: redirectError } = await stripe.redirectToCheckout({
            sessionId
        });

        if (redirectError) {
            throw new Error(redirectError.message);
        }
    } catch (err) {
        console.error('Error completo:', err);
        error.value = err.message || 'Error al procesar el pago';
    } finally {
        isLoading.value = false;
    }
}
</script>