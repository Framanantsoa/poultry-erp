import type { Component } from 'vue'

export interface ColumnConfig<T = any> {
  /** Key in the row object */
  key: keyof T | string

  /** Column header */
  label: string

  /** Sortable? */
  sortable?: boolean

  /** Text alignment */
  align?: 'left' | 'center' | 'right'

  /** Column width (Tailwind class, e.g. 'w-24', 'w-1/4') */
  width?: string

  /** Show on mobile? */
  mobileHidden?: boolean

  /** Custom formatter — receives row + value, returns string or a component */
  format?: (value: any, row: T) => string | number

  /** Render as a badge with color */
  badge?: (value: any, row: T) => {
    label: string
    variant: 'success' | 'danger' | 'warning' | 'info' | 'neutral'
  }

  /** Render as a component (icon, avatar, etc.) */
  component?: Component
}

export interface RowAction<T = any> {
  label: string
  icon?: string
  href?: (row: T) => string
  onClick?: (row: T) => void
  variant?: 'default' | 'danger'
  /** Hide action based on permission or row state */
  visible?: (row: T) => boolean
}

export interface TableSchema<T = any> {
  columns: ColumnConfig<T>[]
  actions?: RowAction<T>[]
  /** Message shown when no rows */
  emptyMessage?: string
  /** Key to use as unique row id (default: 'id') */
  rowKey?: keyof T
}

export interface PaginationLink {
  url: string | null
  label: string
  active: boolean
}

export interface Paginated<T> {
  data: T[]
  current_page: number
  last_page: number
  per_page: number
  total: number
  from: number | null
  to: number | null
  links: PaginationLink[]
}