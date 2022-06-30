<template>
    <TextSubLayout title="Maxi France" image="/images/content/marken/maxi-france/header.jpg" has-small-limiter>

        <Head>
            <title>Maxi France</title>
        </Head>

        <div class="logo-wrapper">
            <img src="/images/content/marken/maxi-france/maxifrance_logo.png" alt="Maxi France">
        </div>

        <p>
            Mit Maxi France erhalten Sie ein qualifiziertes Angebot von hochwertigem, französischem
            Marken-Jungbullenfleisch. Die Marke ist leicht verständlich und lässt die Herkunft des Fleisches sofort
            erkennen. Der Name ist für jedermann gut auszusprechen und vermittelt dem Endverbraucher französisches
            Flair. Die drei Sterne im Logo stehen zudem für höchste Qualität. Dadurch bedingt entsteht ein maximaler
            Wiedererkennungswert von Maxi France. Maxi France Erzeugnisse stammen zu 100 Prozent aus Frankreich – von
            der Geburt der Tiere über die Aufzucht bis hin zur Schlachtung und Herstellung. Schon die Auswahl der
            Lieferanten erfolgt nach strengen Vorgaben. Das Fleisch für die Maxi France Produkte kommt ausnahmslos von
            vorab geprüften familiengeführten Bauernhöfen. Artgerechte Aufzucht, natürliche Haltungsbedingungen und
            kurze Transportwege werden großgeschrieben. Maxi France unterliegt strengsten Kontrollen und sichert durch
            ein umfassendes Qualitäts-Sicherungsprogramm lückenlose Rückverfolgbarkeit – vom landwirtschaftlichen
            Betrieb bis zum POS. Dabei werden alle Prozesse von der Aufzucht bis zum POS unabhängig überwacht und
            kontrolliert.
        </p>

        <p>&nbsp;</p>

        <img class="content-image" src="/images/content/marken/maxi-france/trennbild_1.jpg" alt="Bullenherde auf einer Wiese">

        <p>&nbsp;</p>

        <h2>Ihre Maxi-France-Vorteile:</h2>
        <ul>
            <li>100 % pflanzliche Ernährung der Jungbullen, mineral- und vitaminhaltig</li>
            <li>Ständige unabhängige Kontrollen</li>
            <li>In Frankreich geborene, gehaltene und geschlachtete Jungbullen</li>
            <li>
                Garantierte Rückverfolgbarkeit der Jungbullen von der Geburt bis zur
                Verkaufsstelle gemäß den Vorschriften des Bundesministeriums
                für Ernährung und Landwirtschaft (BMEL)
            </li>
            <li>Garantierte Reifedauer für Barbecues und Bratenteilstücke</li>
            <li>Ausgewählte Fleisch- und Zweinutzungsrassen, keine reinen Milchrassen</li>
        </ul>

        <p>&nbsp;</p>

        <img class="content-image" src="/images/content/marken/maxi-france/trennbild_2.jpg" alt="Bauer mit weißem Bullen auf einer Wiese">
        
        <div class="order-wrapper">
            Jetzt bestellen:
            <h3>0531 210 55 23</h3>
        </div>

        <p>&nbsp;</p>

        <Card new-window aspect-ratio="16/9" name="Maxi France Broschüre (Download)"
            image="/images/content/marken/maxi-france/imageflyer_cover.png"
            link="/downloads/marken/maxi-france/MaxiFrance_Imageflyer.pdf" />
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
        background-color: #b61615

        img
            width: 100%
            max-width: 130px

    .order-wrapper
        display: flex
        flex-direction: column
        padding: 1rem
        border-radius: .5rem
        margin-block: 2rem
        background-color: #b61615
        color: white

        h3
            color: inherit
            margin-block: 0
</style>