<template>
  <button :type="type" :disabled="loading || disabled"
    :class="[
      'w-full flex items-center justify-center gap-2 px-6 py-3.5 rounded-lg font-medium transition-all duration-200',
      variant === 'primary' && 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800',
      variant === 'secondary' && 'bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600',
      variant === 'success' && 'bg-green-600 hover:bg-green-700 text-white focus:ring-4 focus:ring-green-300 dark:focus:ring-green-800',
      variant === 'danger' && 'bg-red-600 hover:bg-red-700 text-white focus:ring-4 focus:ring-red-300 dark:focus:ring-red-800',
      variant === 'outline' && 'border-2 border-blue-600 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-950 dark:text-blue-400 dark:border-blue-400',
      (loading || disabled) && 'opacity-60 cursor-not-allowed',
      fullWidth ? 'w-full' : 'w-auto',
      size === 'sm' && 'px-4 py-2 text-sm',
      size === 'lg' && 'px-8 py-4 text-lg'
    ]"
    @click="handleClick"
  >
    <!-- Spinner -->
    <svg v-if="loading" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
    </svg>
    
    <slot v-else name="icon" />
    
    <span><slot>Submit</slot></span>
  </button>
</template>

<script setup>
    const props = defineProps({
        type: {
            type: String, default: 'submit'
        },
        variant: {
            type: String, default: 'primary'
        },
        size: {
            type: String, default: 'md'
        },
        loading: {
            type: Boolean, default: false
        },
        disabled: {
            type: Boolean, default: false
        },
        fullWidth: {
            type: Boolean, default: true
        },
        className: {
            type: String, default: ''
        }
    })

    const emit = defineEmits(['click'])

    const handleClick = (event) => {
        if (!props.loading && !props.disabled) {
            emit('click', event)
        }
    }
</script>