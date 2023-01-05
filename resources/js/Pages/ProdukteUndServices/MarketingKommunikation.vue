<template>
    <ServiceSubLayout title="Marketing & Kommunikation" image="/images/content/banner/mkbs_358814027_359715993_357394407.webp">
        <Head>
            <title>Produkte & Services: Marketing & Kommunikation</title>
        </Head>

        <template #ansprechpartner>
            <StaffCard
                class="service-scroll-item"
                v-for="employee in departments.find(e => e.id === 'marketing').employees"
                :key="employee.name"
                :name="employee.name"
                :job="employee.leader ? 'Leitung' : null"
                :leader="employee.leader"
                :tel="employee.tel"
                :image="employee.image || '/images/content/mitarbeiter/missing.png'"
                :overlay="employee.overlay"/>
        </template>

        <p>
            Diese Unterseite befinded sich momentan im Umbruch.<br>
            Sehr bald werden Sie unsere genialen Marketingleistungen hier finden.
        </p>
    </ServiceSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import departments from '@/Pages/Kontakt.json'
    
    import ServiceSubLayout from '@/Layouts/SubLayouts/Service.vue'
    import StaffCard from '@/Components/Page/StaffCard.vue'
</script>