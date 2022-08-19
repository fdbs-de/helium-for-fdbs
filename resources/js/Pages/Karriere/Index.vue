<template>
    <Head>
        <title>Ihre Karriere bei FDBS</title>
    </Head>

    <TextSubLayout title="Ihre Karriere bei FDBS">
        <div class="grid">
            <Card cover name="Unsere Stellenangebote" image="/images/content/marken/eichenhof/eichenhof_card.png" :link="route('karriere.stellenangebote')"/>
            <Card cover name="Studium und Ausbildung" image="/images/content/marken/eichenhof/eichenhof_card.png" :link="route('karriere.studium-und-ausbildung')"/>
            <Card cover name="FDBS als Arbeitgeber" image="/images/content/marken/eichenhof/eichenhof_card.png" :link="route('karriere.fdbs-als-arbeitgeber')"/>
        </div>

        <Benefits />
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import Card from '@/Components/Page/Card.vue'
    import Benefits from '@/Components/Page/Karriere/Benefits.vue'
</script>

<style lang="sass" scoped>
    .grid
        display: grid
        gap: 3rem
        margin-top: 3rem
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr))
</style>