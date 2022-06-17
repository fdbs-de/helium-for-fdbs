import { usePage } from '@inertiajs/inertia-vue3'

export function can(permission)
{
    return (usePage().props.value?.auth?.user?.permissions || []).includes(permission)
}