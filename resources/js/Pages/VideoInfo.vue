<template>
    <TextSubLayout title="Videoüberwachung" has-small-limiter>
        <Head>
            <title>Infos zur Videoüberwachung</title>
        </Head>

        <Alert icon="info">
            <p>
                Mit diesem Infoschreiben zur Videoüberwachung klären wir Sie über Ihre umfangreichen Rechte aus der DSGVO auf.<br>
                <a href="/downloads/info/infoschreiben_videoueberwachung.pdf" target="_blank" rel="noopener noreferrer">Infoschreiben herunterladen</a>
            </p>
        </Alert>
    </TextSubLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3'
import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
import Alert from '@/Components/Alert.vue'
</script>