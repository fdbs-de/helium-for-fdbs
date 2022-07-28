<template>
    <TextSubLayout title="Unsere Stellenangebote">
        <Head>
            <title>Ihre Karriere bei FDBS</title>
        </Head>

        <div class="wrapper">
            <Card v-for="job in jobs" cover new-window
                aspect-ratio="16/9"
                :key="job.id"
                :name="job.name"
                :primary-tag="job.primary_tag"
                :tags="strToTags(job.tags)"
                :image="route('docs.cover', job.slug)"
                :link="route('docs', job.slug)"
            />
        </div>

        <h2 class="benefits-headline">Ihre Vorteile bei uns</h2>

        <div class="grid">
            <IconCard icon="spa" title="30 Tage Urlaub" text="30 Tage Jahresurlaub. Zeit für Familie, Freunde, Reisen und Freizeit."/>
            <IconCard icon="shopping_bag" title="Corporate Benefits" text="Geld sparen bei jedem Einkauf bei über 800 Partnern mit Corporate Shopping."/>
            <IconCard icon="favorite" title="Gesundheit" text="Einen ergonomischen Arbeitsplatz und freiwillige Gesundheitsmaßnahmen"/>
            <IconCard icon="local_bar" title="Firmenevents" text="Team Events stärken den Zusammenhalt."/>
            <IconCard icon="school" title="Weiterbildung" text="Seminare, Coachings und Online Trainings."/>
            <IconCard icon="percent" title="Mitarbeiter Rabatt" text="Sie bekommen Food & Hardware bei uns zu günstigen Mitarbeiterpreisen."/>
            <IconCard icon="airport_shuttle" title="Verkehrsanbindung" text="Für Ihre entspannte Anreise: Exzellente Anbindung an die A2 sowie öffentliche Verkehrsmittel."/>
            <IconCard icon="groups" title="Flache Hierarchien" text="Mehr Spaß bei der Arbeit: eine kollegiale Arbeitsatmosphäre."/>
            <IconCard icon="money_off" title="Keine Studiengebühren" text="Wir zahlen Ihre Studiengebühren für das duale Studium."/>
            <IconCard icon="handshake" title="Übernahmegarantie" text="Garantierte Übernahme nach erfolgreichem Abschluss Ihres Studiums oder Ihrer Ausbildung."/>
            <IconCard icon="reviews" title="Direkter Ansprechpartner" text="Einen festen Ansprechpartner und regelmäßige Feedbackgespräche."/>
        </div>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import Card from '@/Components/Page/Card.vue'
    import IconCard from '@/Components/Page/IconCard.vue'

    defineProps({
        jobs: Array,
    })

    const strToTags = (string) => {
        return string?.split(',')?.map(tag => tag.trim()) ?? []
    }
</script>

<style lang="sass" scoped>
    .wrapper
        display: grid !important
        grid-template-columns: repeat(3, 1fr)
        gap: 3rem

    .benefits-headline
        margin-block: 6rem 3rem
        font-size: 2.5rem
        text-align: center

    .grid
        display: grid
        gap: 3rem
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr))



    @media only screen and (max-width: 1000px)
        .wrapper
            grid-template-columns: repeat(2, 1fr)



    @media only screen and (max-width: 700px)
        .wrapper
            grid-template-columns: repeat(1, 1fr)

    @media only screen and (max-width: 500px)
        .benefits-headline
            font-size: 2rem
</style>