<template>
    <Head title="Unsere aktuellen Angebote" />

    <DashboardSubLayout title="Unsere aktuellen Angebote">
        <div class="grid">
            <Card v-for="angebot in angebote" new-window
                :key="angebot.id"
                :name="angebot.name"
                :alt="angebot.cover_alt"
                :cover="angebot.cover_size === 'cover'"
                :image="route('docs.cover', angebot.slug)"
                :link="route('docs', angebot.slug)"
            />
        </div>
    </DashboardSubLayout>
</template>

<script setup>
    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import Card from '@/Components/Page/Card.vue'

    defineProps({
        angebote: Array,
    })
</script>

<style lang="sass" scoped>
    .grid
        display: grid
        gap: 1rem
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr))

    @media only screen and (max-width: 500px)
        .grid
            grid-template-columns: auto
</style>