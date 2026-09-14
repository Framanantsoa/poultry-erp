<template>
  <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
    <div class="flex items-center gap-4">
      <div class="p-3 rounded-lg" :class="colorClasses.bg">
        <component :is="iconComponent" class="h-6 w-6" :class="colorClasses.icon" />
      </div>
      <div class="min-w-0">
        <p class="text-sm text-gray-600 dark:text-gray-400 truncate">{{ label }}</p>
        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ value }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import * as HeroIcons from '@heroicons/vue/24/outline'

const props = defineProps({
  label: { type: String, required: true },
  value: { type: [String, Number], required: true },
  icon:  { type: String, required: true },
  color: { type: String, default: 'blue' },
})

const colorClasses = computed(() => ({
  blue:   { bg: 'bg-blue-100 dark:bg-blue-900',     icon: 'text-blue-600 dark:text-blue-300' },
  green:  { bg: 'bg-green-100 dark:bg-green-900',   icon: 'text-green-600 dark:text-green-300' },
  yellow: { bg: 'bg-yellow-100 dark:bg-yellow-900', icon: 'text-yellow-600 dark:text-yellow-300' },
  red:    { bg: 'bg-red-100 dark:bg-red-900',       icon: 'text-red-600 dark:text-red-300' },
  purple: { bg: 'bg-purple-100 dark:bg-purple-900', icon: 'text-purple-600 dark:text-purple-300' },
}[props.color]))

const iconComponent = computed(() =>
  HeroIcons[props.icon] ?? HeroIcons.QuestionMarkCircleIcon
)
</script>