<template>
    <header class="border-b flex items-center p-4 max-h-[75px]">
        <div :class="customClass">
            <h3 class="text-2xl ml-4">{{text}}</h3>
        </div>
    </header>
</template>

<script setup>
    const props = defineProps({
        customClass: {
            type: String,
            default: 'w-full flex items-center'
        },
        text: {
            type: String,
            required: true
        }
    })
</script>