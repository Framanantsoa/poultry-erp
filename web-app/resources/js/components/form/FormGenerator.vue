<template>
  <form @submit.prevent="handleSubmit" class="space-y-6">
    <!-- Field grid -->
    <div
      class="grid gap-4"
      :class="{
        'grid-cols-1': schema.columns === 1 || !schema.columns,
        'grid-cols-1 md:grid-cols-2': schema.columns === 2,
      }"
    >
      <div
        v-for="field in schema.fields"
        :key="field.name"
        :class="field.colSpan === 2 ? 'md:col-span-2' : ''"
      >
        <component
          :is="getFieldComponent(field.type)"
          v-model="form[field.name]"
          :field="field"
          :error="errors[field.name]"
        />
      </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-end gap-3 pt-2">
      <Link
        v-if="schema.cancelHref"
        :href="schema.cancelHref"
        class="px-4 py-2.5 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
      >
        {{ schema.cancelLabel ?? 'Cancel' }}
      </Link>

      <SubmitBtn
        type="submit"
        :variant="schema.submitVariant ?? 'primary'"
        :loading="processing"
      >
        {{ schema.submitLabel ?? 'Save' }}
      </SubmitBtn>
    </div>
  </form>
</template>

<script setup lang="ts">
import { reactive, watch } from 'vue'
import { Link } from '@inertiajs/vue3'
import type { FormSchema, FieldConfig } from '@/types/form'
import SubmitBtn from '@/components/ui/SubmitBtn.vue'

// Field components
import NumberField from './fields/NumberField.vue'
import SelectField from './fields/SelectField.vue'
import TextareaField from './fields/TextareaField.vue'
import CheckboxField from './fields/CheckboxField.vue'
import SwitchField from './fields/SwitchField.vue'
import RadioField from './fields/RadioField.vue'
import TextField from './fields/TextField.vue'

const props = defineProps<{
  schema: FormSchema
  modelValue: Record<string, any>
  errors?: Record<string, string>
  processing?: boolean
}>()

const emit = defineEmits<{
  'update:modelValue': [value: Record<string, unknown>]
  submit: [values: Record<string, unknown>]
}>()

// Local form state, initialized from defaults + modelValue
const form = reactive<Record<string, unknown>>(
  Object.fromEntries(
    props.schema.fields.map((f) => [
      f.name,
      props.modelValue[f.name] ?? f.default ?? defaultForType(f.type),
    ]),
  ),
)

// Two-way sync with parent
watch(form, () => emit('update:modelValue', { ...form }), { deep: true })

watch(
  () => props.modelValue,
  (val) => Object.assign(form, val),
  { deep: true },
)

const errors = props.errors ?? {}

function defaultForType(type: string): unknown {
  if (type === 'checkbox' || type === 'switch') return false
  if (type === 'number') return null
  return ''
}

function getFieldComponent(type: string) {
  switch (type) {
    case 'number':
      return NumberField
    case 'select':
      return SelectField
    case 'textarea':
      return TextareaField
    case 'checkbox':
      return CheckboxField
    case 'switch':
      return SwitchField
    case 'radio':
      return RadioField
    case 'text':
    case 'email':
    case 'password':
    case 'tel':
    case 'date':
    case 'datetime':
    case 'time':
    default:
      return TextField
  }
}

function handleSubmit() {
  emit('submit', { ...form })
}
</script>
