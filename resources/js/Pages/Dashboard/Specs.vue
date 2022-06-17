<template>
    <Head title="Dashboard: Spezificationen" />

    <DashboardSubLayout title="Spezificationen">
        <template #head>
            <mui-input class="search-input" no-border placeholder="Suchen" icon-left="search" v-model="search" @input="throttledGetSpecs" />
        </template>
        
        <div class="grid">
            <div class="row head">
                <b>&nbsp;</b>
                <b>Spezificationsnummer</b>
                <b>&nbsp;</b>
            </div>
            <div class="row" v-for="spec in specs" :key="spec.name">
                <div class="icon">file_copy</div>
                <span v-if="spec.name">{{spec.name}}</span>
                <span class="flex h-end">
                    <a :href="spec.url" target="_blank">Download</a>
                </span>
            </div>
        </div>
    </DashboardSubLayout>
</template>

<script setup>
    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
    import { ref } from 'vue'

    const specs = ref([])
    const search = ref('')

    const getSpecs = async () => {
        try
        {
            let response = await axios.get(route('dashboard.customer.specs.index', {search: search.value}))
            
            specs.value = response.data
        }
        catch (error) { console.error(error) }
    }

    getSpecs()

    const throttledGetSpecs = _.throttle(getSpecs, 1000)
</script>

<style lang="sass" scoped>
    .search-input
        height: 2.5rem
        flex: 1

    .grid
        display: flex
        flex-direction: column
        width: 100%
        padding-block: 1rem

        .row
            display: grid
            align-items: center
            grid-template-columns: 2.5rem 1fr 150px
            gap: var(--su)
            height: 3rem
            padding: 0 1rem

            .icon
                font-family: var(--font-icon)
                font-size: 1.5rem
                line-height: 1
                text-align: center
                color: var(--color-text)
                user-select: none

                &.notified
                    color: var(--color-warning)

                &.active
                    color: var(--color-primary)

            &:hover:not(.head)
                background: var(--color-background-soft)

    .user-popup
        .head
            display: flex
            align-items: center
            padding: 1.5rem
            background: var(--color-primary)
            border-radius: .5rem .5rem 0 0
            color: var(--color-background)

            --primary: var(--color-background)
            --primary-contrast: var(--color-primary)

            h3,
            p
                width: 100%
                overflow: hidden
                text-overflow: ellipsis
                white-space: nowrap
                margin: 0
                color: inherit

            p
                opacity: .8
                margin-bottom: 1.25rem

            .tag
                color: inherit

        .popup-row
            display: flex
            align-items: center
            height: 6rem
            padding: 0 var(--su)
            margin-bottom: .5rem

            i
                opacity: .7

        .footer
            padding: .75rem var(--su)
            background: var(--color-background-soft)

            p
                margin: 0
                font-size: .8rem
</style>