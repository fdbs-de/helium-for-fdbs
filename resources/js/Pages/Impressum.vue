<template>
    <TextSubLayout title="Impressum" image="/images/content/banner/rechtliches_437198485.webp" has-small-limiter>
        <Head>
            <title>Impressum</title>
        </Head>

        <span v-html="text"></span>
        <p>&nbsp;</p>
        <div class="formatted-content" v-html="disclaimer"></div>
        <!-- <p>
            <b>Fleischer-Dienst Braunschweig eG</b><br>
            Christian-Pommer-Straße 31/33<br>
            38112 Braunschweig<br>
            Deutschland<br>
            <br>
            Tel.: <a href="tel:0531210550">0531 210 55 0</a><br>
            Fax: 0531 210 55 39<br>
            E-Mail: <a href="mailto:info@fdbs.de">info@fdbs.de</a><br>
            <br>
            Umsatzsteuer-Identifikationsnummer gemäß § 27 a Umsatzsteuergesetz: DE 114814846<br>
            <br>
            Plattform der EU-Kommission zur Online-Streitbeilegung: <a href="https://ec.europa.eu/odr" target="_blank" rel="noopener">https://ec.europa.eu/odr</a><br>
            <br>
            Wir sind zur Teilnahme an einem Streitbeilegungsverfahren vor einer Verbraucherschlichtungsstelle weder verpflichtet noch bereit.<br>
            <br>
            Vorstand: <b>Sebastian Gerlach, Jens Löser</b><br>
            Vorstand (ehrenamtlich): <b>Jens Neubauer</b><br>
            Vorsitzender des Aufsichtsrats: <b>Frank Schreiber</b><br>
            Genossenschaftsregister: <b>Amtsgericht Braunschweig</b><br>
            Registernummer: <b>GenR 305</b>
        </p>
        
        <h2>Bildnachweis:</h2>
        <p>
            ©HBS, ©NDABCREATIVITY, ©Cristalov, ©littlewolf1989, ©New Africa, ©ikonoklast_hh,
            ©StudioDFlorez, ©laplateresca, ©NVB Stocker, ©Prostock-studio, ©Rawpixel.com, ©Looker_Studio
            ©assetseller, ©Racle Fotodesign, ©Paul Bradbury/KOTO, ©Pixel-Shot, ©Robert Kneschke, ©Drobot Dean, ©contrastwerkstatt,
            ©Оля Molly, ©Simple Line, ©torik, ©mitay20, ©Екатерина Заносиенко, ©Yana, ©Sell Vector, ©Olga Rai, ©Mihail, ©sahs94,
            ©Valenty, ©Natalia, ©samuii, ©ngupakarti, ©MuhammadZulfan, ©LuckyStep
            - <a href="https://stock.adobe.com" target="_blank" ref="noopener noreferrer">Adobe Stock</a>
        </p> -->
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import { ref } from 'vue'

    defineProps({
        disclaimer: String,
    })

    const text = ref('')

    fetch(`https://app.cockpit.legal/api/cockpit/resources/legaldocumentshare/ad20360c1ad60f8f5d9223a28907d7ba/document/render/html`)
        .then(result => result.text())
        .then(content => { text.value = content })
</script>