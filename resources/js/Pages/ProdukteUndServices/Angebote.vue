<template>
    <TextSubLayout title="Unsere aktuellen Angebote" image="/images/content/banner/angebote_526077708.webp">
        <Head>
            <title>Unsere aktuellen Angebote – FDBS</title>
        </Head>
        <div class="grid">
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
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr))
</style>