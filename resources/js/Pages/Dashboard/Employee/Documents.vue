<template>
    <Head title="Dokumente" />

    <DashboardSubLayout title="Dokumente" area="Intranet">
        <div class="card">
            <div class="flex w-100 padding-inline-1 border-bottom">
                <Tabs class="tabs" v-model="tab" :tabs="[
                    { label: 'Allgemeine Dokumente', value: '191' },
                    { label: 'QM Dokumente', value: '192' },
                    { label: 'Marketing Material', value: '190' },
                    { label: 'Leitbild und Organigramm', value: '211' },
                ]" />
            </div>
            <DownloadManager title="Allgemeine Dokumente" id="191" v-show="tab == '191'"/>
            <DownloadManager title="QM Dokumente" id="192" v-show="tab == '192'"/>
            <DownloadManager title="Marketing Material" id="190" v-show="tab == '190'"/>
            <DownloadManager title="Leitbild und Organigramm" id="211" v-show="tab == '211'"/>
        </div>
    </DashboardSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import { ref } from 'vue'

    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
    import DownloadManager from '@/Components/Apps/Pages/Renderer/DownloadManager.vue'
    import Tabs from '@/Components/Form/Tabs.vue'



    defineProps({
        documents: Array,
    })

    const tab = ref('191')
</script>

<style lang="sass" scoped>
    .card
        background: var(--color-background)
        border-radius: var(--radius-m)
        box-shadow: var(--shadow-elevation-low)

    .tabs
        --tab-height: 4rem
        width: 100%
</style>