<template>
    <Header :menu="menu"/>
    <slot />
    <Footer />
</template>

<script setup>
    import Header from '@/Components/Page/Header.vue'
    import Footer from '@/Components/Page/Footer.vue'
    import { usePage } from '@inertiajs/inertia-vue3'
    import { computed } from 'vue'
    import { can } from '@/Utils/Permissions'



    const user = computed(() =>{
        return usePage().props.value.auth.user
    })



    const menu = []



    if (user.value.can_access_customer_panel)
    {
        menu.push({
            id: 'customer-overview',
            label: 'Kundenbereich',
            href: route('dashboard.customer'),
            children: [
                {id: 'customer-specs', label: 'Spezifikationen', href: route('dashboard.customer.specs'), children: []},
                {id: 'customer-offers', label: 'Angebote', href: route('dashboard.customer.offers'), children: []},
            ],
        })
    }



    if (user.value.can_access_employee_panel)
    {
        menu.push({
            id: 'employee-overview',
            label: 'Mitarbeiterbereich',
            href: route('dashboard.employee'),
            children: [
                {id: 'employee-docs', label: 'Dokumente', href: route('dashboard.employee.documents'), children: []},
            ],
        })
    }



    if (user.value.can_access_admin_panel)
    {
        menu.push({
            id: 'admin-overview',
            label: 'Adminbereich',
            href: route('dashboard.admin'),
            children: [
                {id: 'admin-users', label: 'Nutzerverwaltung', href: route('dashboard.admin.users'), children: []},
                {id: 'admin-specs', label: 'Speziverwaltung', href: route('dashboard.admin.specs'), children: []},
                {id: 'admin-docs',  label: 'Dokumentverwaltung', href: route('dashboard.admin.docs'), children: []},
            ],
        })
    }



    menu.push({id: 'profile', label: 'Profil', href: route('dashboard.profile'), children: [] })
</script>