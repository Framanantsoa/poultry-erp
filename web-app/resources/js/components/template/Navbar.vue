<template>
  <header class="sticky top-0 z-20 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
      <!-- Left: hamburger + page title -->
      <div class="flex items-center gap-3">
        <button @click="$emit('toggle-sidebar')"
          class="lg:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700">
          <Bars3Icon class="h-5 w-5" />
        </button>

        <h1 class="text-lg font-semibold text-gray-900 dark:text-white">
          {{ title }}
        </h1>
      </div>

      <!-- Right: actions + user dropdown -->
      <div class="flex items-center gap-2">
        <!-- User dropdown -->
        <div class="relative" ref="dropdownRef">
          <button @click="isDropdownOpen = !isDropdownOpen"
            class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
            <div class="h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
              <span class="text-blue-600 dark:text-blue-300 font-semibold text-xs">
                {{ userInitials }}
              </span>
            </div>
            <span class="hidden sm:block text-sm font-medium text-gray-700 dark:text-gray-300">
              {{ user?.full_name }}
            </span>
            <ChevronDownIcon class="hidden sm:block h-4 w-4 text-gray-400" />
          </button>

          <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
          >
            <div v-if="isDropdownOpen"
              class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-50">
              <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                  {{ user?.full_name }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                  {{ user?.employee_id }}
                </p>
              </div>

              <Link href="/profile"
                class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <UserIcon class="h-4 w-4" />
                Profile
              </Link>

              <hr class="my-1 border-gray-200 dark:border-gray-700" />

              <button @click="logout"
                class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                <ArrowRightEndOnRectangleIcon class="h-4 w-4" />
                Logout
              </button>
            </div>
          </transition>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import {
  Bars3Icon,
  ChevronDownIcon,
  UserIcon,
  Cog6ToothIcon,
  ArrowRightEndOnRectangleIcon,
} from '@heroicons/vue/24/outline'

defineProps({
  title: { type: String, default: '' },
})

defineEmits(['toggle-sidebar'])

const page = usePage()
const user = computed(() => page.props.auth?.user ?? page.props.user)

const isDropdownOpen = ref(false)
const isDark = ref(false)
const dropdownRef = ref(null)

const userInitials = computed(() => {
  if (!user.value) return '??'
  return `${user.value.first_name?.charAt(0) ?? ''}${user.value.last_name?.charAt(0) ?? ''}`
})

const toggleDarkMode = () => {
  isDark.value = !isDark.value
  document.documentElement.classList.toggle('dark', isDark.value)
  localStorage.setItem('theme', isDark.value ? 'dark' : 'light')
}

const logout = () => {
  router.post('/logout')
}

const handleClickOutside = (e) => {
  if (dropdownRef.value && !dropdownRef.value.contains(e.target)) {
    isDropdownOpen.value = false
  }
}

onMounted(() => {
  // Load theme preference
  const saved = localStorage.getItem('theme')
  isDark.value = saved === 'dark'
    || (!saved && window.matchMedia('(prefers-color-scheme: dark)').matches)
  document.documentElement.classList.toggle('dark', isDark.value)

  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>
