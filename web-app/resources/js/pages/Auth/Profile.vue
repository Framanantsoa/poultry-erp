<template>
  <AppLayout title="My Profile">
    <!-- Header banner -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
      <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-32"></div>
      <div class="px-6 pb-6">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between -mt-16 gap-4">
          <div class="flex items-end gap-4">
            <div class="h-28 w-28 rounded-full bg-white dark:bg-gray-800 border-4 border-white dark:border-gray-800 flex items-center justify-center flex-shrink-0">
              <span class="text-4xl font-bold text-blue-600 dark:text-blue-400">
                {{ initials }}
              </span>
            </div>
            <div class="pb-2">
              <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ profile.full_name }}
              </h1>
              <p class="text-sm text-gray-600 dark:text-gray-400">
                Employee #{{ profile.employee_id }}
              </p>
            </div>
          </div>

          <!-- <div class="flex gap-2 pb-2">
            <button class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
              <PencilSquareIcon class="h-4 w-4" />
              Edit
            </button>
            <button class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors">
              <KeyIcon class="h-4 w-4" />
              Change Password
            </button>
          </div> -->
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Left column: personal info -->
      <div class="lg:col-span-2 space-y-6">
        <!-- Personal Information -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
          <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
            <UserIcon class="h-5 w-5 text-blue-600 dark:text-blue-400" />
            Personal Information
          </h2>

          <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">First Name</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ profile.first_name }}</dd>
            </div>
            <div>
              <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Last Name</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ profile.last_name }}</dd>
            </div>
            <div>
              <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Employee ID</dt>
              <dd class="mt-1 text-sm font-mono text-gray-900 dark:text-white">{{ profile.employee_id }}</dd>
            </div>
            <div>
              <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Birthday</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                {{ profile.birthday ? formatDate(profile.birthday) : 'Not provided' }}
              </dd>
            </div>
            <div class="sm:col-span-2">
              <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Email</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white flex items-center gap-2">
                <EnvelopeIcon class="h-4 w-4 text-gray-400" />
                {{ profile.email || 'Not provided' }}
              </dd>
            </div>
            <div class="sm:col-span-2">
              <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Phone</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white flex items-center gap-2">
                <PhoneIcon class="h-4 w-4 text-gray-400" />
                {{ profile.phone }}
              </dd>
            </div>
          </dl>
        </div>

        <!-- Permissions -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
          <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
            <KeyIcon class="h-5 w-5 text-blue-600 dark:text-blue-400" />
            Permissions
            <span class="ml-auto text-xs font-normal text-gray-500 dark:text-gray-400">
              {{ profile.permissions.length }} total
            </span>
          </h2>

          <div class="flex flex-wrap gap-1.5">
            <span v-for="perm in profile.permissions" :key="perm"
              class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-mono bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
              {{ perm }}
            </span>
          </div>

          <p v-if="profile.permissions.length === 0" class="text-sm text-gray-500 dark:text-gray-400 italic">
            No permissions assigned.
          </p>
        </div>
      </div>

      <!-- Right column -->
      <div class="space-y-6">
        <!-- Roles -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
          <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
            <ShieldCheckIcon class="h-5 w-5 text-blue-600 dark:text-blue-400" />
            Roles
          </h2>

          <div class="space-y-2">
            <div v-for="role in profile.roles" :key="role"
              class="flex items-center gap-2 px-3 py-2 rounded-lg bg-blue-50 dark:bg-blue-900/30 border border-blue-100 dark:border-blue-800">
              <ShieldCheckIcon class="h-4 w-4 text-blue-600 dark:text-blue-400" />
              <span class="text-sm font-medium text-blue-700 dark:text-blue-300 capitalize">
                {{ role.replace('_', ' ') }}
              </span>
            </div>
          </div>

          <p v-if="profile.roles.length === 0" class="text-sm text-gray-500 dark:text-gray-400 italic">
            No roles assigned.
          </p>
        </div>

        <!-- Account meta -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
          <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
            <ClockIcon class="h-5 w-5 text-blue-600 dark:text-blue-400" />
            Account
          </h2>

          <dl class="space-y-3">
            <div>
              <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Member since</dt>
              <dd class="mt-0.5 text-sm text-gray-900 dark:text-white">{{ formatDate(profile.created_at) }}</dd>
            </div>
            <div>
              <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Status</dt>
              <dd class="mt-0.5">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                  <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                  Active
                </span>
              </dd>
            </div>
          </dl>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { computed } from 'vue'
import {
  UserIcon,
  EnvelopeIcon,
  PhoneIcon,
  KeyIcon,
  ShieldCheckIcon,
  ClockIcon,
  PencilSquareIcon,
} from '@heroicons/vue/24/outline'
import AppLayout from '@/layouts/AppLayout.vue'

const props = defineProps({
  profile: { type: Object, required: true },
})

const initials = computed(() => {
  const f = props.profile.first_name?.charAt(0) ?? ''
  const l = props.profile.last_name?.charAt(0) ?? ''
  return `${f}${l}`.toUpperCase()
})

const formatDate = (iso) => {
  if (!iso) return '—'
  const d = new Date(iso)
  if (isNaN(d)) return '—'
  return d.toLocaleDateString('en-GB', {
    day: '2-digit',
    month: 'short',
    year: 'numeric',
  })
}
</script>
