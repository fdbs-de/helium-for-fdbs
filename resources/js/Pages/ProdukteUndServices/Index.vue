<template>
    <TextSubLayout title="Unsere Produkte und Services" image="/images/content/banner/produkte_services_229048757.webp">
        <Head>
            <title>Unsere Produkte & Services – FDBS</title>
        </Head>
        <div class="grid">
            <Card name="Unsere Angebote" alt="Unsere Angebote" cover :link="route('ps.angebote')" image="/images/content/services/cover/angebote_cover.png"/>
            <Card name="Foodservice" alt="Foodservice" cover :link="route('ps.foodservice')" image="/images/content/services/cover/foodservice_cover.png"/>
            <Card name="Unsere Marken" alt="Unsere Marken" cover :link="route('ps.marken')" image="/images/content/services/cover/marken_cover.png"/>
            <Card name="Fachberatung: Käse und Salate" alt="Fachberatung: Käse und Salate" cover :link="route('ps.fachberatung-kaese-und-salate')" image="/images/content/services/cover/kaese_und_salate_cover.png"/>
            <Card name="Marketing & Kommunikation" alt="Marketing & Kommunikation" cover :link="route('ps.marketing-und-kommunikation')" image="/images/content/services/cover/mkbs_cover.png"/>
            <Card name="Technischer Kundendienst" alt="Technischer Kundendienst" cover :link="route('ps.technischer-kundendienst')" image="/images/content/services/cover/technischer_kundendienst_cover.png"/>
            <Card name="Seminare" alt="Seminare" cover :link="route('seminare')" image="/images/content/services/cover/seminare_cover.png"/>
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
        gap: 4rem
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr))
</style>