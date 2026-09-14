<template>
  <AppLayout title="Dashboard">
    <!-- Welcome -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            Welcome back, {{ user.last_name }}! 👋
          </h1>
          <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Here's what's happening with your poultry farm today.
          </p>
        </div>
        <span class="inline-flex items-center self-start sm:self-auto px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
          <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
          Online
        </span>
      </div>
    </div>

    <!-- Stats grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
      <StatCard
        label="Total Batches"
        :value="stats.batches"
        icon="RectangleGroupIcon"
        color="blue"
      />
      <StatCard
        label="Active Incubations"
        :value="stats.incubations"
        icon="FireIcon"
        color="yellow"
      />
      <StatCard
        label="Eggs Today"
        :value="stats.eggsToday"
        icon="SparklesIcon"
        color="green"
      />
      <StatCard
        label="Mortality Today"
        :value="stats.mortalityToday"
        icon="ExclamationTriangleIcon"
        color="red"
      />
    </div>

    <!-- Bottom grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Recent activity -->
      <div class="lg:col-span-3">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
          <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
            Recent Activity
          </h3>

          <div class="space-y-4">
            <div v-for="activity in activities" :key="activity.id"
              class="flex items-start gap-3 border-b border-gray-100 dark:border-gray-700 pb-4 last:border-0 last:pb-0">
              <div class="flex-shrink-0">
                <div class="h-8 w-8 rounded-full flex items-center justify-center"
                  :class="{
                    'bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-300': activity.type === 'login',
                    'bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-300': activity.type === 'create',
                    'bg-yellow-100 text-yellow-600 dark:bg-yellow-900 dark:text-yellow-300': activity.type === 'update',
                    'bg-red-100 text-red-600 dark:bg-red-900 dark:text-red-300': activity.type === 'delete',
                  }">
                  <component :is="getActivityIcon(activity.type)" class="h-4 w-4" />
                </div>
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-sm text-gray-900 dark:text-white">
                  {{ activity.message }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                  {{ activity.time }}
                </p>
              </div>
            </div>
          </div>

          <div class="mt-6 text-center">
            <Link href="/logs"
              class="text-sm text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
              View all activity →
            </Link>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { computed } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import {
  UserIcon,
  Cog6ToothIcon,
  ArrowRightEndOnRectangleIcon,
} from '@heroicons/vue/24/outline'
import AppLayout from '@/layouts/AppLayout.vue'
import StatCard from '@/components/template/StatCard.vue'

const page = usePage()
const user = computed(() => page.props.user)

const userInitials = computed(() => {
  if (!user.value) return '??'
  return `${user.value.first_name?.charAt(0) ?? ''}${user.value.last_name?.charAt(0) ?? ''}`
})

// Static data (later: from controller)
const stats = {
  batches: 12,
  incubations: 3,
  eggsToday: 1450,
  mortalityToday: 4,
}

const activities = [
  { id: 1, type: 'login',  message: 'You logged in from Antananarivo, MG', time: '2 minutes ago' },
  { id: 2, type: 'create', message: 'New batch created: B-2026-012',       time: '1 hour ago' },
  { id: 3, type: 'update', message: 'Egg production updated for B-2026-009', time: '3 hours ago' },
  { id: 4, type: 'login',  message: 'You logged in from Antananarivo, MG', time: 'Yesterday at 9:30 AM' },
  { id: 5, type: 'create',  message: 'New weight tracking created : W-2026-021', time: 'Yesterday at 8:30 AM' },
]

const getActivityIcon = (type) => ({
  login: UserIcon,
  create: Cog6ToothIcon,
  update: Cog6ToothIcon,
  delete: ArrowRightEndOnRectangleIcon,
}[type] ?? UserIcon)

const goToProfile = () => router.visit('/profile')
</script>
