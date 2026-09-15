<template>
  <div class="w-full">
    <label
      v-if="field.label"
      :for="field.name"
      class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
    >
      {{ field.label }}
      <span v-if="field.required" class="text-red-500 ml-0.5">*</span>
    </label>

    <select
      :id="field.name"
      v-model="model"
      :disabled="field.disabled"
      :required="field.required"
      class="w-full px-3.5 py-3 rounded-lg text-sm bg-white dark:bg-gray-800 border text-gray-900 dark:text-white focus:outline-none focus:ring-2 transition-colors"
      :class="error
        ? 'border-red-500 focus:ring-red-500'
        : 'border-gray-300 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500'"
    >
      <option value="" disabled>Select {{ field.label.toLowerCase() }}</option>
      <option
        v-for="option in field.options"
        :key="option.value"
        :value="option.value"
        :disabled="option.disabled"
      >
        {{ option.label }}
      </option>
    </select>

    <p v-if="error" class="mt-1 text-xs text-red-500">{{ error }}</p>
    <p v-else-if="field.helper" class="mt-1 text-xs text-gray-500 dark:text-gray-400">
      {{ field.helper }}
    </p>
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