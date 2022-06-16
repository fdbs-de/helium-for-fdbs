<template>
    <TextSubLayout title="Marketing & Kommunikation" has-small-limiter>
        <Head>
            <title>Produkte & Services: Marketing & Kommunikation</title>
        </Head>
        <p>
            wir freuen uns, dass Sie Interesse an unseren Produkten haben und möchten Ihnen mit
            unserer eigenen Website einen kleinen Einblick in unser Produktportfolio geben:<br><br>
            <a href="https://marketing-bs.de" target="_blank">marketing-bs.de</a>
        </p>
        <p>&nbsp;</p>
        <h2>Ihre Ansprechpartner</h2>
        <div class="grid">
            <StaffCard name="Benjamin Vahle" link="tel:0531 210 55 16" label="0531 210 55 16" image="/images/content/test_pfp.jpg" alt="Portrait von Benjamin Vahle"/>
            <StaffCard name="Franziska Brandt" link="tel:0531 210 55 51" label="0531 210 55 51" image="/images/content/test_pfp.jpg" alt="Portrait von Franziska Brandt"/>
            <StaffCard name="Maurice Freuwört" link="tel:0531 210 55 73" label="0531 210 55 73" image="/images/content/test_pfp.jpg" alt="Portrait von Maurice Freuwört"/>
            <StaffCard name="Franziska Wolff" link="tel:0531 210 55 25" label="0531 210 55 25" image="/images/content/test_pfp.jpg" alt="Portrait von Franziska Wolff"/>
            <StaffCard name="Carolin Götzner" link="tel:0531 210 55 43" label="0531 210 55 43" image="/images/content/test_pfp.jpg" alt="Portrait von Carolin Götzner"/>
            <StaffCard name="Annika Görmann" link="tel:0531 210 55 72" label="0531 210 55 72" image="/images/content/test_pfp.jpg" alt="Portrait von Annika Görmann"/>
        </div>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import StaffCard from '@/Components/Page/StaffCard.vue'
</script>

<style lang="sass" scoped>
    .grid
        display: grid
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr))
        gap: 2rem
</style>