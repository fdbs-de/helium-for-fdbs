<template>
    <TextSubLayout title="Unsere Aktuellen Angebote">
        <Head>
            <title>Unsere Aktuellen Angebote</title>
        </Head>
        <div class="grid">
            <!-- <Card name="Unser Monatsangebot für Juli 2022" alt="Unser Monatsangebot für Juli 2022" image="/images/content/flyer/monatsangebot_07_2022_op.jpg" new-window link="/downloads/flyer/monatsangebot_07_2022_op.pdf"/>
            <Card name="Unser Grillangebot für 2022" alt="Unser Grillangebot für 2022" image="/images/content/flyer/grillflyer_2022.jpg" new-window link="/downloads/flyer/grillflyer_2022.pdf"/>
            <Card name="Unsere Neuheiten" alt="Unsere Neuheiten" image="/images/content/flyer/neuheitenflyer_07_2022_op.jpg" new-window link="/downloads/flyer/neuheitenflyer_07_2022_op.pdf"/> -->

            <Card v-for="angebot in angebote" new-window
                :key="angebot.id"
                :name="angebot.name"
                :alt="angebot.cover_alt"
                :cover="angebot.cover_size === 'cover'"
                :image="route('docs.cover', angebot.slug)"
                :link="route('docs', angebot.slug)"
            />
        </div>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import Card from '@/Components/Page/Card.vue'

    defineProps({
        angebote: Array,
    })
</script>

<style lang="sass" scoped>
    .grid
        display: grid
        gap: 3rem
        margin-top: 3rem
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr))
</style>