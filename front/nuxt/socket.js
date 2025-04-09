import { io } from "socket.io-client";
import { useRuntimeConfig } from "#app";

const config = useRuntimeConfig();
// const socket = io(config.public.baseNodeUrl);
const socket = io('http://172.17.0.1:8001')

export default socket;