<template>
  <FloatingInput
    v-model="model"
    :id="field.name"
    :label="field.label"
    type="number"
    :required="field.required"
    :disabled="field.disabled"
    :readonly="field.readonly"
    :error="error"
    :min="field.min"
    :max="field.max"
    :step="field.step"
  />
</template>

<script setup lang="ts">
import { computed } from 'vue'
import type { FieldConfig } from '@/types/form'
import FloatingInput from '@/components/ui/FloatingInput.vue'

const props = defineProps<{
  modelValue?: string | number
  field: FieldConfig
  error?: string
}>()

const emit = defineEmits<{ 'update:modelValue': [value: number | null] }>()

const model = computed({
  get: () => props.modelValue,
  set: (v) => emit('update:modelValue', v === '' ? null : Number(v)),
})
</script>