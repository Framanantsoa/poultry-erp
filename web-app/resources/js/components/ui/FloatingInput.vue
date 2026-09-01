<template>
  <div class="relative w-full">
    <input :id="id" :type="type" :value="modelValue"
      :disabled="disabled"
      :class="[
        'w-full px-4 py-3.5 text-gray-900 dark:text-white bg-transparent border rounded-lg focus:outline-none focus:ring-2 transition-all duration-200 peer',
        error ? 'border-red-500 focus:ring-red-500' : 
        'border-gray-300 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500',
        disabled && 'opacity-60 cursor-not-allowed bg-gray-100 dark:bg-gray-700'
      ]"
      :placeholder="' '"
      @input="handleInput"
      @blur="handleBlur"
      @focus="handleFocus"
    />
    
    <label :for="id" :class="[
      'absolute left-3 transition-all duration-200 pointer-events-none',
      'px-1 bg-white dark:bg-gray-800',
      (modelValue || isFocused) 
        ? 'text-xs -translate-y-3.5 -translate-x-1 scale-90' 
        : 'text-gray-500 dark:text-gray-400 translate-y-3',
      error && (modelValue || isFocused) ? 'text-red-500' : '',
      error && !modelValue && !isFocused ? 'text-red-500' : '',
      isFocused && !error ? 'text-blue-500' : ''
    ]" >
      {{ label }}
      <span v-if="required" class="text-red-500 ml-0.5">*</span>
    </label>
    
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
        type: {
            type: String, default: 'text'
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

    const handleInput = (event) => {
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
