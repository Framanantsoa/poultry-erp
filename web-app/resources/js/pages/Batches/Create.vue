<template>
  <AppLayout title="Create Batch">
    <div class="max-w-3xl bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
      <h1 class="text-xl font-bold text-gray-900 dark:text-white mb-6">
        New Batch
      </h1>

      <FormGenerator
        :schema="schema"
        v-model="form"
        :errors="form.errors"
        :processing="form.processing"
        @submit="submit"
      />
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { reactive } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import FormGenerator from '@/components/form/FormGenerator.vue'
import type { FormSchema } from '@/types/form'

const schema: FormSchema = {
  columns: 2,
  submitLabel: 'Create Batch',
  cancelLabel: 'Cancel',
  cancelHref: '/batches',
  fields: [
    {
      name: 'name',
      type: 'text',
      label: 'Batch Name',
      placeholder: 'e.g. B-2026-001',
      required: true,
      colSpan: 2,
    },
    {
      name: 'breed_id',
      type: 'select',
      label: 'Breed',
      required: true,
      options: [
        { value: 1, label: 'Broiler' },
        { value: 2, label: 'Layer' },
        { value: 3, label: 'Dual Purpose' },
      ],
    },
    {
      name: 'quantity',
      type: 'number',
      label: 'Quantity',
      required: true,
      min: 1,
      max: 100000,
    },
    {
      name: 'start_date',
      type: 'date',
      label: 'Start Date',
      required: true,
    },
    {
      name: 'end_date',
      type: 'date',
      label: 'Expected End Date',
    },
    {
      name: 'notes',
      type: 'textarea',
      label: 'Notes',
      placeholder: 'Optional notes about this batch',
      colSpan: 2,
    },
    {
      name: 'is_active',
      type: 'switch',
      label: 'Active',
      default: true,
      colSpan: 2,
    },
  ],
}

const form = useForm({
  name: '',
  breed_id: '',
  quantity: null,
  start_date: '',
  end_date: '',
  notes: '',
  is_active: true,
})

function submit(values: Record<string, unknown>) {
  Object.assign(form, values)
  form.post('/batches')
}
</script>