<template>
    <div class="layout-container">
        <header class="sticky top-0 left-0 w-full bg-white z-10">
            <div class="mx-auto flex max-w-7xl items-center justify-between p-2 py-4 lg:px-8 border-b-2 border-black-500"
                aria-label="Global">
                <div class="w-full mx-auto bg-white flex justify-around items-center">
                    <input class="pl-5 pr-5 py-2 mx-5 w-full border border-gray-300 rounded-md" type="text"
                        name="search" id="search" placeholder="Buscar..." style="background-color: #eff1f3;">
                    <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5.7 15C4.03377 15.6353 3 16.5205 3 17.4997C3 19.4329 7.02944 21 12 21C16.9706 21 21 19.4329 21 17.4997C21 16.5205 19.9662 15.6353 18.3 15M12 9H12.01M18 9C18 13.0637 13.5 15 12 18C10.5 15 6 13.0637 6 9C6 5.68629 8.68629 3 12 3C15.3137 3 18 5.68629 18 9ZM13 9C13 9.55228 12.5523 10 12 10C11.4477 10 11 9.55228 11 9C11 8.44772 11.4477 8 12 8C12.5523 8 13 8.44772 13 9Z"
                            stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
        </header>
        <main class="flex-grow">
            <slot />
        </main>
        <footer class="sticky bottom-0 left-0 w-full">
            <nav class="flex justify-around">
                <NuxtLink to="/" class="flex flex-col items-center text-gray-300 hover:text-white">
                    <svg class="w-6 h-6 mb-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="black">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                </NuxtLink>
                <NuxtLink to="/cistella" class="flex flex-col items-center text-gray-300 hover:text-white">
                    <svg class="w-6 h-6 mb-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <g clip-path="url(#clip0_15_35)">
                            <rect width="24" height="24" />
                            <path
                                d="M5.33331 6H19.8672C20.4687 6 20.9341 6.52718 20.8595 7.12403L20.1095 13.124C20.0469 13.6245 19.6215 14 19.1172 14H16.5555H9.44442H7.99998"
                                stroke="#000000" stroke-linejoin="round" />
                            <path
                                d="M2 4H4.23362C4.68578 4 5.08169 4.30341 5.19924 4.74003L8.30076 16.26C8.41831 16.6966 8.81422 17 9.26638 17H19"
                                stroke="#000000" stroke-linecap="round" stroke-linejoin="round" />
                            <circle cx="10" cy="20" r="1" stroke="#000000" stroke-linejoin="round" />
                            <circle cx="17.5" cy="20" r="1" stroke="#000000" stroke-linejoin="round" />
                        </g>
                        <defs>
                            <clipPath id="clip0_15_35">
                                <rect width="24" height="24" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                </NuxtLink>
                <NuxtLink to="/perfil" class="flex flex-col items-center text-gray-300 hover:text-white">
                    <svg class="w-6 h-6 mb-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="black">
                        <path
                            d="M5 21C5 17.134 8.13401 14 12 14C15.866 14 19 17.134 19 21M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z"
                            stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                    </svg>
                </NuxtLink>
            </nav>
        </footer>
    </div>
</template>

<style>
.layout-container {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.flex-grow {
    flex: 1;
}

/* ...existing styles... */
footer {
    background-color: #f7f7f7;
    padding: 20px 0px;
}
</style>