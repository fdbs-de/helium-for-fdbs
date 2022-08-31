<template>
    <Head title="Intranet" />

    <DashboardSubLayout title="FDBS Intranet">
        <div class="grid">
            <Card new-window name="Dokumente" :link="route('dashboard.employee.documents')" />
            <Card new-window :name="leitbild.name" :link="route('docs', leitbild.slug)" />
            <Card new-window :name="organigramm.name" :link="route('docs', organigramm.slug)" />
            <Card new-window name="Uweb Schulungen" link="https://fleischer-dienst.uweb2000.de" />
        </div>
    </DashboardSubLayout>
</template>

<script setup>
    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import Card from '@/Components/Page/Card.vue'

    defineProps({
        leitbild: Object,
        organigramm: Object,
    })
</script>

<style lang="sass" scoped>
    .grid
        display: grid
        gap: 2rem
        padding: 2rem
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr))

    @media only screen and (max-width: 500px)
        .grid
            padding: 3rem 1rem
            grid-template-columns: auto
</style>                    