<template>
    <TextSubLayout title="Datenschutzerklärung" image="/images/content/banner/rechtliches_437198485.webp" has-small-limiter>
        <Head>
            <title>Datenschutzerklärung – FDBS</title>
        </Head>

        <!-- <Alert icon="info" title="Datenschutzerklärungen für unsere Social Media Kanäle">
            <div class="flex center gap wrap" style="margin-bottom: var(--su)">
                <a href="https://itrk.legal/9Vw.76.6Md.html" target="_blank" rel="noopener">Instagram</a><br>
                <a href="https://itrk.legal/9Vw.75.6Md.html" target="_blank" rel="noopener">Facebook</a><br>
                <a href="https://itrk.legal/9Vw.7H.6Md.html" target="_blank" rel="noopener">LinkedIn</a><br>
                <a href="https://itrk.legal/9Vw.7K.6Md.html" target="_blank" rel="noopener">Xing</a><br>
            </div>
        </Alert> -->
        <p>&nbsp;</p>

        <span v-html="text"></span>
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
        color: var(--color-heading)
        display: inline-block
</style>