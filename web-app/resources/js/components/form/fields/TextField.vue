<template>
  <FloatingInput
    v-model="model"
    :id="field.name"
    :label="field.label"
    :type="field.type"
    :required="field.required"
    :disabled="field.disabled"
    :readonly="field.readonly"
    :error="error"
    :autocomplete="field.autocomplete"
  />
</template>

<script setup lang="ts">
import { computed } from 'vue'
import type { FieldConfig } from '@/types/form'
import FloatingInput from '@/components/ui/FloatingInput.vue'

const props = defineProps<{
  modelValue: string 
  field: FieldConfig
  error?: string
}>()

const emit = defineEmits<{ 'update:modelValue': [value: string ] }>()

const model = computed({
  get: () => props.modelValue,
  set: (v) => emit('update:modelValue', v),
})
</script>