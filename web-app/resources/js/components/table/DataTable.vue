<template>
  <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
    <!-- Header: search + create button -->
    <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
      <div class="relative w-full sm:max-w-xs">
        <MagnifyingGlassIcon class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
        <input
          v-model="search"
          type="search"
          :placeholder="searchPlaceholder"
          class="w-full pl-9 pr-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
          @input="debouncedSearch"
        />
      </div>

      <slot name="header-actions" />
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-700">
          <tr>
            <th
              v-for="col in schema.columns"
              :key="String(col.key)"
              :class="[
                'px-4 py-3 text-xs font-semibold uppercase tracking-wide text-gray-600 dark:text-gray-400',
                col.align === 'right' ? 'text-right' : col.align === 'center' ? 'text-center' : 'text-left',
                col.width ?? '',
                col.mobileHidden ? 'hidden md:table-cell' : '',
                col.sortable ? 'cursor-pointer select-none hover:text-gray-900 dark:hover:text-gray-200' : '',
              ]"
              @click="col.sortable && toggleSort(String(col.key))"
            >
              <span class="inline-flex items-center gap-1">
                {{ col.label }}
                <component
                  v-if="col.sortable"
                  :is="sortIcon(String(col.key))"
                  class="h-3.5 w-3.5"
                />
              </span>
            </th>
            <th
              v-if="schema.actions?.length"
              class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-600 dark:text-gray-400"
            >
              Actions
            </th>
          </tr>
        </thead>

        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
          <!-- Loading skeleton -->
          <tr v-if="loading" v-for="n in 5" :key="`skeleton-${n}`">
            <td :colspan="totalCols" class="px-4 py-4">
              <div class="h-4 bg-gray-100 dark:bg-gray-700 rounded animate-pulse" />
            </td>
          </tr>

          <!-- Empty state -->
          <tr v-else-if="!pagination.data.length">
            <td :colspan="totalCols" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">
              <div class="flex flex-col items-center gap-2">
                <InboxIcon class="h-10 w-10 text-gray-300 dark:text-gray-600" />
                <p>{{ schema.emptyMessage ?? 'No records found.' }}</p>
              </div>
            </td>
          </tr>

          <!-- Rows -->
          <tr
            v-else
            v-for="row in pagination.data"
            :key="String(row[schema.rowKey ?? 'id'])"
            class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors"
          >
            <td
              v-for="col in schema.columns"
              :key="String(col.key)"
              :class="[
                'px-4 py-3 text-gray-700 dark:text-gray-300',
                col.align === 'right' ? 'text-right' : col.align === 'center' ? 'text-center' : 'text-left',
                col.mobileHidden ? 'hidden md:table-cell' : '',
              ]"
            >
              <!-- Badge -->
              <span
                v-if="col.badge"
                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"
                :class="badgeClasses(col.badge(row[col.key], row).variant)"
              >
                {{ col.badge(row[col.key], row).label }}
              </span>

              <!-- Component -->
              <component
                v-else-if="col.component"
                :is="col.component"
                :value="row[col.key]"
                :row="row"
              />

              <!-- Formatter -->
              <span v-else-if="col.format">
                {{ col.format(row[col.key], row) }}
              </span>

              <!-- Plain value -->
              <span v-else>
                {{ row[col.key] ?? '—' }}
              </span>
            </td>

            <!-- Actions -->
            <td v-if="schema.actions?.length" class="px-4 py-3 text-right">
              <div class="flex items-center justify-end gap-1">
                <template v-for="action in schema.actions" :key="action.label">
                  <template v-if="!action.visible || action.visible(row)">
                    <Link
                      v-if="action.href"
                      :href="action.href(row)"
                      class="p-2 rounded-lg transition-colors"
                      :class="action.variant === 'danger'
                        ? 'text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20'
                        : 'text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700'"
                      :title="action.label"
                    >
                      <component :is="getIcon(action.icon)" class="h-4 w-4" />
                    </Link>
                    <button
                      v-else
                      type="button"
                      @click="action.onClick?.(row)"
                      class="p-2 rounded-lg transition-colors"
                      :class="action.variant === 'danger'
                        ? 'text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20'
                        : 'text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700'"
                      :title="action.label"
                    >
                      <component :is="getIcon(action.icon)" class="h-4 w-4" />
                    </button>
                  </template>
                </template>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div
      v-if="pagination.data.length && pagination.last_page > 1"
      class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3"
    >
      <p class="text-sm text-gray-600 dark:text-gray-400">
        Showing
        <span class="font-medium text-gray-900 dark:text-white">{{ pagination.from }}</span>
        to
        <span class="font-medium text-gray-900 dark:text-white">{{ pagination.to }}</span>
        of
        <span class="font-medium text-gray-900 dark:text-white">{{ pagination.total }}</span>
        results
      </p>

      <nav class="flex items-center gap-1">
        <Link
          v-for="link in pagination.links"
          :key="link.label"
          :href="link.url ?? '#'"
          preserve-scroll
          preserve-state
          class="px-3 py-1.5 text-sm rounded-lg border transition-colors"
          :class="[
            link.active
              ? 'bg-blue-600 border-blue-600 text-white'
              : link.url
                ? 'bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'
                : 'bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 text-gray-400 cursor-not-allowed',
          ]"
          v-html="link.label"
        />
      </nav>
    </div>
  </div>
