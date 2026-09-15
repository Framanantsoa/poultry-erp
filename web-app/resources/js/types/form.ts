export type FieldType =
  | 'text'
  | 'email'
  | 'password'
  | 'number'
  | 'tel'
  | 'date'
  | 'datetime'
  | 'time'
  | 'textarea'
  | 'select'
  | 'checkbox'
  | 'radio'
  | 'switch'
  | 'file'

export interface SelectOption {
  value: string | number
  label: string
  disabled?: boolean
}

export interface FieldConfig {
  /** Field name — must match the backend validation key */
  name: string

  /** Input type */
  type: FieldType

  /** Human-readable label (used as floating label / placeholder) */
  label: string

  /** Placeholder text */
  placeholder?: string

  /** Helper text shown below the field */
  helper?: string

  /** Default value */
  default?: string | number | boolean | null

  /** Required field */
  required?: boolean

  /** Disabled state */
  disabled?: boolean

  /** Readonly state */
  readonly?: boolean

  /** Options for select/radio */
  options?: SelectOption[]

  /** For number inputs */
  min?: number
  max?: number
  step?: number

  /** For text inputs */
  maxlength?: number
  minlength?: number

  /** Autocomplete hint */
  autocomplete?: string

  /** Heroicon name (e.g., "EnvelopeIcon") */
  icon?: string

  /** Grid span: 1 (default) or 2 (full width in a 2-col grid) */
  colSpan?: 1 | 2

  /** Custom validation (client-side, optional) */
  validate?: (value: unknown) => string | null
}

export interface FormSchema {
  /** All fields */
  fields: FieldConfig[]

  /** Submit button label */
  submitLabel?: string

  /** Submit button variant */
  submitVariant?: 'primary' | 'success' | 'danger'

  /** Cancel button (optional) */
  cancelLabel?: string
  cancelHref?: string

  /** Layout: 1 or 2 column grid */
  columns?: 1 | 2
}
