<template>
  <div class="flex items-center justify-between py-2">
    <div>
      <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ field.label }}</span>
      <p v-if="field.helper" class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
        {{ field.helper }}
      </p>
    </div>
    <button
      type="button"
      @click="toggle"
      :disabled="field.disabled"
      class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
      :class="model ? 'bg-blue-600' : 'bg-gray-300 dark:bg-gray-600'"
    >
      <span
        class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform"
        :class="model ? 'translate-x-6' : 'translate-x-1'"
      />
    </button>
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

const emit = defineEmits<{ 'update:modelValue': [value: boolean] }>()

const model = computed(() => Boolean(props.modelValue))

function toggle() {
  if (props.field.disabled) return
  emit('update:modelValue', !model.value)
}
</script>