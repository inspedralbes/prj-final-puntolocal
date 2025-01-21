<template>
    <button :data-testid="testId" :type="type" :class="class" :disabled="disabled">
        <slot></slot>
    </button>
</template>

<script setup>
    const props = defineProps({
        testId: {
            type: String,
            default: 'button',
        },
        type: {
            type: String,
            default: 'text',
        },
        class: {
            type: String,
            default: 'group relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-50',
        },
        disabled: {
            type: Boolean,
            default: false,
        },
    });
</script>