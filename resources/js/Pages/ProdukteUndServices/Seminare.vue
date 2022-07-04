<template>
    <TextSubLayout title="Seminare" has-small-limiter>
        <Head>
            <title>Produkte & Services: Seminare</title>
        </Head>
        <Alert icon="info" title="Inhalt folgt">
            <span>
                In Kürze werden Sie hier wieder unser breites Angebot an Seminaren und Workshops sehen.<br>
                <br>
                Bei Fragen wenden Sie sich bitte an <b>Elke Grigat</b>:<br>
                Tel.: <a href="tel:0531 210 55 38">0531 210 55 38</a><br>
                Email: <a href="mailto:eg@fdbs.de">eg@fdbs.de</a>
            </span>
        </Alert>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import Alert from '@/Components/Alert.vue'
</script>