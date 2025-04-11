import { io } from "socket.io-client";
export default defineNuxtPlugin((nuxtApp) => {
  const config = useRuntimeConfig();
  // Creá el socket usando el valor de runtime config
  const socket = io(config.public.baseNodeUrl, {
    path: "/socket.io/",
    transports: ["websocket"]
  });
  // Inyectá el socket en la app
  nuxtApp.provide("socket", socket);
});