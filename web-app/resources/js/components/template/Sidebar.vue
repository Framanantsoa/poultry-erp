<template>
  <aside
    class="fixed inset-y-0 left-0 z-40 flex h-screen w-64 flex-col bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transform transition-transform duration-300 lg:sticky lg:top-0 lg:translate-x-0"
    :class="isOpen ? 'translate-x-0' : '-translate-x-full'"
  >
    <!-- Logo -->
    <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200 dark:border-gray-700">
      <Link href="/dashboard" class="flex items-center gap-2">
        <div class="h-8 w-8 rounded-lg bg-blue-200 flex items-center justify-center">
            <img src="/favicon.png" alt="PoultryERP" class="h-8 w-8 object-contain"/>
        </div>
        <span class="text-lg text-gray-900 dark:text-white">
            Poultry<span class="ml-0 font-bold dark:text-blue-200">ERP</span>
        </span>
      </Link>

      <!-- Close button (mobile only) -->
      <button @click="$emit('close')"
        class="lg:hidden p-1.5 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700">
        <XMarkIcon class="h-5 w-5" />
      </button>
    </div>

    <!-- Menu -->
    <nav class="flex-1 overflow-y-auto p-3 space-y-1">
      <MenuItem
        v-for="item in visibleMenu"
        :key="item.label"
        :item="item"
      />
    </nav>

    <!-- Footer info -->
    <div class="p-3 border-t border-gray-200 dark:border-gray-700">
      <p class="text-xs text-gray-500 dark:text-gray-400">v1.0.0</p>
    </div>
  </aside>

  <!-- Mobile overlay -->
  <div v-if="isOpen"
    @click="$emit('close')"
    class="fixed inset-0 z-30 bg-black/50 lg:hidden"
  />
</template>

<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import { HomeIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import MenuItem from '@/components/template/MenuItem.vue'
import menu from '@/menu.json'
import { usePermissions } from '@/composables/usePermissions'

defineProps({
  isOpen: { type: Boolean, default: false },
})

defineEmits(['close'])

const { can } = usePermissions()

/**
 * Recursively filter menu items by permission.
 *  1. Drop items the user can't see.
 *  2. Recurse into children.
 *  3. Keep items with a route OR at least one visible child.
 */
const filterMenu = (items) => {
  return items
    .filter((item) => !item.permission || can(item.permission))
    .map((item) => ({
      ...item,
      children: filterMenu(item.children || []),
    }))
    .filter((item) => item.route || item.children.length > 0)
}

const visibleMenu = computed(() => filterMenu(menu))
</script>
