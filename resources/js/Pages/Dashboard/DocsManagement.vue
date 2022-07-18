<template>
    <Head title="Dashboard: Dokumente verwalten" />

    <DashboardSubLayout title="Dokumente verwalten">
        <template #head>
            <mui-button label="Neues Dokument Hochladen" @click="openUploadDocumentPopup()"/>
            <!-- <mui-input class="search-input" type="search" no-border placeholder="Suchen" icon-left="search"/> -->
        </template>
    </DashboardSubLayout>

    <Popup ref="uploadDocumentPopup" title="Dokument hochladen">
        <form class="flex vertical gap-1 padding-1" @submit.prevent="saveDocument">
            <mui-input label="Name" v-model="documentForm.name"/>
            <mui-input label="URL freundlicher Name" v-model="documentForm.slug"/>
            <mui-input label="Category" v-model="documentForm.category"/>
            <select v-model="documentForm.group">
                <option value="">Öffentlich</option>
                <option value="customers">Nur Kunden</option>
                <option value="employees">Nur Mitarbeiter</option>
            </select>
            <mui-input label="Cover Alt-Text" v-model="documentForm.alt"/>
            <select v-model="documentForm.cover_size">
                <option value="cover">Cover</option>
                <option value="contain">Contain</option>
            </select>
            <mui-button type="submit" label="Jetzt Hochladen"/>
        </form>
    </Popup>
</template>

<script setup>
    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
    import { Inertia } from '@inertiajs/inertia'
    import Popup from '@/Components/Form/Popup.vue'
    import Loader from '@/Components/Form/Loader.vue'
    import { ref } from 'vue'



    const uploadDocumentPopup = ref(null)

    const documentForm = useForm({
        id: null,
        slug: '',
        name: '',
        group: '',
        category: '',
        has_cover: false,
        cover_alt: '',
        cover_size: 'cover',
    })

    const openUploadDocumentPopup = (document) => {
        uploadDocumentPopup.value.open()
        if (document) documentForm.set(document)
    }

    const saveDocument = () => {
        (documentForm.id) ? updateDocument() : storeDocument()
    }

    const storeDocument = () => {}
    const updateDocument = () => {}
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