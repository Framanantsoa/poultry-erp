<template>
  <AppLayout title="Create Breed">
    <div class="max-w-3xl mx-auto">
      <!-- Header -->
      <div class="mb-6">
        <Link
          href="/breeds"
          class="inline-flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors"
        >
          <ArrowLeftIcon class="h-4 w-4" />
          Back to Breeds
        </Link>

        <h1 class="mt-3 text-2xl font-bold text-gray-900 dark:text-white">
          New Breed
        </h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
          Add a new poultry breed to your farm. It can be assigned to batches.
        </p>
      </div>

      <!-- Global error -->
      <div v-if="form.errors && Object.keys(form.errors).length"
        class="mb-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-3"
      >
        <p class="text-sm text-red-700 dark:text-red-300">
          Please fix the errors below before submitting.
        </p>
      </div>

      <!-- Form card -->
      <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <FormGenerator
          :schema="schema"
          v-model="form"
          :errors="form.errors"
          :processing="form.processing"
          @submit="submit"
        />
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3'
import { ArrowLeftIcon } from '@heroicons/vue/24/outline'
import AppLayout from '@/layouts/AppLayout.vue'
import FormGenerator from '@/components/form/FormGenerator.vue'
import type { FormSchema } from '@/types/form'

interface BreedFormData {
  name: string
  chick_cost: number | null
  description: string
}

const form = useForm<BreedFormData>({
  name: '',
  chick_cost: null,
  description: '',
})

const schema: FormSchema = {
  columns: 1,
  submitLabel: 'Create Breed',
  cancelLabel: 'Cancel',
  cancelHref: '/breeds',
  fields: [
    {
      name: 'name',
      type: 'text',
      label: 'Breed Name',
      placeholder: 'e.g., Broiler, Layer, Dual Purpose',
      required: true,
      maxlength: 100,
    },
    {
      name: 'chick_cost',
      type: 'number',
      label: 'Chick Cost (per unit)',
      placeholder: '0.00',
      required: true,
      min: 0,
      max: 999999.99,
      step: 0.01,
      icon: 'CurrencyDollarIcon',
      helper: 'Cost of one chick in your local currency.',
    },
    {
      name: 'description',
      type: 'textarea',
      label: 'Description',
      placeholder: 'Optional notes about this breed (growth rate, purpose, etc.)',
      maxlength: 1000,
    },
  ],
}

function submit(values: Record<string, unknown>) {
  Object.assign(form, values)
  form.post('/breeds')
}
</script>