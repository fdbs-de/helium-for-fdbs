<template>
    <TextSubLayout title="Aktivworkshop „Käse affinieren und veredeln“" image="/images/content/seminare/kaeseworkshop/kaeseworkshop_header_223302273.webp" color="var(--color-primary)" has-small-limiter>
        <Head>
            <title>Aktivworkshop „Käse affinieren und veredeln“ – FDBS Seminare</title>
        </Head>

        <Alert title="Wichtiges im Überblick:">
            <div class="head-grid">
                <span>Datum:</span>
                <span><b>05. Juni 2023</b></span>
                
                <span style="line-height: 1.4">Uhrzeit:</span>
                <span style="line-height: 1.4"><b>14:00 - ca. 17:30</b></span>

                <span>Referent:</span>
                <span><b>Elke Grigat; Diplom Käsesommelière</b></span>
                
                <span>Seminargebühren:</span>
                <span>
                    <Tag shape="pill" color="var(--color-green)"><b>95,00 €</b></Tag><br>
                    <small>(zzgl. MwSt.)</small>
                </span>

                <span>Teilnehmerzahl:</span>
                <span>
                    <Tag shape="pill" color="var(--color-red)"><b>begrenzt</b></Tag>
                </span>
            </div>
        </Alert>
        <p>&nbsp;</p>

        <p>
            In diesem Seminar möchte ich gemeinsam mit Ihnen die unterschiedlichsten Kreationen mit Käse herstellen.
            Setzen Sie Highlights in Ihrer Theke oder punkten Sie mit selbstzubereiteten Variationen im Catering bei
            Ihrer Plattengestaltung und für trendige Frühstücksbuffets.
        </p>
        <p>
            <ul>
                <li>Diverse Frischkäsezubereitungen</li>
                <li>Neue Ideen für Käsetorten von groß bis ganz klein</li>
                <li>Fingerfood-Ideen</li>
                <li>Akzente für Käseplatten und Buffets</li>
            </ul>
        </p>
        <p>
            Bevor wir jedoch zum Praxisteil übergehen, möchte ich Ihnen die Grundlagen des Affinierens näherbringen.
            Lassen Sie sich kurz in die Welt der Aromatik und des Food Pairings entführen.
        </p>
        <p>
            Alles, was wir in kleinen Gruppen in diesem Workshop herstellen, wird zu einem abwechslungsreichen Buffet
            arrangiert, welches zum Abschluss von allen Teilnehmern verkostet wird. Ausgestattet mit allen Rezepturen
            und ganz viel Inspiration, können Sie nach diesem Work-shop, Ihre Favoriten voller Elan in Ihrem Betrieb ausprobieren.
        </p>
        <p>
            Bringen Sie bitte Ihre Arbeitskleidung mit, da es sich um einen Aktivworkshop handelt.
            Ware und Arbeitsmaterial haben wir für Sie vor Ort vorbereitet.
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
        <h3>Über die Referenten</h3>
        <Alert title="Elke Grigat">
            <p>
                <img src="/images/content/seminare/kaeseworkshop/elke_grigat.webp" alt="Elke Grigat Portrait" class="radius-s margin-right-1" width="140" style="float: left">
                Seit über 25 Jahren beim FDBS im Bereich Käse tätig.
                In dieser Zeit ist eine Fülle an Erfahrung und Wissen zusammen gekommendie durch
                die Ausbildung zur Ernährungsberaterin nochabgerundet wurde.
                Weitere Schwerpunkte: individuelleSchulungen, Thekengestaltung und Verkaufsaktionen.
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