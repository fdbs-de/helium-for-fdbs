<template>
    <Header :menu="menu"/>
    <slot />
    <Footer />
</template>

<script setup>
    import Header from '@/Components/Page/Header.vue'
    import Footer from '@/Components/Page/Footer.vue'
    import { usePage } from '@inertiajs/inertia-vue3'
    import { ref } from 'vue'

    const can = (permission) => {
        return (usePage().props.value?.auth?.user?.permissions || []).includes(permission)
    }



    const menu = []

    if (can('access customer panel'))
    {
        menu.push({ id: 'customer-overview', label: 'Kundenbereich', href: route('dashboard.customer'), icon: null, children: [] })
    }

    if (can('access employee panel'))
    {
        menu.push({ id: 'employee-overview', label: 'Mitarbeiterbereich', href: route('dashboard.employee'), icon: null, children: [] })
    }

    if (can('access admin panel'))
    {
        menu.push({
            id: 'admin-overview',
            label: 'Adminbereich',
            href: route('dashboard.admin'),
            icon: null,
            children: [
                { id: 'admin-users', label: 'Nutzerverwaltung', href: route('dashboard.admin.users'), icon: null, children: [] },
            ],
        })
    }

    menu.push({ id: 'profile', label: 'Profil', href: route('dashboard.profile'), icon: null, children: [] })
</script>