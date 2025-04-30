<template>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 transition-all hover:shadow-md">
        <div class="flex items-center gap-3">
            <div class="p-3 rounded-lg" :style="{ backgroundColor: `${color}20`, color: color }">
                <i class="bi" :class="[icon, 'text-xl']"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-300 mb-1">{{ title }}</p>
                <p class="text-lg font-semibold text-gray-800 dark:text-white">{{ value }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
  title: {
    type: String,
    required: true
  },
  value: {
    type: [String, Number],
    required: true
  },
  icon: {
    type: String,
    required: true
  },
  color: {
    type: String,
    default: '#4F46E5'
  }
});
</script>