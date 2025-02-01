<template>
    <div class="min-h-screen flex flex-col">
        <div id="header" class="flex items-center justify-between p-4 bg-white shadow-lg rounded-lg">
            <div class="text-xl text-gray-700 cursor-pointer">
                ←
            </div>

            <div class="flex-1 text-center text-lg font-semibold text-gray-800 truncate max-w-[calc(100%-2rem)]" :title="producto?.comercio || 'Nombre del comercio no disponible'">
                {{ producto?.comercio?.length > 18 ? producto.comercio.slice(0, 18) + '...' : producto?.comercio || 'Nombre del comercio no disponible' }}
            </div>

            <div id="corazon" class="w-8 h-8 flex items-center justify-center cursor-pointer">
                <img src="../../assets/heart.svg" alt="Heart Icon" class="w-full h-full object-contain" />
            </div>
        </div>

        
        <div id="footer" class="flex items-center justify-between p-4 mt-auto bg-gray-50 shadow-lg rounded-lg">
            <div id="precio" class="text-xl font-semibold text-gray-800">
                {{ producto?.precio ? `Precio: $${producto.precio.toFixed(2)}` : 'Precio no disponible' }}
            </div>

            <div id="carrito" class="flex items-center space-x-4">
                <ButtonBasketComp :producto="producto" />
            </div>
        </div>
    </div>
</template>



<script setup>
    definePageMeta({
        layout: false,
    });

    import { useNuxtApp } from "#app";
    import { ref, onMounted } from "vue";
    import { useRoute } from "vue-router";
    import ButtonBasketComp from "../../components/ButtonBasketComp.vue";

    const route = useRoute();
    const { $communicationManager } = useNuxtApp();
    const producto = ref(null);
    const selectedColor = ref(null);
    const selectedSize = ref(null);

    const fetchProducto = async () => {
        try {
            const id = route.params.id;
            const response = await $communicationManager.getProductoById(id);
            console.log("JSON recibido:", response);

            if (response) {
                producto.value = response;

                console.log("Producto cargado:", producto.value);

                if (producto.value?.comercio?.nombre) {
                    console.log("Nombre del comercio:", producto.value.comercio.nombre);
                }

                if (producto.value.varientes && producto.value.varientes.length > 0) {
                    selectedColor.value = producto.value.varientes[0].color;
                    selectedSize.value = producto.value.varientes[0];
                }
            }
        } catch (error) {
            console.error("Error obteniendo el producto:", error);
        }
    };

    onMounted(() => {
        fetchProducto();
    });
</script>

<style scoped>
    @import '../../assets/productoConcreto.css';
</style>