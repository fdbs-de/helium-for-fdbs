<template>
    <Head>
        <title>Studium und Ausbildung bei FDBS</title>
    </Head>

    <TextSubLayout title="Studium und Ausbildung bei FDBS">
        <div class="wrapper">
            <Card v-for="job in jobs" cover new-window
                aspect-ratio="16/9"
                :key="job.id"
                :name="job.name"
                :primary-tag="job.primary_tag"
                :tags="strToTags(job.tags)"
                :image="route('docs.cover', job.slug)"
                :link="route('docs', job.slug)"
            />
        </div>

        <Benefits />
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import Card from '@/Components/Page/Card.vue'
    import Benefits from '@/Components/Page/Karriere/Benefits.vue'

    defineProps({
        jobs: Array,
    })

    const strToTags = (string) => {
        return string?.split(',')?.map(tag => tag.trim()) ?? []
    }
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