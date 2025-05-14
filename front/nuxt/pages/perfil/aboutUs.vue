<template>
    <section class="bg-gray-50 py-16 px-4">
        <div class="max-w-5xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col !mx-4">

                <div class="text-center mb-12">
                    <h1 class="text-4xl font-bold text-gray-800">Sobre Nosaltres</h1>
                    <p class="mt-4 text-lg text-gray-600">Conèix qui som i què fem</p>
                </div>
                <!-- Mission & Vision -->
                <div class="grid gap-8 lg:grid-cols-2 mb-16">
                    <div class="p-6 bg-white rounded-2xl shadow">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">La Nostra Missió</h2>
                        <p class="text-gray-600 leading-relaxed text-justify">  
                            A HolaBarri, la nostra missió és enfortir els vincles entre els veïns i els seus comerços de
                            proximitat, promovent una economia local vibrant i sostenible. Volem dotar els comerciants
                            d’eines digitals senzilles i eficients perquè gestionin el seu negoci de manera autònoma i
                            connectin directament amb el consumidor proper. Creiem en la confiança, la transparència i la
                            col·laboració comunitària com a pilars fonamentals per a un desenvolupament econòmic equilibrat
                            i resilient.
                        </p>
                    </div>
                    <div class="p-6 bg-white rounded-2xl shadow">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">La Nostra Visió</h2>
                        <p class="text-gray-600 leading-relaxed text-justify">
                            Imaginem un futur on cada barri disposi d’una plataforma digital que reflecteixi la seva
                            identitat i diversitat comercial. La nostra visió és expandir HolaBarri a múltiples comunitats,
                            oferint sempre una experiència d’usuari àgil, personalitzada i segura. Aspirem a ser la
                            referència en marketplaces locals, integrant innovacions com ara recomanacions intel·ligents,
                            recompenses per a clients fidels i programes de col·laboració entre negocis. El nostre objectiu
                            final és reforçar el teixit social i econòmic de cada barri, impulsant-ne el creixement i
                            consolidant-ne la cohesió." </p>
                    </div>
                </div>
                <!-- Team -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 text-center mt-8 mb-8">El Nostre Equip</h2>
                    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        <!-- Student Card 1 -->
                        <div class="bg-white rounded-2xl shadow p-6 flex flex-col items-center text-center">
                            <div class="w-24 h-24 rounded-full bg-gray-200 mb-4 flex items-center justify-center">
                                <!-- Placeholder for image -->
                                <span class="text-gray-400">Foto 1</span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800">Agustín Enzo Noviello</h3>
                            <p class="text-gray-600">DAW - Frontend Developer</p>
                        </div>
                        <!-- Student Card 2 -->
                        <div class="bg-white rounded-2xl shadow p-6 flex flex-col items-center text-center">
                            <div class="w-24 h-24 rounded-full bg-gray-200 mb-4 flex items-center justify-center">
                                <span class="text-gray-400">Foto 2</span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800">Arnau Barrero Sorribas</h3>
                            <p class="text-gray-600">DAW - Backend Developer</p>
                        </div>
                        <!-- Student Card 3 -->
                        <div class="bg-white rounded-2xl shadow p-6 flex flex-col items-center text-center">
                            <div class="w-24 h-24 rounded-full bg-gray-200 mb-4 flex items-center justify-center">
                                <span class="text-gray-400">Foto 3</span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800"> Lorenzo Moll Anglada</h3>
                            <p class="text-gray-600">DAW - Fullstack Developer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
definePageMeta({
    layout: 'footer-only',
});
</script>

<style scoped>
</style>