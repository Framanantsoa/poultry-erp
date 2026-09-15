<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 px-4">
    <div class="max-w-md w-full text-center">
      <!-- Big number -->
      <p class="text-8xl sm:text-9xl font-black text-blue-600 dark:text-blue-400 leading-none">
        404
      </p>

      <!-- Icon -->
      <div class="mt-6 mx-auto h-16 w-16 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
        <MagnifyingGlassIcon class="h-8 w-8 text-blue-600 dark:text-blue-400" />
      </div>

      <!-- Title -->
      <h1 class="mt-6 text-2xl font-bold text-gray-900 dark:text-white">
        Page Not Found
      </h1>

      <!-- Message -->
      <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
        Oops! The page you're looking for doesn't exist or has been moved.
      </p>

      <!-- Actions -->
      <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
        <button
          type="button"
          @click="goBack"
          class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors w-full sm:w-auto justify-center"
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
</template>

<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3'
import { MagnifyingGlassIcon, HomeIcon, ArrowLeftIcon } from '@heroicons/vue/24/outline'

function goBack() {
  if (window.history.length > 1) {
    window.history.back()
  } else {
    router.visit('/dashboard')
  }
}
</script>