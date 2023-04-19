<template>
    <TextSubLayout title="Unsere Seminare" image="/images/content/banner/seminare_291711336_335532188.webp" has-small-limiter>
        <Head>
            <title>Unsere Seminare – FDBS Seminare</title>
        </Head>
        <div class="grid">
            <!-- <Card aspect-ratio="16/9" cover name="Grillseminar „Best of Meat - Fleischeslust“" alt="Grillseminar „Best of Meat - Fleischeslust“" primary-tag="20.03.2023" :tags="['Andreas Rummel']" image="/images/content/seminare/grillseminar/grillseminar_card_104218878.webp" :link="route('seminare.grillseminar')"/> -->
            <Card aspect-ratio="16/9" cover name="Kreativworkshop mit EDNA International GmbH und Salomon FoodWorld" alt="Kreativworkshop mit EDNA International GmbH und Salomon FoodWorld" primary-tag="08.05.2023" image="/images/content/seminare/kreativworkshop/kreativworkshop_card.webp" :link="route('seminare.kreativworkshop')"/>
            <Card aspect-ratio="16/9" cover name="Catering – Kreativität und Gaumenfreude in perfekter Harmonie" alt="Catering – Kreativität und Gaumenfreude in perfekter Harmonie" primary-tag="19.06.2023" :tags="['Astrid Schmitt']" image="/images/content/seminare/catering/catering_card.webp" :link="route('seminare.catering')"/>
        </div>
        <!-- <Alert icon="info" title="Keine Seminare oder Workshops">
            <span>
                Zur Zeit sind keine Seminare oder Workshops geplant.<br>
                Kommen Sie ein anderes mal vorbei.<br>
                <br>
                Bei Fragen wenden Sie sich bitte an <b>Elke Grigat</b>:<br>
                Tel.: <a href="tel:0531 210 55 38">0531 210 55 38</a><br>
                Email: <a href="mailto:eg@fdbs.de">eg@fdbs.de</a>
            </span>
        </Alert> -->
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import Alert from '@/Components/Alert.vue'
    import Card from '@/Components/Page/Card.vue'
</script>

<style lang="sass" scoped>
    .grid
        display: grid
        gap: 3rem
        margin-top: 3rem
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr))
</style>