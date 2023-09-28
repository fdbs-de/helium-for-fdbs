<template>
    <TextSubLayout title="Datenschutzerklärung" image="/images/content/banner/rechtliches_437198485.webp" has-small-limiter>
        <Head>
            <title>Datenschutzerklärung – FDBS</title>
        </Head>
        <p>&nbsp;</p>

        <span v-html="text"></span>
        <noscript>
            Sie können diesen Rechtstext nicht sehen, weil Sie JavaScript deaktiviert haben.
            Folgen Sie bitte diesem
            <a target="_blank" href="https://app.cockpit.legal/api/cockpit/resources/legaldocumentshare/1785cff273aedbd875c814b46928ad7f/document/render/html?language=de">Link</a>,
            um den Rechtstext anzuzeigen.
        </noscript>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import Alert from '@/Components/Alert.vue'
    import { ref } from 'vue'

    const text = ref('')

    fetch(`https://app.cockpit.legal/api/cockpit/resources/legaldocumentshare/1785cff273aedbd875c814b46928ad7f/document/render/html?language=de`)
        .then(result => result.text())
        .then(content => { text.value = content })
</script>

<style lang="sass" scoped>
    .last-updated
        border-radius: .325rem
        padding: .5rem 1rem
        background-color: var(--color-background-soft)
        color: var(--color-text)
        display: inline-block
</style>