<template>
    <Head title="Dokumente" />

    <DashboardSubLayout title="Dokumente">
        <div class="grid">
            <Card v-for="document in documents" new-window
                :key="document.id"
                :name="document.name"
                :alt="document.cover_alt"
                :cover="document.cover_size === 'cover'"
                :image="route('docs.cover', document.slug)"
                :link="route('docs', document.slug)"
            />
        </div>
    </DashboardSubLayout>
</template>

<script setup>
    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import Card from '@/Components/Page/Card.vue'

    defineProps({
        documents: Array,
    })
</script>

<style lang="sass" scoped>
    .grid
        display: grid
        gap: 3rem
        padding: 3rem
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr))

    @media only screen and (max-width: 500px)
        .grid
            padding: 3rem 1rem
            grid-template-columns: auto
</style>