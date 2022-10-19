<template>
    <TextSubLayout title="Unsere Marken" image="/images/content/banner/marken_509487561.webp">
        <Head>
            <title>Produkte & Services: Unsere Marken</title>
        </Head>
        <div class="grid">
            <Card cover name="Eichenhof" image="/images/content/marken/eichenhof/eichenhof_card.png" :link="route('ps.marken.eichenhof')"/>
            <Card cover name="Il Campese" image="/images/content/marken/il-campese/ilcampese_card.png" :link="route('ps.marken.il-campese')"/>
            <Card cover name="Maxi France" image="/images/content/marken/maxi-france/maxifrance_card.png" :link="route('ps.marken.maxi-france')"/>
        </div>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import Card from '@/Components/Page/Card.vue'
</script>

<style lang="sass" scoped>
    .grid
        display: grid
        gap: 3rem
        margin-top: 3rem
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr))
</style>