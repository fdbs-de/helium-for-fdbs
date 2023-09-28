<template>
    <TextSubLayout title="Impressum" image="/images/content/banner/rechtliches_437198485.webp" has-small-limiter>
        <Head>
            <title>Impressum – FDBS</title>
        </Head>

        <span v-html="text"></span>
        <noscript>
            Sie können diesen Rechtstext nicht sehen, weil Sie JavaScript deaktiviert haben.
            Folgen Sie bitte diesem
            <a target="_blank" href="https://app.cockpit.legal/api/cockpit/resources/legaldocumentshare/ad20360c1ad60f8f5d9223a28907d7ba/document/render/html?language=de">Link</a>,
            um den Rechtstext anzuzeigen.
        </noscript>
        
        <p>&nbsp;</p>
        <div class="formatted-content" v-html="disclaimer"></div>
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