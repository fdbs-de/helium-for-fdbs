<template>
    <ServiceSubLayout title="Marketing & Kommunikation">
        <Head>
            <title>Produkte & Services: Marketing & Kommunikation</title>
        </Head>

        <template #ansprechpartner>
            <StaffCard class="service-scroll-item" name="Benjamin Vahle" job="Leitung" leader tel="16" image="/images/content/mitarbeiter/benjamin_vahle.png" overlay="/images/content/mitarbeiter/benjamin_vahle_zeichnung.png"/>
            <StaffCard class="service-scroll-item" name="Franziska Brandt" tel="51" image="/images/content/mitarbeiter/franziska_brandt.png" overlay="/images/content/mitarbeiter/franziska_brandt_zeichnung.png"/>
            <StaffCard class="service-scroll-item" name="Maurice Freuwört" tel="73" image="/images/content/mitarbeiter/maurice_freuwoert.png" overlay="/images/content/mitarbeiter/maurice_freuwoert_zeichnung.png"/>
            <StaffCard class="service-scroll-item" name="Annika Görmann" tel="72" image="/images/content/mitarbeiter/annika_goermann.png" overlay="/images/content/mitarbeiter/annika_goermann_zeichnung.png"/>
            <StaffCard class="service-scroll-item" name="Carolin Götzner" tel="43" image="/images/content/mitarbeiter/carolin_goetzner.png" overlay="/images/content/mitarbeiter/carolin_goetzner_zeichnung.png"/>
            <StaffCard class="service-scroll-item" name="Julia Kirschner" tel="13" image="/images/content/mitarbeiter/julia_kirschner.png" overlay="/images/content/mitarbeiter/julia_kirschner_zeichnung.png"/>
            <StaffCard class="service-scroll-item" name="Sophie Quast" tel="79" image="/images/content/mitarbeiter/missing.png"/>
            <StaffCard class="service-scroll-item" name="Franziska Wolff" image="/images/content/mitarbeiter/franziska_wolff.png" overlay="/images/content/mitarbeiter/franziska_wolff_zeichnung.png"/>
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