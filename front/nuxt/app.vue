<template>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
    rel="stylesheet">
  <div>
    <NuxtRouteAnnouncer />
    <NuxtLayout>
      <NuxtPage />
    </NuxtLayout>
  </div>
</template>

<style>
body {
  font-family: "Lato", serif;
  font-display: swap;
}

.color-principal-1 {
  color: #276BF2;
}

.color-principal-2 {
  color: #447EF2;
}

.color-principal-3 {
  color: #6393F2;
}

.color-secundario-1 {
  color: #000000;
}

.color-secundario-2 {
  color: #1E2026;
}

.color-secundario-3 {
  color: #F2F2F2;
}

.page-enter-active,
.page-leave-active {
  transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
}

.page-enter-from {
  opacity: 0;
  transform: translateY(-20px);
}

.page-leave-to {
  opacity: 0;
  transform: translateY(20px);
}
</style>

<script setup>
import { useAuthStore } from '../../stores/authStore';
import { useRoute, useRouter } from "vue-router";
import { io } from "socket.io-client";

const auth = useAuthStore();
const route = useRoute();
const router = useRouter();
const socket = io("http://localhost:8001");

onMounted(() => {
  if (auth?.comercio) {
    socket.on("connect", () => {
      socket.emit("identificarUsuario", { user_id: auth.user.id });
    });

    socket.on("nuevaOrdenRecibida", (orden) => {
      console.log(orden);
      if (confirm("Nova comanda rebuda, vols veure'l?")) {
        setTimeout(() => {
          if (orden?.id) {
            router.push(`/admin/comandes/${orden.id}`);
          }
        }, 500);
      }
    });
  }
})

window.addEventListener('beforeunload', () => {
  localStorage.removeItem("animationShown");
});

function test() {
  socket.emit("test");
}
</script>