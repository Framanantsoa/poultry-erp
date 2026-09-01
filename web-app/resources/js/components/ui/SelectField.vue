<template>
  <div class="relative w-full">
    <select :id="id" :value="modelValue"
      :required="required" :disabled="disabled"
      :class="[
        'w-full px-4 py-3.5 text-gray-900 dark:text-white bg-transparent border rounded-lg focus:outline-none focus:ring-2 transition-all duration-200 peer appearance-none',
        error ? 'border-red-500 focus:ring-red-500' : 
        'border-gray-300 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500',
        disabled && 'opacity-60 cursor-not-allowed bg-gray-100 dark:bg-gray-700'
      ]"
      @change="handleChange"
      @blur="handleBlur"
      @focus="handleFocus"
    >
      <option v-if="placeholder" value="" disabled class="text-gray-400">
        {{ placeholder }}
      </option>
      <option v-for="option in options" :key="option.value" :value="option.value"
        :disabled="option.disabled"
      >
        {{ option.label }}
      </option>
    </select>
    
    <label :for="id" :class="[
      'absolute left-3 transition-all duration-200 pointer-events-none',
      'px-1 bg-white dark:bg-gray-800',
      (modelValue || isFocused) 
        ? 'text-xs -translate-y-3.5 -translate-x-1 scale-90' 
        : 'text-gray-500 dark:text-gray-400 translate-y-3',
      error && (modelValue || isFocused) ? 'text-red-500' : '',
      error && !modelValue && !isFocused ? 'text-red-500' : '',
      isFocused && !error ? 'text-blue-500' : ''
    ]">
      {{ label }}
      <span v-if="required" class="text-red-500 ml-0.5">*</span>
    </label>
    
    <!-- Dropdown arrow icon -->
    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"
      :class="[
        isFocused && !error ? 'text-blue-500' : '',
        error ? 'text-red-500' : 'text-gray-400 dark:text-gray-500'
      ]"
    >
      <svg class="w-5 h-5 transition-transform duration-200" :class="{ 'rotate-180': isFocused }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
      </svg>
    </div>
    
    <!-- Error message -->
    <p v-if="error" class="mt-1 text-sm text-red-500">{{ error }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue'

    const props = defineProps({
        modelValue: {
            type: [String, Number], default: ''
        },
        id: {
            type: String, required: true
        },
        label: {
            type: String, required: true
        },
        options: {
            type: Array, required: true
        },
        placeholder: {
            type: String, default: ''
        },
        required: {
            type: Boolean, default: false
        },
        disabled: {
            type: Boolean, default: false
        },
        error: {
            type: String, default: ''
        }
    })

    const emit = defineEmits(['update:modelValue', 'blur', 'focus'])

    const isFocused = ref(false)

    const handleChange = (event) => {
        emit('update:modelValue', event.target.value)
    }

    const handleBlur = (event) => {
        isFocused.value = false
        emit('blur', event)
    }

    const handleFocus = (event) => {
        isFocused.value = true
        emit('focus', event)
    }
</script>