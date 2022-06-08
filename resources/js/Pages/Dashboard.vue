<template>
    <Head title="Dashboard" />

    <DashboardSubLayout title="FDBS Dashboard">
        <h2>Sie sind angemeldet!</h2>
        <Link :href="route('logout')" method="post" as="button">Abmelden</Link>
    </DashboardSubLayout>
</template>

<script setup>
import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
import { Head, Link } from '@inertiajs/inertia-vue3'
</script>