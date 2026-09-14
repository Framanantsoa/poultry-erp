<template>
  <!-- Parent with children: collapsible -->
  <div v-if="item.children?.length">
    <button
      type="button"
      @click="open = !open"
      class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
      :class="hasActiveChild ? 'text-blue-600 dark:text-blue-400' : ''"
    >
      <span class="flex items-center gap-3">
        <component :is="getIcon(item.icon)" class="h-5 w-5 flex-shrink-0" />
        {{ item.label }}
      </span>
      <ChevronDownIcon
        class="h-4 w-4 transition-transform duration-200"
        :class="{ 'rotate-180': open }"
      />
    </button>

    <div v-show="open"
      class="mt-1 ml-4 space-y-1 border-l border-gray-200 dark:border-gray-700 pl-2">
      <MenuItem
        v-for="child in item.children"
        :key="child.label"
        :item="child"
      />
    </div>
  </div>

  <!-- Leaf item: link (no children) -->
  <Link
    v-else-if="item.route"
    :href="item.route"
    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors"
    :class="isActive
      ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400'
      : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'"
  >
    <component :is="getIcon(item.icon)" class="h-5 w-5 flex-shrink-0" />
    {{ item.label }}
  </Link>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { ChevronDownIcon } from '@heroicons/vue/24/outline'
import * as HeroIcons from '@heroicons/vue/24/outline'

const props = defineProps({
  item: { type: Object, required: true },
})

const page = usePage()
const open = ref(false)

const getIcon = (name) => {
  if (!name) return HeroIcons.QuestionMarkCircleIcon
  return HeroIcons[name] ?? HeroIcons.QuestionMarkCircleIcon
}

/**
 * Current URL from Inertia (SSR-safe).
 * Strips query string for cleaner matching.
 */
const currentUrl = computed(() => (page.url || '').split('?')[0])

/**
 * Match exact URL or nested path.
 */
const matches = (url) => {
  if (!url) return false
  if (currentUrl.value === url) return true
  return currentUrl.value.startsWith(url + '/')
}

const isActive = computed(() => matches(props.item.route))

const hasActiveChild = computed(() => {
  const check = (item) => {
    if (matches(item.route)) return true
    return item.children?.some(check) ?? false
  }
  return check(props.item)
})

onMounted(() => {
  if (hasActiveChild.value) open.value = true
})

watch(currentUrl, () => {
  if (hasActiveChild.value) open.value = true
})
</script>