import { usePage } from '@inertiajs/inertia-vue3'

function getPermissions()
{
    return Object.values(usePage().props.value?.auth?.user?.permissions || {})
}



export function can(permission = null, options = null)
{
    if (!permission) return true

    const respectSuperAdmin = options?.respectSuperAdmin ?? true
    const respectAdmin = options?.respectAdmin ?? true

    if (respectSuperAdmin && getPermissions().includes('system.super-admin')) return true
    if (respectAdmin && getPermissions().includes('system.admin')) return true

    return getPermissions().includes(permission)
}



export function cannot(permission = null, options = null)
{
    return !can(permission, options)
}    

export function canAny(permissions = [], options = null)
{
    if (!permissions.length) return true

    return permissions.some(permission => can(permission, options))
}

export function canAll(permissions = [], options = null)
{
    if (!permissions.length) return true
    
    return permissions.every(permission => can(permission, options))
}