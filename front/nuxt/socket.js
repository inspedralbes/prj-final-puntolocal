import { io } from "socket.io-client";
import { useRuntimeConfig } from "#app";

const config = useRuntimeConfig();
const socket = io(config.public.baseNodeUrl);

export default socket;