<template>
  <AppLayout title="Breeds">
    <DataTable
      :schema="schema"
      :pagination="pagination"
      :search-value="filters.search"
      :sort-key="filters.sort"
      :sort-direction="filters.direction"
      route="/breeds"
      search-placeholder="Search breeds..."
      empty-message="No breeds yet. Create your first one!"
    >
      <template #header-actions>
        <Link v-if="can('breeds.create')"
          href="/breeds/create"
          class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors"
        >
          <PlusIcon class="h-4 w-4" />
          New Breed
        </Link>
      </template>
    </DataTable>
  </AppLayout>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import { PlusIcon, PencilIcon, TrashIcon, EyeIcon } from '@heroicons/vue/24/outline'
import AppLayout from '@/layouts/AppLayout.vue'
import DataTable from '@/components/table/DataTable.vue'
import type { TableSchema, Paginated } from '@/types/table'
import { usePermissions } from '@/composables/usePermissions'

interface Breed {
  id: number
  name: string
  code: string | null
  description: string | null
  is_active: boolean
  batches_count: number
  created_at: string
}

const props = defineProps<{
  pagination: Paginated<Breed>
  filters: { search?: string; sort: string; direction: 'asc' | 'desc' }
}>()

const { can } = usePermissions()

const schema: TableSchema<Breed> = {
  rowKey: 'id',
  columns: [
    {
      key: 'name',
      label: 'Name',
      sortable: true,
      format: (v) => v,
    },
    {
      key: 'code',
      label: 'Code',
      sortable: true,
      width: 'w-32',
      format: (v) => v || '—',
    },
    {
      key: 'description',
      label: 'Description',
      mobileHidden: true,
      format: (v) => v?.length > 60 ? v.slice(0, 60) + '…' : (v || '—'),
    },
    {
      key: 'batches_count',
      label: 'Batches',
      align: 'center',
      width: 'w-24',
      format: (v) => v,
    },
    {
      key: 'is_active',
      label: 'Status',
      align: 'center',
      width: 'w-28',
      badge: (v) => ({
        label: v ? 'Active' : 'Inactive',
        variant: v ? 'success' : 'neutral',
      }),
    },
    {
      key: 'created_at',
      label: 'Created',
      sortable: true,
      mobileHidden: true,
      width: 'w-32',
      format: (v) => formatDate(v),
    },
  ],
  actions: [
    {
      label: 'View',
      icon: 'EyeIcon',
      href: (row) => `/breeds/${row.id}`,
      visible: () => can('breeds.view'),
    },
    {
      label: 'Edit',
      icon: 'PencilIcon',
      href: (row) => `/breeds/${row.id}/edit`,
      visible: () => can('breeds.update'),
    },
    {
      label: 'Delete',
      icon: 'TrashIcon',
      variant: 'danger',
      onClick: (row) => confirmDelete(row),
      visible: () => can('breeds.delete'),
    },
  ],
  emptyMessage: 'No breeds found.',
}

function confirmDelete(row: Breed) {
  if (!confirm(`Delete "${row.name}"? This cannot be undone.`)) return
  router.delete(`/breeds/${row.id}`, { preserveScroll: true })
}

function formatDate(iso: string): string {
  return new Date(iso).toLocaleDateString('en-GB', {
    day: '2-digit',
    month: 'short',
    year: 'numeric',
  })
}
</script>