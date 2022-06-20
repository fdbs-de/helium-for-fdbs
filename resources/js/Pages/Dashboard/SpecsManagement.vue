<template>
    <Head title="Dashboard: Spezificationen verwalten" />

    <DashboardSubLayout title="Spezificationen verwalten">
        <template #head>
            <mui-input class="search-input" type="search" no-border placeholder="Suchen" icon-left="search" v-model="search" @input="throttledFetch" />
            <mui-button variant="contained" size="small" label="Refresh Cache" @click="recache()"/>
            <Loader class="loader" v-show="loading" />
        </template>

        <div class="upload-wrapper">
            <label class="button" for="files-input" role="button" tabindex="0">Dateien hochladen (max. 1000)</label>
            <input type="file" id="files-input" ref="filesInput" multiple @input="upload($event.target.files)" accept="application/pdf,application/vnd.ms-excel" />
        </div>


        <PaginationBar v-if="pagination.data.length" :from="pagination.from" :to="pagination.to" :total="pagination.total" @prev="prevPage" @next="nextPage"/>

        <div class="grid" v-if="pagination.data.length">
            <div class="row" v-for="item in pagination.data" :key="item.name">
                <div class="icon" aria-hidden="true">description</div>
                <span class="text">{{item.name}}</span>
                <span class="flex h-end">
                    <a :href="route('dashboard.customer.specs.download', {name: item.name})" target="_blank">Ansehen</a>
                </span>
            </div>
        </div>

        <div class="placeholder" v-else>
            Es wurden keine Spezifikationen gefunden.
        </div>

        <PaginationBar v-if="pagination.data.length" :from="pagination.from" :to="pagination.to" :total="pagination.total" @prev="prevPage" @next="nextPage"/>
        
    </DashboardSubLayout>
</template>

<script setup>
    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
    import { Inertia } from '@inertiajs/inertia'
    import Loader from '@/Components/Form/Loader.vue'
    import PaginationBar from '@/Components/Form/PaginationBar.vue'
    import { ref } from 'vue'

    const pagination = ref({ data: [] })
    const search = ref('')
    const loading = ref(true)

    const filesInput = ref(null)



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



    const upload = (files) => {
        if (files.length <= 0) return

        useForm({files}).post(route('dashboard.admin.specs.upload'), {
            onSuccess() {
                filesInput.value.value = ''
                throttledFetch()
            },

            onError(error) {
                console.error(error)
            }
        })
    }



    const recache = () => {
        Inertia.post(route('dashboard.admin.specs.cache'), {
            preserveScroll: true,

            onSuccess() {
                throttledFetch()
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

    .upload-wrapper
        display: flex
        flex-direction: column
        align-items: center
        justify-content: center
        background: var(--color-background-soft)
        border-radius: .325rem
        margin: 1rem
        position: relative
        padding: 5rem 1rem

        label.button
            display: flex
            align-items: center
            height: 2.5rem
            padding: 0 1rem
            border-radius: .325rem
            border: none
            background: var(--color-primary)
            color: var(--color-background)
            font-size: .75rem
            letter-spacing: .05em
            font-weight: 500
            text-transform: uppercase
            cursor: pointer
            user-select: none

            &:hover,
            &:focus
                background: var(--color-primary-soft)

        input
            display: none

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