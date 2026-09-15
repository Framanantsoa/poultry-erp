<template>
  <label class="flex items-start gap-2 cursor-pointer select-none">
    <input
      v-model="model"
      type="checkbox"
      :disabled="field.disabled"
      class="mt-0.5 h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
    />
    <div>
      <span class="text-sm text-gray-700 dark:text-gray-300">{{ field.label }}</span>
      <p v-if="field.helper" class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
        {{ field.helper }}
      </p>
      <p v-if="error" class="text-xs text-red-500 mt-0.5">{{ error }}</p>
    </div>
  </label>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import type { FieldConfig } from '@/types/form'

const props = defineProps<{
  modelValue: unknown
  field: FieldConfig
  error?: string
}>()

const emit = defineEmits<{ 'update:modelValue': [value: boolean] }>()

const model = computed({
  get: () => Boolean(props.modelValue),
  set: (v) => emit('update:modelValue', v),
})
</script>