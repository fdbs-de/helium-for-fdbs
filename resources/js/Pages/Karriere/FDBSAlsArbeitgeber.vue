<template>
    <Head>
        <title>FDBS als Arbeitgeber</title>
    </Head>

    <TextSubLayout title="FDBS als Arbeitgeber">
        <div class="wrapper">
        </div>

        <Benefits />
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import Card from '@/Components/Page/Card.vue'
    import Benefits from '@/Components/Page/Karriere/Benefits.vue'
</script>

<style lang="sass" scoped>
    .wrapper
        display: grid !important
        grid-template-columns: repeat(3, 1fr)
        gap: 3rem



    @media only screen and (max-width: 1000px)
        .wrapper
            grid-template-columns: repeat(2, 1fr)



    @media only screen and (max-width: 700px)
        .wrapper
            grid-template-columns: repeat(1, 1fr)
</style>