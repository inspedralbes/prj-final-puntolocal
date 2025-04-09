<script setup>
import { ref, onMounted } from "vue";
import { io } from "socket.io-client";

const socket = io("http://localhost:8001");
const mensajes = ref([]);
const nuevoMensaje = ref("");

const enviarTest = () => {
  socket.emit('test');
};
</script>

<template>
  <div>
    <button @click="enviarTest()">Enviar test</button>
  </div>
</template>
