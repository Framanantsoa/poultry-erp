import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

export function usePermissions() {
    const page = usePage()

    const user = computed(() => page.props.auth?.user ?? page.props.user)
    const permissions = computed(() => user.value?.permissions ?? [])
    const roles = computed(() => user.value?.roles ?? [])

    const can = (permission) => permissions.value.includes(permission)
    const cannot = (permission) => !can(permission)
    const hasRole = (role) => roles.value.includes(role)
    const hasAnyRole = (...names) => names.some((r) => roles.value.includes(r))
    const hasAnyPermission = (...perms) => perms.some((p) => permissions.value.includes(p))
    const hasAllPermissions = (...perms) => perms.every((p) => permissions.value.includes(p))

    return {
        user, permissions, roles,
        can, cannot,
        hasRole, hasAnyRole,
        hasAnyPermission, hasAllPermissions,
    }
}
