<template>
    <Head title="Spezifikations Datenbank" />

    <DashboardSubLayout title="Spezifikations Datenbank">
        <template #head>
            <mui-input class="search-input" type="search" no-border placeholder="Suchen" icon-left="search" v-model="search" @input="throttledFetch" />
            <Loader class="loader" v-show="loading" />
        </template>

        <PaginationBar class="margin-block-1" v-if="pagination.data.length" :from="pagination.from" :to="pagination.to" :total="pagination.total" @prev="prevPage" @next="nextPage"/>

        <div class="grid" v-if="pagination.data.length">
            <div class="row" v-for="item in pagination.data" :key="item.name">
                <div class="icon" aria-hidden="true">description</div>
                <span class="text">{{item.name}}</span>
                <span class="flex h-end">
                    <mui-button as="a" :href="route('dashboard.customer.specs.download', {name: item.name})" target="_blank" label="Download" size="small" variant="contained" />
                </span>
            </div>
        </div>

        <div class="placeholder" v-else>
            Es wurden keine Spezifikationen gefunden.
        </div>

        <PaginationBar class="margin-top-1" v-if="pagination.data.length" :from="pagination.from" :to="pagination.to" :total="pagination.total" @prev="prevPage" @next="nextPage"/>
        
    </DashboardSubLayout>
</template>

<script setup>
    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import Loader from '@/Components/Form/Loader.vue'
    import PaginationBar from '@/Components/Form/PaginationBar.vue'
    import { ref } from 'vue'



    const pagination = ref({ data: [] })
    const search = ref('')
    const loading = ref(true)



    const fetch = async () => {
        loading.value = true

        try
        {
            let response = await axios.get(route('dashboard.customer.specs.search', {
                page: pagination.value.current_page ?? 1,
                search: search.value,
            }))

            pagination.value = response.data
        }
        catch (error)
        {
            console.log(error.response)
        }
        
        loading.value = false
    }

    const throttledFetch = _.throttle(fetch, 300)

    fetch()



    const nextPage = () => {
        pagination.value.current_page++
        throttledFetch()
    }

    const prevPage = () => {
        pagination.value.current_page--
        throttledFetch()
    }
</script>

<style lang="sass" scoped>
    .search-input
        height: 2.5rem
        width: 100%
        max-width: 400px

    .loader
        position: absolute
        bottom: -2px
        height: 2px
        left: 0

    .placeholder
        display: flex
        align-items: center
        justify-content: center
        text-align: center
        height: 220px
        width: 100%

    .grid
        display: flex
        flex-direction: column
        width: 100%

        .row
            display: grid
            align-items: center
            grid-template-columns: 2.5rem 1fr auto
            gap: 1rem
            height: 3rem
            padding: 0 1rem 0 0
            border-radius: var(--radius-m)

            .text
                white-space: nowrap
                overflow: hidden
                text-overflow: ellipsis

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

    @media only screen and (max-width: 500px)
        .grid
            .row
                grid-template-columns: 1fr auto

                .icon
                    display: none
</style>