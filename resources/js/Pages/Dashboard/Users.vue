<template>
    <Head title="Dashboard: Nutzerverwaltung" />

    <DashboardSubLayout title="Nutzerverwaltung">
        <div class="grid">
            <div class="row">
                <b>Name</b>
                <b>Email</b>
                <b>Email bestätigt</b>
                <b>Freigegeben</b>
                <b>Hat Mitarbeiterprofil</b>
                <b>Hat Kundenprofil</b>
                <b>Rollen</b>
            </div>
            <div class="row" v-for="user in users" :key="user.id">
                <span>{{user.name}}</span>
                <span>{{user.email}}</span>
                <span>{{new Date(user.email_verified_at).toLocaleDateString()}}</span>
                <span>{{new Date(user.enabled_at).toLocaleDateString()}}</span>
                <span>{{user.employee_profile ? 'Ja' : 'Nein'}}</span>
                <span>{{user.customer_profile ? 'Ja' : 'Nein'}}</span>
                <span>{{user.roles.map(e => e.name).join(', ')}}</span>
            </div>
        </div>
    </DashboardSubLayout>
</template>

<script setup>
import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
import { Head, Link } from '@inertiajs/inertia-vue3'

defineProps({
    users: Array,
})
</script>

<style lang="sass" scoped>
    .grid
        display: flex
        flex-direction: column
        width: 100%
        padding-block: 1rem

        .row
            display: grid
            align-items: center
            grid-template-columns: repeat(7, 1fr)
            gap: var(--su)
            padding: .5rem 1rem

            &:hover
                background: var(--color-background-soft)
</style>