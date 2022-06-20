<template>
    <Head title="Dashboard: Spezificationen verwalten" />

    <DashboardSubLayout title="Spezificationen verwalten">
        <template #head>
            <mui-input class="search-input" type="search" no-border placeholder="Suchen" icon-left="search" v-model="search" @input="throttledFetch" />
            <Loader class="loader" v-show="loading" />
        </template>

        <div class="upload-wrapper">
            <div class="button-group">
                <label class="top-button" for="files-input" role="button" tabindex="0">Dateien hochladen (max. 1000)</label>
                <mui-button class="bottom-button" variant="contained" size="small" label="Cache erneuern" @click="recache()"/>
            </div>
            <input type="file" id="files-input" ref="filesInput" multiple @input="upload($event.target.files)" accept="application/pdf,application/vnd.ms-excel" />
        </div>

        <div class="selection-wrapper">
            <span class="text">Auswahl: <b>{{selection.length}}</b></span>
            <div class="inner-wrapper">
                <mui-button size="small" variant="contained" label="Abwählen" :disabled="!selection.length" @click="deselectAll"/>
                <mui-button size="small" variant="filled" color="error" label="Löschen" :disabled="!selection.length" @click="deleteSelection"/>
            </div>
        </div>

        <PaginationBar class="top-pagination-bar" v-if="pagination.data.length" :from="pagination.from" :to="pagination.to" :total="pagination.total" @prev="prevPage" @next="nextPage"/>

        <div class="grid" v-if="pagination.data.length">
            <div class="row" v-for="item in pagination.data" :key="item.name">
                <span>
                    <mui-toggle :modelValue="selection.includes(item.name)" @update:modelValue="toggleSelect(item.name)"/>
                </span>
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
    import Tag from '@/Components/Form/Tag.vue'
    import { ref } from 'vue'

    const pagination = ref({ data: [] })
    const search = ref('')
    const selection = ref([])
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



    const toggleSelect = (name) => {
        if (selection.value.includes(name))
        {
            selection.value = selection.value.filter(item => item !== name)
        }
        else
        {
            selection.value.push(name)
        }
    }

    const select = (name) => {
        if (selection.value.includes(name)) return

        selection.value.push(name)
    }

    const deselect = (name) => {
        selection.value = selection.value.filter(item => item !== name)
    }

    const deselectAll = () => {
        selection.value = []
    }

    const deleteSelection = () => {
        if (selection.value.length <= 0) return

        Inertia.delete(route('dashboard.admin.specs.delete'), {
            data: {
                names: selection.value
            },

            onSuccess() {
                selection.value = []
                throttledFetch()
            },

            onError(error) {
                console.error(error)
            }
        })
    }



    //////////////
    // On Mount //
    //////////////

    const throttledFetch = _.throttle(fetch, 300)
    fetch()
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
        border-radius: .5rem
        margin: 1rem 1rem 0
        position: relative
        padding: 5rem 1rem

        input
            display: none

        .button-group
            display: flex
            flex-direction: column
            gap: 2px

            .bottom-button
                border-radius: .2rem .2rem .5rem .5rem

            label.top-button
                display: flex
                align-items: center
                height: 2.5rem
                padding: 0 1rem
                border-radius: .5rem .5rem .2rem .2rem
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

    .selection-wrapper
        display: flex
        align-items: center
        height: 3.5rem
        background: var(--color-background-soft)
        border-radius: .5rem .5rem .2rem .2rem
        margin: 1rem 1rem 0
        position: relative
        padding: 0 1rem
        gap: 1rem

        span.text
            flex: 1

        .inner-wrapper
            display: contents

    .top-pagination-bar
        margin-top: 2px
        border-radius: .2rem .2rem .5rem .5rem

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
            --mui-background: var(--color-background)

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
        .selection-wrapper
            flex-direction: column
            height: auto
            gap: .5rem
            padding: .5rem 1rem

            .inner-wrapper
                display: flex
                width: 100%
                gap: 1rem

                > button
                    flex: 1
</style>