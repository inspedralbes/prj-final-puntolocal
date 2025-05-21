import 'dotenv/config';
import fetch from 'node-fetch';
import express from "express";
import http from "http";
import { Server } from "socket.io";


// const Host = 'http://localhost:8000/api';
// const Host = "http://172.17.0.1:8000/api"
const Host = process.env.API_BASE_URL;

const app = express();
const server = http.createServer(app);
const io = new Server(server, {
  cors: {
    origin: process.env.CORS_ORIGINS.split(','),
    methods: ["GET", "POST"],
    allowedHeaders: ["Content-Type"],  // Los encabezados permitidos
  },
  path: "/socket.io/", // Asegúrate de que esta ruta coincida con la de tu proxy Nginx
});

async function obtenerUseridComercio(comercio_id) {
  try {
    const response = await fetch(`${Host}/comercios/getUserid/${comercio_id}`);
    if (!response.ok) {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`);
      return null;
    }
    const data = await response.json();
    console.log("DATA OBTENERUSEIDCOMERCIO: ", data)
    return data.usuario_id;
  } catch (error) {
    console.error("Error al realizar la petición:", error);
    return null;
  }
}

io.on("connection", (socket) => {
  console.log("Un usuario se ha conectado");

  socket.on("mensaje", (data) => {
    console.log("Mensaje recibido:", data);
    io.emit("mensaje", data);  // Reenvía el mensaje a todos los clientes
  });

  socket.on("identificarUsuario", (data) => {
    socket.join(`user_${data.user_id}`);
    console.log(`Usuario ${data.user_id} unido a la sala user_${data.user_id}`);
  });

  socket.on("nuevaOrden", async (data) => {
    console.log("DATA NUEVAORDEN: ",data)
    for (const suborder of data.subcomandes) {
      const suborderData = {
        comercio_id: suborder.comercio_id,
        created_at: data.created_at,
        estat: suborder.estat_compra.id,
        id: suborder.suborder_id,
        estat_compra: suborder.estat_compra,
        order_id: data.order_id,
        order: {
          id: data.order_id,
          cliente_id: data.cliente.id,
          cliente: {
            id: data.cliente.id,
            name: data.cliente.nombre,
            apellidos: data.cliente.apellidos,
          },
          tipo_envio: data.tipo_envio,
          tipo_pago: data.tipo_pago,
        },
        subtotal: suborder.subtotal,
      };
      const ownerId = await obtenerUseridComercio(suborder.comercio_id);
      console.log("OWNERID: ", ownerId);
      console.log("SUBORDERDATA: ", suborderData);
      io.to(`user_${ownerId}`).emit("nuevaOrdenRecibida", suborderData);
    }
  });

  socket.on("test", () => {
    console.log("Usuarios en la sala:", io.sockets.adapter.rooms);
    io.emit("TestEnviado");
  });

  socket.on("disconnect", () => {
    console.log("Un usuario se ha desconectado");
  });
});

// Asegurarse de que el servidor escucha en todas las interfaces
server.listen(process.env.PORT , "0.0.0.0", () => {
  console.log("Servidor de sockets corriendo en el puerto", process.env.PORT);
});