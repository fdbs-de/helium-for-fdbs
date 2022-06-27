<template>
    <TextSubLayout title="Unsere Marken">
        <Head>
            <title>Produkte & Services: Unsere Marken</title>
        </Head>
        <div class="grid">
            <Card cover new-window aspect-ratio="16/9" name="Eichehof" image="/images/content/test_banner.jpg" :link="route('ps.marken.eichenhof')"/>
            <Card cover new-window aspect-ratio="16/9" name="Il Campese" image="/images/content/test_banner.jpg" :link="route('ps.marken.il-campese')"/>
            <Card cover new-window aspect-ratio="16/9" name="Maxi France" image="/images/content/test_banner.jpg" :link="route('ps.marken.maxi-france')"/>
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