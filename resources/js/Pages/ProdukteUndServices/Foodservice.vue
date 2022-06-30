<template>
    <ServiceSubLayout title="Unser Foodservice" image="/images/content/test_banner.jpg">
        <Head>
            <title>Produkte & Services: Foodservice</title>
        </Head>

        <template #ansprechpartner>
            <StaffCard class="service-scroll-item" name="Silke Künstler" link="tel:0531 210 55 23" label="0531 210 55 23" image="/images/content/mitarbeiter/silke_kuenstler.png" alt="Portrait von Silke Künstler"/>
            <StaffCard class="service-scroll-item" name="Romina Pagano" link="tel:0531 210 55 28" label="0531 210 55 28" image="/images/content/mitarbeiter/missing.png" alt="Portrait von Romina Pagano"/>
            <StaffCard class="service-scroll-item" name="Yasmin Ruben" link="tel:0531 210 55 32" label="0531 210 55 32" image="/images/content/mitarbeiter/yasmin_ruben.png" alt="Portrait von Yasmin Ruben"/>
            <StaffCard class="service-scroll-item" name="Phil Bartelt" link="tel:0531 210 55 36" label="0531 210 55 36" image="/images/content/mitarbeiter/phil_bartelt.png" alt="Portrait von Phil Bartelt"/>
            <StaffCard class="service-scroll-item" name="Madlen Krause" link="tel:0531 210 55 18" label="0531 210 55 18" image="/images/content/mitarbeiter/missing.png" alt="Portrait von Madlen Krause"/>
        </template>

        <Alert icon="info" type="info" title="Inhalt folgt">
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