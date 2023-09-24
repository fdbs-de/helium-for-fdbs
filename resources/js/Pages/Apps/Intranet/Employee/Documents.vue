<template>
    <DashboardSubLayout title="Dokumente">
        <div class="flex vertical gap-2">
            <StatefulAccordion title="Allgemeine Dokumente" scope="auth.employee.documents.general">
                <DownloadManager class="card margin-bottom-4" media-id="191"/>
            </StatefulAccordion>

            <StatefulAccordion title="QM Dokumente" scope="auth.employee.documents.qm">
                <DownloadManager class="card margin-bottom-4" media-id="192"/>
            </StatefulAccordion>

            <StatefulAccordion title="Marketing Material" scope="auth.employee.documents.marketing">
                <DownloadManager class="card margin-bottom-4" media-id="190"/>
            </StatefulAccordion>

            <StatefulAccordion title="CI Dokumente" scope="auth.employee.documents.ci">
                <DownloadManager class="card margin-bottom-4" media-id="11163"/>
            </StatefulAccordion>

            <StatefulAccordion title="Leitbild und Organigramm" scope="auth.employee.documents.leitbild">
                <DownloadManager class="card margin-bottom-4" media-id="211"/>
            </StatefulAccordion>

            <StatefulAccordion title="HR Dokumente" scope="auth.employee.documents.hr">
                <DownloadManager class="card" media-id="11162"/>
            </StatefulAccordion>
        </div>
    </DashboardSubLayout>
</template>

<script setup>
    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
    import StatefulAccordion from '@/Components/Form/StatefulAccordion.vue'
    import DownloadManager from '@/Pages/Apps/Pages/Partials/DownloadManager.vue'



    defineProps({
        documents: Array,
    })
</script>

<style lang="sass" scoped>
    .card
        border-radius: var(--radius-m)
        border: 1px solid var(--color-border)
</style>