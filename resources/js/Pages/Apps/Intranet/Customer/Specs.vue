<template>
    <Head title="Spezifikations Datenbank" />

    <DashboardSubLayout title="Spezifikations Datenbank">
        <div class="card">
            <DownloadManager id="189"/>
        </div>
    </DashboardSubLayout>
</template>

<script setup>
    import { Head } from '@inertiajs/inertia-vue3'

    import DownloadManager from '@/Components/Apps/Pages/Renderer/DownloadManager.vue'
    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
</script>

<style lang="sass" scoped>
    .card
        background: var(--color-background)
        border-radius: var(--radius-m)
        box-shadow: var(--shadow-elevation-low)
</style>