<template>
    <div class="flex flex-col items-center p-6 bg-gray-100 min-h-screen">
        <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md text-center">
            <div class="space-y-4">
                <button class="w-full bg-blue-500 text-white py-2 rounded-xl hover:bg-blue-600" @click="goToInfo">
                    Información personal
                </button>

                <button class="w-full bg-blue-500 text-white py-2 rounded-xl hover:bg-blue-600" @click="goToEdit">
                    Editar informació
                </button>

                <button class="w-full bg-blue-500 text-white py-2 rounded-xl hover:bg-blue-600" @click="goToCompras">
                    Veure les meves compres
                </button>
                
                <button 
                    class="w-full bg-blue-500 text-white py-2 rounded-xl hover:bg-blue-600" 
                    @click="goToComercio">
                    {{ hasComercio ? 'Panel de Control del Comercio' : 'Crear Comercio' }}
                </button>
                
                <button class="w-full bg-blue-500 text-white py-2 rounded-xl hover:bg-blue-600" @click="goToLogout">
                    Tancar sessió
                </button>

            </div>
        </div>
    </div>
</template>

<script setup>
    import { useAuthStore } from '#imports';
    import { ref, onMounted } from 'vue';
    
    const authStore = useAuthStore();
    const hasComercio = ref(false);

    onMounted(async () => {
        hasComercio.value = await checkComercio();
    });

    function goToInfo() { navigateTo('/perfil/info'); }
    function goToEdit() { navigateTo('/perfil/perfilCliente'); }
    function goToCompras() { navigateTo('/perfil/compras'); }
    async function checkComercio(){
        const { $communicationManager } = useNuxtApp();
        const res = await $communicationManager.checkUserHasComercio(authStore.user.id);
        
        if(res){
            console.log('Tiene comercio')
            return true
        }else{
            console.log('No tiene comercio')
            return false
        }
    }
    async function goToLogout() { 
        const { $communicationManager } = useNuxtApp();
        await $communicationManager.logout();
        authStore.logout();
        navigateTo('/login');
    }
    function goToComercio() {
        if (hasComercio.value) {
            navigateTo('/admin');
        } else {
            navigateTo('/registerStore');
        }
    }
</script>