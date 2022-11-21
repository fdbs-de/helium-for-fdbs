<template>
    <h2 class="benefits-headline">Deine Vorteile bei uns</h2>
    
    <div class="grid">
        <IconCard icon="spa" title="30 Tage Urlaub" text="30 Tage Jahresurlaub. Zeit für Familie, Freunde, Reisen und Freizeit."/>
        <IconCard icon="shopping_bag" title="Corporate Benefits" text="Geld sparen bei jedem Einkauf bei über 800 Partnern mit Corporate Shopping."/>
        <IconCard icon="favorite" title="Gesundheit" text="Einen ergonomischen Arbeitsplatz und freiwillige Gesundheitsmaßnahmen."/>
        <IconCard icon="local_bar" title="Firmenevents" text="Teamevents stärken den Zusammenhalt."/>
        <IconCard icon="school" title="Weiterbildung" text="Seminare, Coachings und Online Trainings."/>
        <IconCard icon="percent" title="Mitarbeiter Rabatt" text="Du bekommst unser gesamtes Sortiment zu günstigen Mitarbeiterpreisen."/>
        <IconCard icon="airport_shuttle" title="Verkehrsanbindung" text="Für deine entspannte Anreise: Exzellente Anbindung an die A2 sowie öffentliche Verkehrsmittel."/>
        <IconCard icon="groups" title="Flache Hierarchien" text="Mehr Spaß bei der Arbeit: eine kollegiale Arbeitsatmosphäre."/>
        <!-- <IconCard icon="money_off" title="Keine Studiengebühren" text="Wir zahlen Ihre Studiengebühren für das duale Studium."/> -->
        <!-- <IconCard icon="handshake" title="Übernahmegarantie" text="Garantierte Übernahme nach erfolgreichem Abschluss Ihres Studiums oder Ihrer Ausbildung."/> -->
        <IconCard icon="reviews" title="Direkter Ansprechpartner" text="Einen festen Ansprechpartner und regelmäßige Feedbackgespräche."/>
    </div>
</template>

<script setup>
    import IconCard from '@/Components/Page/IconCard.vue'
</script>

<style lang="sass" scoped>
    .benefits-headline
        margin-block: 6rem 3rem
        font-size: 2.5rem
        text-align: center

    .grid
        display: grid
        gap: 3rem
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr))



    @media only screen and (max-width: 500px)
        .benefits-headline
            font-size: 2rem
</style>