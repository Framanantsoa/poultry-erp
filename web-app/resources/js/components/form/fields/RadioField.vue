<template>
  <div>
    <span class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
      {{ field.label }}
      <span v-if="field.required" class="text-red-500 ml-0.5">*</span>
    </span>
    <div class="flex flex-wrap gap-4">
      <label
        v-for="option in field.options"
        :key="option.value"
        class="flex items-center gap-2 cursor-pointer"
      >
        <input
          type="radio"
          :name="field.name"
          :value="option.value"
          v-model="model"
          :disabled="field.disabled || option.disabled"
          class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700"
        />
        <span class="text-sm text-gray-700 dark:text-gray-300">{{ option.label }}</span>
      </label>
    </div>
    <p v-if="error" class="mt-1 text-xs text-red-500">{{ error }}</p>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import type { FieldConfig } from '@/types/form'

const props = defineProps<{
  modelValue: unknown
  field: FieldConfig
  error?: string
}>()

const emit = defineEmits<{ 'update:modelValue': [value: unknown] }>()

const model = computed({
  get: () => props.modelValue,
  set: (v) => emit('update:modelValue', v),
})
</script>