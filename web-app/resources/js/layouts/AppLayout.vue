<template>
  <div class="min-h-screen flex bg-gray-50 dark:bg-gray-900">
    <!-- Sidebar -->
    <Sidebar :is-open="sidebarOpen" @close="sidebarOpen = false" />

    <!-- Main column -->
    <div class="flex-1 flex flex-col min-w-0">
      <Navbar :title="title" @toggle-sidebar="sidebarOpen = !sidebarOpen" />

      <main class="flex-1 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <!-- Flash messages -->
          <div v-if="$page.props.flash?.success"
            class="mb-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 p-3">
            <p class="text-sm text-green-700 dark:text-green-300">
              {{ $page.props.flash.success }}
            </p>
          </div>
          <div v-if="$page.props.flash?.error"
            class="mb-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-3">
            <p class="text-sm text-red-700 dark:text-red-300">
              {{ $page.props.flash.error }}
            </p>
          </div>

          <!-- Page content -->
          <slot />
        </div>
      </main>

      <TFooter />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Sidebar from '@/components/template/Sidebar.vue'
import Navbar from '@/components/template/Navbar.vue'
import TFooter from '@/components/template/TFooter.vue'

defineProps({
  title: { type: String, default: '' },
})

const sidebarOpen = ref(false)
</script>