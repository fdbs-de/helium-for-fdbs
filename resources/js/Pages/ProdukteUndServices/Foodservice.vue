<template>
    <ServiceSubLayout title="Unser Foodservice" image="/images/content/test_banner.jpg">
        <Head>
            <title>Produkte & Services: Foodservice</title>
        </Head>

        <template #ansprechpartner>
            <StaffCard class="service-scroll-item" name="Madlen Krause" link="tel:0531 210 55 18" label="0531 210 55 18" image="/images/content/test_pfp.jpg" alt="Portrait von Madlen Krause"/>
            <StaffCard class="service-scroll-item" name="Silke Künstler" link="tel:0531 210 55 23" label="0531 210 55 23" image="/images/content/test_pfp.jpg" alt="Portrait von Silke Künstler"/>
            <StaffCard class="service-scroll-item" name="Romina Pagano" link="tel:0531 210 55 28" label="0531 210 55 28" image="/images/content/test_pfp.jpg" alt="Portrait von Romina Pagano"/>
            <StaffCard class="service-scroll-item" name="Yasmin Ruben" link="tel:0531 210 55 32" label="0531 210 55 32" image="/images/content/test_pfp.jpg" alt="Portrait von Yasmin Ruben"/>
            <StaffCard class="service-scroll-item" name="Phil Bartelt" link="tel:0531 210 55 36" label="0531 210 55 36" image="/images/content/test_pfp.jpg" alt="Portrait von Phil Bartelt"/>
        </template>

        <p>
        </p>
    </ServiceSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import ServiceSubLayout from '@/Layouts/SubLayouts/Service.vue'
    import StaffCard from '@/Components/Page/StaffCard.vue'
</script>