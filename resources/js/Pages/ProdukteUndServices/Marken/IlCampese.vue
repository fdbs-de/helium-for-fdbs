<template>
    <TextSubLayout title="Il Campese" image="/images/content/marken/il-campese/header.jpg" has-small-limiter>

        <Head>
            <title>Il Campese</title>
        </Head>

        <!-- <div class="logo-wrapper">
            <img src="/images/content/marken/eichenhof/eichenhof_logo.png" alt="Il Campese" />
        </div> -->

        <p>
            Die Story des mediterranen Freilandhähnchens Amadori wurde 1969 in San
            Vittore di Cesena gegründet. Das Familienunternehmen, dass sich in der
            zweiten Generation befindet, verbindet Tradition und Innovation.
        </p>
        <p>
            Das IFS zertifizierte Unternehmen profitiert von der langjährigen
            Erfahrung und Expertise seiner Mitarbeiter, die jeden Tag mit Leidenschaft
            daran arbeiten, ihren Endverbrauchern frische, gesunde und schmackhafte
            Produkte anbieten zu können. Zum Erfolgsrezept des Unternehmens gehört
            essenziell die Versorgungskette.<br>
            Denn Amadori ist ein echter
            Selbstversorger: Futterherstellung, Zuchtfarmen, Brütereien und Aufzucht
            der sowohl männlichen als auch weiblichen Tiere. So kann die Firma die
            angemessene Fütterung und Aufzucht der Tiere, die schnelle und sichere
            Zulieferung sowie die Qualität ihrer Produkte garantieren.
        </p>
        <p>
            „Il Campese Hubbard JA57“ ist der Name der eigenen Rasse. Dabei werden
            stets hohe internationale Standards berücksichtigt: Die Tiere werden mit
            Freilandhaltung in der Region Apulien gehalten, mit einem sehr
            mediterranen Klima, mit 100% pflanzlicher Ernährung, davon 20 % Mais, was
            sich in Geschmack und Optik widerspiegelt.
        </p>
        <p>
            Auf den Einsatz von Antibiotika und Gentechnik wird verzichtet. Tierwohl
            wird hier großgeschrieben. Die hohen Standards hat sich das Unternehmen
            selbst gesetzt und durch Zertifikate untermauert.
        </p>
        <p>&nbsp;</p>
        <h2>Warum Il Campese-Hähnchen so gut ist:</h2>
        <ul>
            <li>Ohne Gentechnik (GVO)</li>
            <li>Keine Antibiotika</li>
            <li>100 % pflanzliche Fütterung, mit 20 % Maisanteil</li>
            <li>Tierwohl durch mehr Platz</li>
            <li>Kurze Transportwege</li>
        </ul><br>
        <div class="item-wrapper flex v-center gap" style="padding: 1rem; background: var(--color-background-soft); border-radius: 0.5rem">
            <img width="140" src="/images/content/marken/il-campese/italien_lage.png" alt="Herkunft">
            <div class="flex-1">
                <h3>Herkunft</h3>
                <p>Region Apulien in Süd-Italien</p>
            </div>
        </div>
        <p>&nbsp;</p>
        <h2>Die Il Campese-Produktvielfalt</h2>
        <p>Für Bedienungs- und SB-Theken!</p>
        <p>
            <img src="/images/content/marken/il-campese//campese_produkte.jpg" alt="Il Campese Produktauswahl" style="width: 100%; border-radius: 0.5rem" />
        </p>
        <div class="order-wrapper">
            Jetzt bestellen:
            <h3>0531 210 55 23</h3>
        </div>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <div class="item-wrapper flex gap">
            <Card class="flex-1" new-window aspect-ratio="16/9" name="Il Campese Broschüre (Download)" image="/images/content/marken/il-campese/italfino_amadori.jpg" link="/downloads/marken/il-campese/ilcampese_broschure.pdf" />
            <Card class="flex-1" new-window aspect-ratio="16/9" name="Il Campese Rezepte (Download)" image="/images/content/marken/il-campese/campese_rezepte.jpg" link="/downloads/marken/il-campese/ilcampese_rezeptflyer.pdf" />
        </div>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from "@inertiajs/inertia-vue3"
    import TextSubLayout from "@/Layouts/SubLayouts/Text.vue"
    import Card from "@/Components/Page/Card.vue"
</script>

<style lang="sass" scoped>
.logo-wrapper
    display: flex
    justify-content: center
    padding-block: 3rem
    border-radius: .5rem
    margin-bottom: 4rem
    background-color: #EB920C

    img
        width: 100%
        max-width: 130px

.order-wrapper
    display: flex
    flex-direction: column
    padding: 1rem
    border-radius: .5rem
    margin-block: 2rem
    background-color: #EB920C
    color: white

    h3
        color: inherit
        margin-block: 0

.item-wrapper
    gap: 2rem

@media screen and (max-width: 600px)
    .item-wrapper
        flex-direction: column
</style>