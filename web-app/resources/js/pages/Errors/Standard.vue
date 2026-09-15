<template>
  <AppLayout :title="title">
    <div class="min-h-[60vh] flex items-center justify-center px-4">
      <div class="max-w-md w-full text-center">
        <!-- Icon -->
        <div
          class="mx-auto h-24 w-24 rounded-full flex items-center justify-center mb-6"
          :class="colorClasses.bg"
        >
          <component
            :is="statusIcon"
            class="h-12 w-12"
            :class="colorClasses.icon"
          />
        </div>

        <!-- Status code -->
        <p
          class="text-6xl font-extrabold tracking-tight"
          :class="colorClasses.text"
        >
          {{ status }}
        </p>

        <!-- Title -->
        <h1 class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">
          {{ title }}
        </h1>

        <!-- Message -->
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
          {{ message }}
        </p>

        <!-- Actions -->
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
          <button
            type="button"
            @click="goBack"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors w-full sm:w-auto justify-center"
          >
            <ArrowLeftIcon class="h-4 w-4" />
            Go Back
          </button>

          <Link
            href="/dashboard"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors w-full sm:w-auto justify-center"
          >
            <HomeIcon class="h-4 w-4" />
            Back to Dashboard
          </Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import {
  ArrowLeftIcon,
  HomeIcon,
  ExclamationTriangleIcon,
  ShieldExclamationIcon,
  MagnifyingGlassIcon,
  ServerStackIcon,
  LockClosedIcon,
} from '@heroicons/vue/24/outline'
import AppLayout from '@/layouts/AppLayout.vue'

const props = defineProps<{
  status: number
  message?: string
}>()

const page = usePage()
const isDev = computed(() => import.meta.env.DEV)

const exceptionMessage = computed(() => {
  return (page.props as any)?.exception ?? props.message ?? ''
})

// ─── Content per status ───
const content = computed(() => {
  const map: Record<number, { title: string; message: string; icon: any; color: string }> = {
    401: {
      title: 'Unauthenticated',
      message: 'You need to be logged in to access this page.',
      icon: LockClosedIcon,
      color: 'yellow',
    },
    403: {
      title: 'Access Denied',
      message: 'You do not have permission to access this page. If you believe this is a mistake, contact your administrator.',
      icon: ShieldExclamationIcon,
      color: 'red',
    },
    419: {
      title: 'Page Expired',
      message: 'Your session has expired. Please refresh and try again.',
      icon: ExclamationTriangleIcon,
      color: 'yellow',
    },
    429: {
      title: 'Too Many Requests',
      message: 'You have made too many requests. Please slow down and try again later.',
      icon: ExclamationTriangleIcon,
      color: 'orange',
    },
    500: {
      title: 'Server Error',
      message: 'Something went wrong on our end. Please try again later.',
      icon: ServerStackIcon,
      color: 'red',
    },
    503: {
      title: 'Service Unavailable',
      message: 'The service is temporarily unavailable. Please try again in a few minutes.',
      icon: ServerStackIcon,
      color: 'orange',
    },
  }

  const fallback = {
    title: 'Error',
    message: 'An unexpected error occurred.',
    icon: ExclamationTriangleIcon,
    color: 'gray',
  }

  return map[props.status] ?? fallback
})

const title = computed(() => content.value.title)
const message = computed(() => props.message || content.value.message)
const statusIcon = computed(() => content.value.icon)

const colorClasses = computed(() => {
  const color = content.value.color
  return {
    bg: {
      red: 'bg-red-100 dark:bg-red-900/30',
      yellow: 'bg-yellow-100 dark:bg-yellow-900/30',
      orange: 'bg-orange-100 dark:bg-orange-900/30',
      blue: 'bg-blue-100 dark:bg-blue-900/30',
      gray: 'bg-gray-100 dark:bg-gray-800',
    }[color],
    icon: {
      red: 'text-red-600 dark:text-red-400',
      yellow: 'text-yellow-600 dark:text-yellow-400',
      orange: 'text-orange-600 dark:text-orange-400',
      blue: 'text-blue-600 dark:text-blue-400',
      gray: 'text-gray-600 dark:text-gray-400',
    }[color],
    text: {
      red: 'text-red-600 dark:text-red-400',
      yellow: 'text-yellow-600 dark:text-yellow-400',
      orange: 'text-orange-600 dark:text-orange-400',
      blue: 'text-blue-600 dark:text-blue-400',
      gray: 'text-gray-600 dark:text-gray-400',
    }[color],
  }
})

function goBack() {
  if (window.history.length > 1) {
    window.history.back()
  } else {
    router.visit('/dashboard')
  }
}
</script>
