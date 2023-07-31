<template>
    <TextSubLayout title="Kreativworkshop mit EDNA International GmbH und Salomon FoodWorld" image="/images/content/seminare/kreativworkshop/kreativworkshop_header.webp" color="white" has-small-limiter>
        <Head>
            <title>Kreativworkshop mit EDNA International GmbH und Salomon FoodWorld – FDBS Seminare</title>
        </Head>

        <Alert title="Wichtiges im Überblick:">
            <div class="head-grid">
                <span>Datum:</span>
                <span><b>08. Mai 2023</b></span>
                
                <span style="line-height: 1.4">Uhrzeit:</span>
                <span style="line-height: 1.4"><b>14:00 - ca. 17:00</b><br><small>(inkl. Pausenzeiten)</small></span>
                
                <span>Seminargebühren:</span>
                <span>
                    <Tag shape="pill" color="var(--color-green)"><b>40,00 €</b></Tag>
                </span>
            </div>
        </Alert>
        <p>&nbsp;</p>

        <h3>Kreative Ideen für Ihren Snack- und Cateringservice!</h3>
        <p>
            Lassen Sie sich inspirieren von unseren starken Partnern EDNA International GmbH und Salomon FoodWorld.
            Die richtige Inszenierung von Convenience in Verbindung mit handwerklichem Knowhow ist die Grundlage für optimale
            Kalkulation und Individualität. Wie das am besten gelingt, wollen wir Ihnen in diesem Workshop zeigen, denn das
            Auge isst ja sprichwörtlich mit. Dennoch soll der kulinarische Genuss nicht zu kurz kommen und Sie haben natürlich
            die Möglichkeit alle Produkte auch zu verkosten...
        </p>
        <h3>Was erwartet Sie in diesem Workshop...</h3>
        <p>...neben den vielen Tipps zur Verwendung, Weiterverarbeitung und Präsentation?</p>
        <p>
            <ul>
                <li>Ideen für das Snackgeschäft</li>
                <li>Burger – der Klassiker, der sich immer wieder neu erfindet!</li>
                <li>Trendthema: vegane und vegetarische Variationen</li>
            </ul>
        </p>
        <p>
            Und hoffentlich den Gedanken: „...ja super, das übernehmen wir für unseren Betrieb!“
        </p>
        <p>
            Weil wir Sie dabei unterstützen wollen, wird die Teilnehmergebühr in Höhe von 40€ beim Kauf der Produkte,
            von den teilnehmenden Firmen, innerhalb von 4 Wochen ab Veranstaltung umgewandelt in einen Wertgutschein,
            der verrechnet wird. 
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