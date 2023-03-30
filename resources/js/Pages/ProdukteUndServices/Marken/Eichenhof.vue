<template>
    <TextSubLayout title="Eichenhof Markenfleisch" image="/images/content/marken/eichenhof/header.jpg" has-small-limiter>

        <Head>
            <title>Eichenhof Markenfleisch – FDBS</title>
        </Head>

        <div class="logo-wrapper">
            <img src="/images/content/marken/eichenhof/eichenhof_logo.png" alt="Eichenhof Markenfleisch">
        </div>

        <h2 style="margin-bottom: 0;">Qualität, Sicherheit, Vertrauen.</h2>
        <p style="margin-top: 0"><b>Denn bei uns kommt alles aus einer starken Gemeinschaft.</b></p>

        <p>&nbsp;</p>

        <p>
            <strong>Keine schwarzen Schafe, nur gesunde Schweine.</strong><br>
            Eichenhof ist das Markenfleisch der Erzeugergemeinschaft Osnabrück (EGO), das von
            den Eichenhof-Landwirten erzeugt wird. Die rund 500 bäuerlichen Familienbetriebe aus dem Osnabrücker Land
            sind Mitglieder der EGO – oftmals schon seit Jahrzehnten – und in die geschlossene Erzeugungskette
            integriert. Zur Einhaltung der Richtlinien haben sie sich freiwillig verpflichtet. Zudem hat jeder Landwirt
            sein Fachwissen und die Sorgfalt im Umgang mit Land, Tier und Mensch nachgewiesen.
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