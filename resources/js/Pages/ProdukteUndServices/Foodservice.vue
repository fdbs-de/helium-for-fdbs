<template>
    <ServiceSubLayout title="Unser Foodservice" image="/images/content/test_banner.jpg">
        <Head>
            <title>Produkte & Services: Foodservice</title>
        </Head>

        <template #ansprechpartner>
            <StaffCard class="service-scroll-item" name="Madlen Krause" job="Leitung" leader tel="18" image="/images/content/mitarbeiter/missing.png"/>
            <StaffCard class="service-scroll-item" name="Phil Bartelt" tel="36" image="/images/content/mitarbeiter/phil_bartelt.png" overlay="/images/content/mitarbeiter/phil_bartelt_zeichnung.png"/>
            <StaffCard class="service-scroll-item" name="Silke Künstler" tel="23" image="/images/content/mitarbeiter/silke_kuenstler.png"/>
            <StaffCard class="service-scroll-item" name="Romina Pagano" image="/images/content/mitarbeiter/missing.png"/>
            <StaffCard class="service-scroll-item" name="Yasmin Ruben" tel="32" image="/images/content/mitarbeiter/yasmin_ruben.png"/>
            <StaffCard class="service-scroll-item" name="Angela Schrödter" tel="20" image="/images/content/mitarbeiter/angela_schroedter.png" overlay="/images/content/mitarbeiter/angela_schroedter_zeichnung.png"/>
        </template>

        <Alert icon="info" title="Inhalt folgt">
            In kürze werden Sie hier wieder unser breites Produktportfolio finden.
        </Alert>
    </ServiceSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import ServiceSubLayout from '@/Layouts/SubLayouts/Service.vue'
    import StaffCard from '@/Components/Page/StaffCard.vue'
    import Alert from '@/Components/Alert.vue'
</script>