<template>
    <ServiceSubLayout title="Marketing & Kommunikation" image="/images/content/test_banner.jpg">
        <Head>
            <title>Produkte & Services: Marketing & Kommunikation</title>
        </Head>

        <template #ansprechpartner>
            <StaffCard class="service-scroll-item" name="Benjamin Vahle" link="tel:0531 210 55 16" label="0531 210 55 16" image="/images/content/test_pfp.jpg" alt="Portrait von Benjamin Vahle"/>
            <StaffCard class="service-scroll-item" name="Franziska Brandt" link="tel:0531 210 55 51" label="0531 210 55 51" image="/images/content/test_pfp.jpg" alt="Portrait von Franziska Brandt"/>
            <StaffCard class="service-scroll-item" name="Maurice Freuwört" link="tel:0531 210 55 73" label="0531 210 55 73" image="/images/content/test_pfp.jpg" alt="Portrait von Maurice Freuwört"/>
            <StaffCard class="service-scroll-item" name="Franziska Wolff" link="tel:0531 210 55 25" label="0531 210 55 25" image="/images/content/test_pfp.jpg" alt="Portrait von Franziska Wolff"/>
            <StaffCard class="service-scroll-item" name="Carolin Götzner" link="tel:0531 210 55 43" label="0531 210 55 43" image="/images/content/test_pfp.jpg" alt="Portrait von Carolin Götzner"/>
            <StaffCard class="service-scroll-item" name="Annika Görmann" link="tel:0531 210 55 72" label="0531 210 55 72" image="/images/content/test_pfp.jpg" alt="Portrait von Annika Görmann"/>
        </template>

        <p>
            Wir freuen uns, dass Sie Interesse an unseren Produkten haben und möchten Ihnen mit
            unserer eigenen Website einen kleinen Einblick in unser Produktportfolio geben:<br><br>
            <a href="https://marketing-bs.de" target="_blank">marketing-bs.de</a>
        </p>
    </ServiceSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import ServiceSubLayout from '@/Layouts/SubLayouts/Service.vue'
    import StaffCard from '@/Components/Page/StaffCard.vue'
</script>