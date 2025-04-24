<template>
    <div class="footer flex items-center justify-between mt-auto border-t border-gray-300 fixed">
        <button @click="togglePayment"
            class="btn-cancel w-[39%] h-[60px] justify-center border rounded-md border border-gray-400 px-4 py-2 text-xl text-gray-500 font-medium disabled:cursor-wait ">
            Cancel·lar
        </button>
        <button @click="crearComanda"
            class="btn-ok w-[59%] h-[60px] justify-center rounded-md border border-transparent px-4 py-2 text-xl font-semibold disabled:cursor-wait disabled:opacity-50">
            Pagar
        </button>
    </div>
</template>

<script setup>
defineProps({
    togglePayment: {
        type: Function
    },
    crearComanda: {
        type: Function
    }
})
</script>

<style scoped>
.btn-ok {
    background-color: #276BF2;
    color: white;
}
</style>