<template>
    <LongTextSubLayout title="Videoüberwachung">
        <Head>
            <title>Infos zur Videoüberwachung</title>
        </Head>

        <Alert icon="info">
            <p>
                Mit diesem Infoschreiben zur Videoüberwachung klären wir Sie über Ihre umfangreichen Rechte aus der DSGVO auf.<br>
                <a href="/downloads/info/infoschreiben_videoueberwachung.pdf" target="_blank" rel="noopener noreferrer">Infoschreiben herunterladen</a>
            </p>
        </Alert>
    </LongTextSubLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3'
import LongTextSubLayout from '@/Layouts/SubLayouts/LongText.vue'
import Alert from '@/Components/Alert.vue'
</script>