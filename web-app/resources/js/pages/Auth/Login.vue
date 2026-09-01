<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 px-4 py-12 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
      <!-- Logo / Header -->
      <div class="text-center">
        <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900">
          <LockClosedIcon class="h-6 w-6 text-blue-600 dark:text-blue-300" />
        </div>
        <h2 class="mt-6 text-3xl font-bold text-gray-900 dark:text-white">
          Welcome Back
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
          Sign in to your account to continue
        </p>
      </div>

      <!-- Status Messages -->
      <div v-if="page.props.flash?.success" 
        class="rounded-lg bg-green-50 dark:bg-green-900/20 p-3 border border-green-200 dark:border-green-800">
        <p class="text-sm text-green-600 dark:text-green-400">
          {{ page.props.flash.success }}
        </p>
      </div>

      <div v-if="page.props.flash?.error" 
        class="rounded-lg bg-red-50 dark:bg-red-900/20 p-3 border border-red-200 dark:border-red-800">
        <p class="text-sm text-red-600 dark:text-red-400">
          {{ page.props.flash.error }}
        </p>
      </div>

      <!-- Login Form -->
      <form class="mt-8 space-y-6" @submit.prevent="submit">
        <div class="space-y-4">
          <!-- Employee ID -->
          <FloatingInput v-model="form.employee_id"
            id="employee_id" label="Employee ID" type="text"
            :error="form.errors.employee_id"
            autocomplete="username"
            :required="true"
          />

          <!-- Password -->
          <FloatingInput v-model="form.password"
            id="password" label="Password" type="password"
            :error="form.errors.password"
            autocomplete="current-password"
            :required="true"
          />
        </div>

        <!-- Submit Button -->
        <SubmitBtn type="submit" variant="primary"
          :loading="form.processing" :disabled="false"
        >
          <template #icon>
            <ArrowRightEndOnRectangleIcon class="h-5 w-5" />
          </template>
          Sign In
        </SubmitBtn>
      </form>

      <!-- Demo Credentials (remove in production) -->
      <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
        <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Demo Credentials:</p>
        <code class="text-xs text-gray-700 dark:text-gray-300">
          Employee ID: EMP001<br>
          Password: password123
        </code>
        <button type="button" @click="fillDemoCredentials" 
          class="mt-2 text-xs text-blue-600 hover:text-blue-500 dark:text-blue-400">
          Click to auto-fill
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3'
import { LockClosedIcon, ArrowRightEndOnRectangleIcon } from '@heroicons/vue/24/outline'
import SubmitBtn from '@/components/ui/SubmitBtn.vue'
import FloatingInput from '@/components/ui/FloatingInput.vue'

const page = usePage()

const props = defineProps({
  canResetPassword: {
    type: Boolean,
    default: false
  },
  status: {
    type: String,
    default: null
  }
})

const form = useForm({
  employee_id: '',
  password: ''
})

const submit = () => {
  form.post('/login', {
    onSuccess: () => {
      // The redirect will happen automatically via Inertia
      console.log('Login successful!')
    },
    onError: (errors) => {
      // console.error('Login failed:', errors)
    },
    preserveState: true,
    preserveScroll: true
  })
}

// Demo credentials - remove in production
const fillDemoCredentials = () => {
  form.employee_id = 'EMP001'
  form.password = 'password123'
}
</script>