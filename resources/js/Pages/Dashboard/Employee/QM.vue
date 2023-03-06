<template>
    <Head title="Qualitätsmanagement" />

    <DashboardSubLayout title="Qualitätsmanagement" area="Intranet">
        <div class="flex vertical gap-2 w-100">
            <DownloadManager title="QM Dokumente" id="192" />
        </div>
    </DashboardSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'

    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
    import DownloadManager from '@/Components/Apps/Pages/Renderer/DownloadManager.vue'

    defineProps({
        documents: Array,
    })
</script>

<style lang="sass" scoped>
    .grid
        display: grid
        gap: 1rem
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr))

    @media only screen and (max-width: 500px)
        .grid
            grid-template-columns: auto
</style>