<template>
    <Head title="Dashboard: Spezificationen verwalten" />

    <DashboardSubLayout title="Spezificationen verwalten">
        <template #head>
            <mui-input class="search-input" type="search" no-border placeholder="Suchen" icon-left="search" v-model="search" @input="throttledGetSpecs" />
            <Loader class="loader" v-show="loading" />
        </template>

        <input type="file" ref="filesInput" multiple @input="uploadSpecs($event.target.files)" accept="application/pdf,application/vnd.ms-excel" />

        <PaginationBar v-if="specs.length" :page="page" :length="specs.length" :total="total" @prev="prevPage" @next="nextPage"/>

        <div class="grid" v-if="specs.length">
            <div class="row" v-for="spec in specs" :key="spec.name">
                <div class="icon" aria-hidden="true">description</div>
                <span class="text" v-if="spec.name">{{spec.name}}</span>
                <span class="flex h-end">
                    <a :href="spec.url" target="_blank">Ansehen</a>
                </span>
            </div>
        </div>

        <div class="placeholder" v-else>
            Es wurden keine Spezifikationen gefunden.
        </div>

        <PaginationBar v-if="specs.length" :page="page" :length="specs.length" :total="total" @prev="prevPage" @next="nextPage"/>
        
    </DashboardSubLayout>
</template>

<script setup>
    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
    import Loader from '@/Components/Form/Loader.vue'
    import PaginationBar from '@/Components/Form/PaginationBar.vue'
    import { ref } from 'vue'

    const specs = ref([])
    const search = ref('')
    const total = ref(0)
    const page = ref(1)
    const lastPage = ref(1)
    const loading = ref(true)

    const filesInput = ref(null)



    const getSpecs = async () => {
        loading.value = true

        try
        {
            let response = await axios.get(route('dashboard.customer.specs.search', {
                search: search.value,
                page: page.value,
            }))

            specs.value = response.data.items
            lastPage.value = response.data.last_page
            total.value = response.data.total
            page.value = Math.max(Math.min(page.value, lastPage.value), 1)
        }
        catch (error)
        {
            console.error(error)
        }
        
        loading.value = false
    }

    const throttledGetSpecs = _.throttle(getSpecs, 1000)

    getSpecs()



    const nextPage = () => {
        page.value = Math.min(page.value + 1, lastPage.value)
        getSpecs()
    }

    const prevPage = () => {
        page.value = Math.max(page.value - 1, 1)
        getSpecs()
    }



    const uploadSpecs = (files) => {
        if (files.length <= 0) return

        useForm({files}).post(route('dashboard.admin.specs.upload'), {
            onSuccess() {
                getSpecs()
                filesInput.value.value = ''
            },

            onError(error) {
                console.error(error)
            }
        })
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
            gap: var(--su)
            height: 3rem
            padding: 0 1rem

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