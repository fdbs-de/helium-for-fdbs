<template>
    <TextSubLayout title="Catering – Kreativität und Gaumenfreude in perfekter Harmonie mit Astrid Schmitt" image="/images/content/seminare/catering/catering_header.webp" color="white" has-small-limiter>
        <Head>
            <title>Catering – Kreativität und Gaumenfreude in perfekter Harmonie – FDBS Seminare</title>
        </Head>

        <Alert title="Wichtiges im Überblick:">
            <div class="head-grid">
                <span>Datum:</span>
                <span><b>19. Juni 2023</b></span>
                
                <span style="line-height: 1.4">Uhrzeit:</span>
                <span style="line-height: 1.4"><b>13:30 - ca. 17:00</b><br><small>(inkl. Pausenzeiten)</small></span>

                <span>Referent:</span>
                <span><b>Astrid Schmitt</b></span>
                
                <span>Seminargebühren:</span>
                <span>
                    <Tag shape="pill" color="var(--color-green)"><b>155,00 €</b></Tag><br>
                    <small>(zzgl. MwSt., inkl. Verpflegung, Tasting und Seminarunterlagen)</small>
                </span>

                <span>Teilnehmerzahl:</span>
                <span>
                    <Tag shape="pill" color="var(--color-red)"><b>begrenzt</b></Tag>
                </span>
            </div>
        </Alert>
        <p>&nbsp;</p>

        <h3>Was erwartet Sie in diesem Workshop?</h3>
        <p>
            Moderner Zeitgeist, veränderte Ernährungsweise und
            kulturelle Vielfalt beeinflussen und bereichern mehr
            denn je die Präsentation im Catering. In diesem
            Vortragsseminar bekommen Sie viele Tipps und
            Inspirationen um all diesen Anforderungen gerecht zu
            werden.
        </p>
        <p>
            Die erfahrene Referentin Astrid Schmitt wird im Laufe
            des Seminars ein eindrucksvolles Buffet zusammenstellen.
            Profitieren Sie dabei von ihrem fundierten
            Wissen und den wertvollen Tipps aus der Praxis.
            Zum Schluss werden Sie die Möglichkeit haben, alles
            zu fotografieren und zu verkosten.
        </p>
        <p>&nbsp;</p>

        <h3>Was erwartet Sie in diesem Workshop?</h3>
        <p>
            <ul>
                <li>Die optimale Kombination aus veredeltem Convenience und handwerklichen Kreationen</li>
                <li>Flying Food und Fingerfood</li>
                <li>Klassische Plattengestaltung neu interpretiert</li>
                <li>Trend: vegane und vegetarische Buffetideen</li>
                <li>Kalkulation und Deklaration</li>
            </ul>
        </p>
        <p>&nbsp;</p>

        <template v-if="form">
            <h3>Anmeldung</h3>
            <fieldset>
                <FrontendForm :form="form"/>
            </fieldset>
        </template>
        <template v-else>
            <Alert title="Anmeldung nicht mehr möglich!" type="warning">
                <span class="margin-bottom-1">Die Anmeldung für dieses Seminar ist leider nicht mehr möglich.</span>
            </Alert>
        </template>

        <p>&nbsp;</p>
        <h3>Über den Referent</h3>
        <Alert title="Astrid Schmitt">
            <p>
                <img src="/images/content/seminare/catering/astrid_schmitt.webp" alt="Astrid Schmitt Portrait" class="radius-s margin-right-1" width="140" style="float: left">
                Seit 20 Jahren als Referentin in den Bereichen Platten- und Partyservice sowie Fingerfood und Geschenkideen tätig.
                Als gelernte Fleischereifachverkäuferin und Fleischermeisterin verfügt sie über fundiertes Fachwissen,
                welches mit dem Studium zur Betriebswirtin optimal ergänzt wurde. Ob als Lehrtätigkeit an Fachschulen oder
                als Fachbuchautorin – Frau Schmitt gibt ihr Wissen und ihre Erfahrung gerne weiter.
            </p>
            <p>
                Website: <a href="https://www.schmittscatering-badkissingen.de" target="_blank" rel="noopener noreferrer">www.schmittscatering-badkissingen.de</a>
            </p>
        </Alert>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import Alert from '@/Components/Alert.vue'
    import Tag from '@/Components/Form/Tag.vue'
    import FrontendForm from '@/Components/Apps/Forms/Frontend/Form.vue'
    
    defineProps({
        form: Object,
    })
</script>

<style lang="sass" scoped>
    .head-grid
        display: grid
        gap: 1rem
        grid-template-columns: auto 1fr
</style>