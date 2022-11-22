<template>
    <Head>
        <title>Unsere Stellenangebote</title>
    </Head>

    <TextSubLayout title="Unsere Stellenangebote" image="/images/content/banner/karriere_513169496_482949832.webp">
        <div class="wrapper">
            <div class="searchbar">
                <input type="text" placeholder="Stelle suchen" v-model="filterParameter.search">
                <div class="bar-divider"></div>
                <select v-model="filterParameter.type">
                    <option :value="null">Alle Arten</option>
                    <option value="vollzeit">Vollzeit</option>
                    <option value="ausbildung">Ausbildung</option>
                    <option value="duales studium">Duales Studium</option>
                </select>
                <div class="bar-divider"></div>
                <select v-model="filterParameter.category">
                    <option :value="null">Alle Felder</option>
                    <option value="logistik">Logistik</option>
                    <option value="marketing">Marketing</option>
                    <option value="service">Service</option>
                    <option value="vertrieb">Vertrieb</option>
                    <option value="verwaltung">Verwaltung</option>
                </select>
            </div>

            <div class="grid" v-if="filteredJobs.length">
                <Card v-for="job in filteredJobs" cover new-window
                    aspect-ratio="16/9"
                    :key="job.id"
                    :name="job.name"
                    :primary-tag="job.primary_tag"
                    :tags="strToTags(job.tags)"
                    :image="route('docs.cover', job.slug)"
                    :link="route('docs', job.slug)"
                />
            </div>
            
            <div class="placeholder" v-else>
                <p v-if="jobs.length === 0">Wir schreiben zurzeit keine Stellen aus.</p>
                <p v-else>Keine Stellenangebote gefunden.</p>
            </div>

            <small class="margin-top-1 text-align-center">
                <b>Alle Stellen</b> verstehen sich ausgeschrieben für <b>M/W/D</b>
            </small>
        </div>

        <Benefits />
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import Card from '@/Components/Page/Card.vue'
    import Benefits from '@/Components/Page/Karriere/Benefits.vue'
    import { ref, computed } from 'vue'

    const props = defineProps({
        jobs: Array,
    })

    const strToTags = (string) => {
        return string?.split(',')?.map(tag => tag.trim()) ?? []
    }

    const filterParameter = ref({
        search: '',
        type: null,
        category: null,
    })

    const filteredJobs = computed(() => {
        return props.jobs.filter(job => {
            if (filterParameter.value.search.trim() && !job?.name?.toLowerCase().trim().includes(filterParameter.value.search.toLowerCase().trim())) return false
            if (filterParameter.value.type          && job?.primary_tag?.toLowerCase() !== filterParameter.value.type) return false
            if (filterParameter.value.category      && !strToTags(job?.tags?.toLowerCase() || '').includes(filterParameter.value.category)) return false

            return true
        })
    })
</script>

<style lang="sass" scoped>
    .wrapper
        display: flex
        flex-direction: column
        padding: 0 3rem 3rem
        gap: 1.5rem
        background: var(--color-background-soft)
        border-radius: var(--radius-xl)
        margin-block: 1.75rem 8rem

        .searchbar
            transform: translateY(-1.75rem)
            height: 3.5rem
            display: flex
            align-items: stretch
            border-radius: var(--radius-m)
            background: var(--color-background)
            box-shadow: var(--shadow-elevation-medium)
            overflow: hidden
            gap: .5rem
            border: 1px solid var(--color-background-soft)

            .bar-divider
                margin-block: .5rem
                border-left: 1px solid var(--color-background-soft)

            > input
                flex: 1
                padding: 0 1rem
                border: none
                border-radius: 0
                background: transparent
                font-size: 1.2rem
                font-weight: 600
                font-family: var(--font-heading)
                color: inherit
                min-width: 0

            > select
                height: auto
                padding: 0 1rem 0 .5rem
                border: none
                border-radius: 0
                background: transparent
                font-weight: 400
                font-size: 1rem
                font-family: var(--font-heading)
                color: inherit

            > input,
            > select
                &:focus
                    outline: none
                    color: var(--color-primary)

        .grid
            display: grid !important
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr))
            gap: 3rem

        .placeholder
            display: flex
            align-items: center
            justify-content: center
            height: 12rem
            font-size: 1.2rem
            color: var(--color-heading)



    @media only screen and (max-width: 700px)
        .wrapper
            gap: .25rem
            padding: 0 1rem 1rem
            margin-top: 3rem

            .searchbar
                display: grid
                grid-template-columns: 1fr 1fr
                grid-template-rows: 3rem 3rem
                grid-template-areas: "search search" "type category"
                height: auto
                gap: 0
                transform: translateY(-3rem)

                .bar-divider
                    display: none

                > select
                    height: 100%
                    width: 100%
                    padding: 0 1rem

                > input
                    height: 100%
                    width: 100%
                    padding: 0 1rem
                    font-size: 1rem
                    grid-area: search
                    border-bottom: 1px solid var(--color-background-soft)

            .grid
                gap: 2rem
</style>