</template>

<script setup lang="ts" generic="T extends Record<string, any>">
import { ref, computed, watch } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import {
  MagnifyingGlassIcon,
  InboxIcon,
  ChevronUpIcon,
  ChevronDownIcon,
  ChevronUpDownIcon,
} from '@heroicons/vue/24/outline'
import * as HeroIcons from '@heroicons/vue/24/outline'
import type { TableSchema, Paginated } from '@/types/table'

const props = defineProps<{
  schema: TableSchema<T>
  pagination: Paginated<T>
  searchPlaceholder?: string
  searchValue?: string
  sortKey?: string
  sortDirection?: 'asc' | 'desc'
  loading?: boolean
  /** Base route for Inertia navigation (e.g. '/breeds') */
  route?: string
}>()

const search = ref(props.searchValue ?? '')

const totalCols = computed(
  () => props.schema.columns.length + (props.schema.actions?.length ? 1 : 0),
)

// ─── Search (debounced) ───
let searchTimer: ReturnType<typeof setTimeout>
function debouncedSearch() {
  clearTimeout(searchTimer)
  searchTimer = setTimeout(() => {
    router.get(
      props.route ?? window.location.pathname,
      { search: search.value, sort: props.sortKey, direction: props.sortDirection },
      { preserveState: true, preserveScroll: true, replace: true },
    )
  }, 300)
}

// ─── Sort ───
function toggleSort(key: string) {
  const direction =
    props.sortKey === key && props.sortDirection === 'asc' ? 'desc' : 'asc'

  router.get(
    props.route ?? window.location.pathname,
    { search: search.value, sort: key, direction },
    { preserveState: true, preserveScroll: true, replace: true },
  )
}

function sortIcon(key: string) {
  if (props.sortKey !== key) return ChevronUpDownIcon
  return props.sortDirection === 'asc' ? ChevronUpIcon : ChevronDownIcon
}

// ─── Helpers ───
function getIcon(name?: string) {
  if (!name) return HeroIcons.EllipsisHorizontalIcon
  return (HeroIcons as Record<string, any>)[name] ?? HeroIcons.EllipsisHorizontalIcon
}

function badgeClasses(variant: string): string {
  return {
    success: 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300',
    danger: 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300',
    warning: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300',
    info: 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300',
    neutral: 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
  }[variant] ?? ''
}

// Sync when parent changes sort/search via URL
watch(() => props.searchValue, (v) => { search.value = v ?? '' })
</script>
