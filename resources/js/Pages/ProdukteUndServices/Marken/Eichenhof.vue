<template>
    <TextSubLayout title="Eichenhof Markenfleisch" has-small-limiter>

        <Head>
            <title>Eichenhof Markenfleisch</title>
        </Head>

        <div class="logo-wrapper">
            <img src="/images/content/marken/eichenhof/eichenhof_logo.png" alt="Eichenhof Markenfleisch">
        </div>

        <p>
            <strong>
                Qualität, Sicherheit, Vertrauen.<br>
                Denn bei uns kommt alles aus einer starken Gemeinschaft.
            </strong><br>
            <br>
            <strong>Keine schwarzen Schafe, nur gesunde Schweine</strong><br>
            Eichenhof ist das Markenfleisch der Erzeugergemeinschaft Osnabrück (EGO), das von
            den Eichenhof-Landwirten erzeugt wird. Die rund 500 bäuerlichen Familienbetriebe aus dem Osnabrücker Land
            sind Mitglieder der EGO – oftmals schon seit Jahrzehnten – und in die geschlossene Erzeugungskette
            integriert. Zur Einhaltung der Richtlinien haben sie sich freiwillig verpflichtet. Zudem hat jeder Landwirt
            sein Fachwissen und die Sorgfalt im Umgang mit Land, Tier und Mensch nachgewiesen.
        </p>
        <p><strong>Unsere Eichenhof-Garantie:</strong></p>
        <ul>
            <li>vollständig geschlossene Erzeugung bei 500 bäuerlichen Familienbetrieben im Osnabrücker Land</li>
            <li>alle Eichenhof-Landwirte haften als Mitglieder mit ihrem Kapital für die strenge Einhaltung der Erzeugungs-Richtlinien</li>
            <li>schonender Umgang mit Tier und Natur</li>
            <li>kein Einsatz von Wachstumsförderern, Antibiotika oder Tiermehlen</li>
            <li>handwerkliche Schlachtung</li>
            <li>jährliche TÜV-Prüfung der gesamten Erzeugungskette</li>
            <li>beste Ergebnisse bei QS-Kontrollen</li>
        </ul>
        <p>&nbsp;</p>
        <p>
            Für weitere Informationen besuchen Sie bitte die Homepage
            <a href="http://eichenhof.net" target="_blank" rel="noopener" title="Eichenhof Markenfleisch">www.eichenhof.net</a><br>
            oder laden Sie sich hier unsere Informationsbroschüre herunter:<br><br>
        </p>
        <Card new-window aspect-ratio="16/9" name="Eichenhof Broschüre (Download)" image="/images/content/marken/eichenhof/eichenhof_imagebroschure.jpg" link="/downloads/marken/eichenhof/eichenhof_imagebroschure.pdf"/>
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
</style>