<template>
    <TextSubLayout title="Eichenhof Markenfleisch" image="/images/content/marken/eichenhof/header.jpg" has-small-limiter>

        <Head>
            <title>Eichenhof Markenfleisch – FDBS</title>
        </Head>

        <div class="logo-wrapper">
            <img src="/images/content/marken/eichenhof/eichenhof_logo.png" alt="Eichenhof Markenfleisch">
        </div>

        <h2 style="margin-bottom: 0;">Eichenhof – wir leben regional</h2>

        <p>&nbsp;</p>

        <p>
            Der Slogan verkörpert zu 100% das, was wir sind: Regional und fest verwurzelt.
            Und genau das, wollen wir auf jeder Ebene unseres Tuns und Handels dem Kunden vermitteln. Unsere Leidenschaft schmeckt man und das ist unser Ziel.
        </p>
        <p>
            Das Eichenhof Qualitätsprogramm steht für die Erzeugung von Schweine- und Rindfleisch unter Beachtung besonderer Kriterien hinsichtlich der Haltungs- und Standortbedingungen.
        </p>
        <p>
            Wir haben jahrelange Erfahrung in den Bereichen Tierhaltung, Schlachtung und Produktion. Neben der Qualität steht das Tierwohl ganz weit oben. Wir bieten deutsches Schweine- und Rindfleisch in höchster Qualität mit regionalem Bezug an. Das Wohl der Tiere liegt uns sehr am Herzen, daher sind kurze Transportwege um den Standort unerlässlich.
        </p>
        <p>
            Wir arbeiten eng mit Landwirten zusammen, pflegen unsere familiären Strukturen und stehen für flache Hierarchien. Kurze Wege ermöglichen schnelle Entscheidungen und immer wiederkehrende Abläufe und sorgen so für die Einhaltung unserer hohen Produktionsstandards. Diese sind für eine hohe Qualität und ein professionelles Auftreten unabdingbar.  Trotz der hohen Ansprüche an unsere Produkte zählt bei uns noch der Handschlag und das offene Wort.
        </p>
        <p>
            <b>Wir sind bodenständig, authentisch und verkaufen nicht nur Fleisch, sondern ein  Stück Verbundenheit!</b>
        </p>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import Card from '@/Components/Page/Card.vue'
</script>

<style lang="sass" scoped>
    .logo-wrapper
        display: flex
        justify-content: center
        padding-block: 3rem
        border-radius: .5rem
        margin-bottom: 4rem
        background-color: #14552E

        img
            width: 100%
            max-width: 130px

    .order-wrapper
        display: flex
        flex-direction: column
        padding: 1rem
        border-radius: .5rem
        margin-block: 2rem
        background-color: #14552E
        color: white

        h3
            color: inherit
            margin-block: 0
</style>