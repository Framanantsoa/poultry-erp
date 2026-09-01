<template>
  <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Navigation / Header -->
    <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <div class="flex-shrink-0 flex items-center">
              <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              </svg>
              <span class="ml-2 text-xl font-bold text-gray-900 dark:text-white">Poultry ERP</span>
            </div>
          </div>
          
          <div class="flex items-center space-x-4">
            <!-- User dropdown -->
            <div class="relative">
              <button @click="isDropdownOpen = !isDropdownOpen" 
                class="flex items-center space-x-3 focus:outline-none">
                <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                  <span class="text-blue-600 dark:text-blue-300 font-semibold text-sm">
                    {{ userInitials }}
                  </span>
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 hidden sm:block">
                  {{ user.full_name }}
                </span>
                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </button>
              
              <!-- Dropdown menu -->
              <div v-if="isDropdownOpen" 
                class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-50">
                <Link href="/profile" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                  <UserIcon class="h-4 w-4 mr-2" />
                  Profile
                </Link>
                <Link href="/settings" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                  <CogIcon class="h-4 w-4 mr-2" />
                  Settings
                </Link>
                <hr class="my-1 border-gray-200 dark:border-gray-700">
                <button @click="logout" class="flex items-center w-full px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                  <ArrowRightOnRectangleIcon class="h-4 w-4 mr-2" />
                  Logout
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Welcome back, {{ user.first_name }}! 👋
              </h1>
              <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Here's what's happening with your poultry farm today.
              </p>
            </div>
            <div class="hidden sm:block">
              <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                Online
              </span>
            </div>
          </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
          <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
              <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                <svg class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
              </div>
              <div class="ml-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">Total Employees</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.employees }}</p>
              </div>
            </div>
          </div>

          <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
              <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                <svg class="h-6 w-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">Active Orders</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.orders }}</p>
              </div>
            </div>
          </div>

          <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
              <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
              </div>
              <div class="ml-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">Inventory Items</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.inventory }}</p>
              </div>
            </div>
          </div>

          <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
              <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-lg">
                <svg class="h-6 w-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">Tasks Completed</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.completed }}</p>
              </div>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- User Profile Card -->
          <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
              <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-24"></div>
              <div class="px-6 pb-6">
                <div class="flex justify-center -mt-12">
                  <div class="h-24 w-24 rounded-full bg-white dark:bg-gray-800 border-4 border-white dark:border-gray-800 flex items-center justify-center">
                    <span class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                      {{ userInitials }}
                    </span>
                  </div>
                </div>
                
                <div class="text-center mt-4">
                  <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                    {{ user.full_name }}
                  </h3>
                  <p class="text-sm text-gray-600 dark:text-gray-400">
                    Employee #{{ user.employee_id }}
                  </p>
                </div>

                <div class="mt-6 space-y-3">
                  <div class="flex items-center text-sm">
                    <EnvelopeIcon class="h-5 w-5 text-gray-400 mr-3" />
                    <span class="text-gray-700 dark:text-gray-300">{{ user.email || 'Not provided' }}</span>
                  </div>
                </div>

                <div class="mt-6 space-y-2">
                  <button @click="goToProfile" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    View Profile
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Recent Activity -->
          <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
              <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                Recent Activity
              </h3>
              
              <div class="space-y-4">
                <div v-for="activity in activities" :key="activity.id" 
                  class="flex items-start space-x-3 border-b border-gray-100 dark:border-gray-700 pb-4 last:border-0 last:pb-0">
                  <div class="flex-shrink-0">
                    <div class="h-8 w-8 rounded-full flex items-center justify-center"
                      :class="{
                        'bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-300': activity.type === 'login',
                        'bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-300': activity.type === 'create',
                        'bg-yellow-100 text-yellow-600 dark:bg-yellow-900 dark:text-yellow-300': activity.type === 'update',
                        'bg-red-100 text-red-600 dark:bg-red-900 dark:text-red-300': activity.type === 'delete'
                      }"
                    >
                      <component :is="getActivityIcon(activity.type)" class="h-4 w-4" />
                    </div>
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-900 dark:text-white">
                      {{ activity.message }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                      {{ activity.time }}
                    </p>
                  </div>
                </div>
              </div>

              <div class="mt-6 text-center">
                <Link href="/activities" class="text-sm text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                  View all activity →
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'
import {
  UserIcon,
  CogIcon,
  ArrowRightOnRectangleIcon,
  EnvelopeIcon
} from '@heroicons/vue/24/outline'

const page = usePage()
const user = computed(() => page.props.user)

const isDropdownOpen = ref(false)

// Stats data (example - replace with real data from your backend)
const stats = ref({
  employees: 42,
  orders: 128,
  inventory: 356,
  completed: 89
})

// Recent activities (example - replace with real data)
const activities = ref([
  {
    id: 1,
    type: 'login',
    message: 'You logged in from Paris, France',
    time: '2 minutes ago'
  },
  {
    id: 2,
    type: 'create',
    message: 'You added a new product: Organic Feed',
    time: '1 hour ago'
  },
  {
    id: 3,
    type: 'update',
    message: 'You updated employee details for Jane Smith',
    time: '3 hours ago'
  },
  {
    id: 4,
    type: 'login',
    message: 'You logged in from London, UK',
    time: 'Yesterday at 9:30 AM'
  }
])

// Computed
const userInitials = computed(() => {
  if (!user.value) return '??'
  return `${user.value.first_name?.charAt(0) || ''}${user.value.last_name?.charAt(0) || ''}`
})

// Methods
const getActivityIcon = (type) => {
  const icons = {
    login: UserIcon,
    create: CogIcon,
    update: CogIcon,
    delete: ArrowRightOnRectangleIcon
  }
  return icons[type] || UserIcon
}

const goToProfile = () => {
  router.visit('/profile')
}

const logout = () => {
  router.post('/logout', {}, {
    onSuccess: () => {
      isDropdownOpen.value = false
    }
  })
}

// Close dropdown when clicking outside
const handleClickOutside = (event) => {
  if (isDropdownOpen.value && !event.target.closest('.relative')) {
    isDropdownOpen.value = false
  }
}

// Add click outside listener
if (typeof window !== 'undefined') {
  document.addEventListener('click', handleClickOutside)
}
</script>

<style scoped>
/* Smooth transitions */
.transition-all {
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 150ms;
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 6px;
  height: 6px;
}

::-webkit-scrollbar-track {
  background: transparent;
}

::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 3px;
}

.dark ::-webkit-scrollbar-thumb {
  background: #475569;
}

::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}

.dark ::-webkit-scrollbar-thumb:hover {
  background: #64748b;
}
</style>