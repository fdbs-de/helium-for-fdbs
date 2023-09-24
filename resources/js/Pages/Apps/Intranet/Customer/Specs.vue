<template>
    <DashboardSubLayout title="Spezifikations Datenbank">
        <DownloadManager class="card" media-id="189"/>
    </DashboardSubLayout>
</template>

<script setup>
    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
    import DownloadManager from '@/Pages/Apps/Pages/Partials/DownloadManager.vue'
</script>

<style lang="sass" scoped>
    .card
        border-radius: var(--radius-m)
        border: 1px solid var(--color-border)
</style>