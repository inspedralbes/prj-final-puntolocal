<template>
    <div class="footer flex items-center justify-between mt-auto border-t border-gray-300 fixed">
        <button @click="togglePayment"
            class="btn-cancel w-[39%] h-[60px] justify-center border rounded-md border border-gray-400 px-4 py-2 text-xl text-gray-500 font-medium disabled:cursor-wait ">
            Cancel·lar
        </button>
        <button @click="handleClick"
            :class="`btn-ok w-[59%] h-[60px] justify-center rounded-md border border-transparent px-4 py-2 text-xl font-semibold ${payOption === '2' && !paymentCardID ? 'opacity-50 cursor-not-allowed' : ''}`">
            Pagar
        </button>
    </div>
</template>

<script setup>
const props = defineProps({
    togglePayment: Function,
    crearComanda: Function,
    paymentCardID: String,
    payOption: {
        type: String,
        required: true
    }
})

const handleClick = () => {
    if(!props.paymentCardID && props.payOption === '2') return;
    props.crearComanda();
}

</script>

<style scoped>
.btn-ok {
    background-color: #276BF2;
    color: white;
}
</style>