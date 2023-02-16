<template>
    <TextSubLayout title="Unsere Seminare" image="/images/content/banner/seminare_291711336_335532188.webp" has-small-limiter>
        <Head>
            <title>Unsere Seminare – FDBS Seminare</title>
        </Head>
        <div class="grid">
            <Card aspect-ratio="16/9" cover name="Grillseminar „Best of Meat - Fleischeslust“" alt="Grillseminar „Best of Meat - Fleischeslust“" primary-tag="20.03.2023" :tags="['Andreas Rummel']" image="/images/content/seminare/grillseminar_2023.jpg" :link="route('seminare.grillseminar')"/>
            <!-- /downloads/seminare/grillseminar_2023.pdf -->
            <!-- <Card aspect-ratio="16/9" cover name="Workshop: Power-Pricing" alt="Workshop: Power-Pricing" primary-tag="28.09.2022" :tags="['Prof. Dr. Torsten Olderog']" image="/images/content/seminare/power_pricing_workshop_2022_452991385.jpg" new-window link="/downloads/seminare/power_pricing_workshop_2022.pdf"/> -->
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