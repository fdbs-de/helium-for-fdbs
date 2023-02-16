<template>
    <TextSubLayout title="Grillseminar „Best of Meat - Fleischeslust“ mit Andreas Rummel" image="/images/content/seminare/grillseminar_2023.jpg" color="white" has-small-limiter>
        <Head>
            <title>Grillseminar „Best of Meat - Fleischeslust“ – FDBS Seminare</title>
        </Head>
        <Alert title="Wichtiges im Überblick:">
            <div class="head-grid">
                <span>Datum:</span>
                <span><b>20. März 2023</b></span>
                
                <span style="line-height: 1.4">Uhrzeit:</span>
                <span style="line-height: 1.4"><b>13:30 - ca. 17:30</b><br><small>(inkl. Pausenzeiten)</small></span>

                <span>Referent:</span>
                <span><b>Andreas Rummel</b></span>
                
                <span>Seminargebühren:</span>
                <span>
                    <Tag shape="pill" color="var(--color-green)"><b>129,00 €</b></Tag><br>
                    <small>(inkl. MwSt., Verpflegung, Tasting und Seminarunterlagen)</small>
                </span>

                <span>Teilnehmerzahl:</span>
                <span>
                    <Tag shape="pill" color="var(--color-red)"><b>begrenzt</b></Tag>
                </span>
            </div>
        </Alert>
        <p>&nbsp;</p>
        <p>
            Grillen ist nach wie vor ein Trend mit stetig wachsendem Zuspruch. Das kommt nicht von ungefähr, denn gerade dieses
            Thema vereint viele Aspekte, die das Kaufver- halten Ihrer Kunden beeinflussen: Zeitgeist, Kreativität, Fachwissen und
            immer voran der besondere Genuss, der Kult und die Geselligkeit.
        </p>
        <p>
            Kern dieses Seminares sind umfassende Informationen zu qualitativ gutem Fleisch und dessen Verwendung. Der Grillexperte
            Andreas Rummel prüft die klassischen Grillmythen auf ihren Wahrheitsgehalt und gibt auf seine unverwechselbare Art,
            Einblick in die Entwicklung der Steakkultur der letzten Jahre. Woran erkennt man gutes Fleisch? Wie bereitet man es
            richtig zu und was passiert bei welcher Temperatur im Fleisch? Das sind nur einige Fragen, denen der Referent in diesem
            praxisorientierten Seminar nachgeht.
        </p>
        <h3>Was erwartet Sie in diesem Workshop?</h3>
        <p>
            <ul>
                <li>Basics: Herkunft, Zucht, Anatomie</li>
                <li>Grilltauglichkeit unterschiedlicher Produkte</li>
                <li>Klassische und innovative Cuts</li>
                <li>Sous Vide Garen + Grillen</li>
                <li>Teilzerlegung</li>
            </ul>
        </p>
        <p>
            Sie sind in diesem Workshop genau richtig, wenn inno- vative Fleischzuschnitte Ihr Herz höherschlagen lassen und Sie Ihr
            Fachwissen in Bezug auf Warenkunde und Verarbeitung erweitern wollen.
        </p>
        <p>
            Eine Steak-Querverkostung verschiedener Fleischzu- schnitte sowie ein Tasting unterschiedlicher Grillvariati- onen runden
            diesen Workshop genussvoll ab.
        </p>
        <p>&nbsp;</p>
        <h3>Zielgruppe:</h3>
        <p>
            Eine Zielgruppe zu definieren ist schwer, weil für jeden etwas dabei ist – von der Zerlegung über die
            Zubereitung und Fachwissen für den Verkauf. Nach meiner Erfahrung hat es sich immer ausgezahlt, einmal über den
            berühmten „Tellerrand“ zu schauen. Wie soll ich das Fleisch richtig vorbereiten, wenn ich nicht weiß, was der
            Verbraucher wünscht und wie soll an der Theke opti- mal beraten werden, wenn das Wissen über die Ware und deren
            Zubereitung nicht vorhanden ist. Es geht nur als Team und dieses Seminar gibt Ihnen die gemeinsame Basis.
        </p>
        <p>&nbsp;</p>

        <Alert title="Andreas Rummel">
            <p>
                Als gebürtiger Thüringer tourt der Inhaber mehrerer Meister- und Rekordtitel seit 17 Jahren quer durch Deutschland,
                rund um die Welt und durch TV-Shows aller Art. Er vermittelt Tipps und Tricks zum kreativen Grillen an ein immer wieder
                fasziniertes Publikum und tauscht sich mit Spitzenköchen über die neuesten Lebensmittel und Zubereitungstechniken aus.
                In seinem Youtube Kanal „Rummel Grill TV“ und seinen zahlreichen Büchern gibt er Einblicke in die kulinarische Physik
                rund um den Grill und gibt Dank seiner langjährigen Erfahrung in
                Gastronomie und Grillszene sein umfangreiches Wissen über Produkte, Garmethoden und diversen Aromen unterhaltsam und
                informativ weiter. Andreas Rummel hat seine Leidenschaft zum Beruf gemacht. Quirlig und dynamisch ist jeder seiner
                Auftritte. „Manchmal kommt es anders, wenn man denkt“ ist eines seiner Zitate, die seine Improvisationskunst beschreibt.
            </p>
            <p>
                Website: <a href="https://www.andreas-rummel.de" target="_blank" rel="noopener noreferrer">www.andreas-rummel.de</a><br>
                Youtube Kanal: <a href="https://www.youtube.com/c/RummelGrillTV" target="_blank" rel="noopener noreferrer">https://www.youtube.com/c/RummelGrillTV</a>
            </p>
        </Alert>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import Alert from '@/Components/Alert.vue'
    import Tag from '@/Components/Form/Tag.vue'
    import Card from '@/Components/Page/Card.vue'
</script>

<style lang="sass" scoped>
    .head-grid
        display: grid
        gap: 1rem
        grid-template-columns: auto 1fr
</style>