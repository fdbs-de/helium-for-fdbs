<template>
    <ServiceSubLayout title="Top Aktuelles vom Foodservice" image="/images/content/banner/foodservice_365702048_356901877_454625888.webp">
        <Head>
            <title>Top Aktuelles vom Foodservice – FDBS</title>
        </Head>

        <template #ansprechpartner>
            <StaffCard
                class="service-scroll-item"
                v-for="employee in departments.find(e => e.id === 'vertriebsinnendienst').employees"
                :key="employee.name"
                :name="employee.name"
                :job="employee.leader ? 'Leitung' : null"
                :leader="employee.leader"
                :tel="employee.tel"
                :image="employee.image || '/images/content/mitarbeiter/missing.png'"
                :overlay="employee.overlay"/>
        </template>

        <!-- <Alert icon="info" title="Inhalt folgt">
            In kürze werden Sie hier wieder unser breites Produktportfolio finden.
        </Alert> -->
    </ServiceSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import ServiceSubLayout from '@/Layouts/SubLayouts/Service.vue'
    import StaffCard from '@/Components/Page/StaffCard.vue'
    import Alert from '@/Components/Alert.vue'
    import departments from '@/Pages/Kontakt.json'
</script>