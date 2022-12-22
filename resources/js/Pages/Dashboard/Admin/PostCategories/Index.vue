<template>
    <Head title="Kategorien verwalten" />

    <AdminLayout title="Kategorien verwalten">
        <div class="flex v-center gap-1">
            <Actions v-show="selection.length >= 1" :selection="selection" @deselect="deselectAll()"/>

            <div class="spacer"></div>

            <!-- <div class="flex v-center">
                <button class="icon-button" aria-hidden="true" v-tooltip="'Suchen'">search</button>
                <VDropdown placement="bottom-end">
                    <button class="icon-button" v-tooltip="'Ansichtseinstellungen'">settings</button>
                    <template #popper>
                        <div class="flex padding-1 vertical">
                            <mui-toggle type="switch" prepend-label="Bildvorschau" v-model="isPreview" />
                        </div>
                    </template>
                </VDropdown>
            </div> -->

            <Switcher v-model="layout" :options="[
                { value: 'list', icon: 'view_list', tooltip: 'Listenansicht' },
                { value: 'grid', icon: 'grid_view', tooltip: 'Kachelansicht' },
            ]"/>
        </div>

        <div class="grid">
            <div class="row">
                <b>Name</b>
                <b>Beschreibung</b>
                <b>Status</b>
                <b>Posts</b>
            </div>
        
            <button class="row" v-for="category in categories" :key="'category'+category.id" @click="openCategory(category)">
                <span v-if="category.name">{{category.name}}</span>
                <i v-else>Kein Name angegeben</i>
        
                <span v-if="category.description">{{category.description}}</span>
                <i v-else>Keine Beschreibung angegeben</i>
        
                <span>{{category.status}}</span>

                <span>{{category.posts_count}}</span>
            </button>
        </div>

        <template #fab>
            <button class="fab-button" aria-hidden="true" title="Neue Kategorie" @click="openCategory()">add</button>
        </template>
    </AdminLayout>



    <Popup ref="manageCategoryPopup" class="manage-popup" :title="categoryForm.id ? 'Kategorie bearbeiten' : 'Kategorie erstellen'">
        <form @submit.prevent="saveCategory()" class="layout-wrapper">
            <div class="editor-content">
                <div class="popup-block popup-error" v-if="hasErrors">
                    <h3><b>Fehler!</b></h3>
                    <p v-for="(error, key) in errors" :key="key">{{ error }}</p>
                </div>
                
                <mui-input type="text" label="Name" border v-model="categoryForm.name"/>

                <BlogInput class="content-input" v-model="categoryForm.description" />
            </div>

            <div class="sidebar">
                <div class="group">
                    <b class="heading">Status</b>
                    <select v-model="categoryForm.status">
                        <option value="hidden">Privat</option>
                        <option value="published">Veröffentlicht</option>
                    </select>
                </div>
                
                <div class="spacer"></div>

                <div class="group no-border">
                    <mui-button type="button" v-if="categoryForm.id" label="löschen" color="error" variant="contained" @click="$refs.deleteCategoryPopup.open()"/>
                    <mui-button v-if="categoryForm.id" label="Speichern" :loading="categoryForm.processing"/>
                    <mui-button v-else label="Kategorie erstellen" :loading="categoryForm.processing"/>
                </div>
            </div>
        </form>
    </Popup>



    <Popup ref="deleteCategoryPopup" title="Kategorie löschen?">
        <form class="confirm-popup-wrapper" @submit.prevent="deleteCategory()">
            <p>Möchten Sie die Kategorie <b>"{{categoryForm.name}}"</b> entgültig löschen?</p>
            <div class="confirm-popup-footer">
                <mui-button type="button" variant="contained" label="Abbrechen" @click="$refs.deleteCategoryPopup.close()" />
                <mui-button type="submit" variant="filled" color="error" label="Entgültig löschen" />
            </div>
        </form>
    </Popup>
</template>

<script setup>
    import { Head, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { ref, computed } from 'vue'

    import AdminLayout from '@/Layouts/Admin.vue'
    import Switcher from '@/Components/Form/Switcher.vue'
    import Popup from '@/Components/Form/Popup.vue'
    import BlogInput from '@/Components/Form/BlogInput.vue'
    import IconItem from '@/Components/Form/Posts/IconItem.vue'

    const props = defineProps({
        categories: Array,
    })

    // START: View Parameters
    const layout = ref('list')
    const isPreview = ref(false)
    // END: View Parameters



    // START: Selection
    const selection = ref([])

    const toggleSelection = (item) => {
        if (selection.value.includes(item.id))
        {
            selection.value = selection.value.filter(p => p !== item.id)
        }
        else
        {
            selection.value.push(item.id)
        }
    }

    const setSelection = (item) => {
        selection.value = [item.id]
    }

    const selectAll = () => {
        selection.value = itemObjects.map(i => i.id)
    }

    const deselectAll = () => {
        selection.value = []
    }
    // END: Selection



    // START: Category
    const manageCategoryPopup = ref(null)
    const deleteCategoryPopup = ref(null)

    const categoryForm = useForm({
        id: null,
        name: '',
        slug: '',
        description: '',
        status: 'published',
    })

    const openCategory = (item = null) => {
        manageCategoryPopup.value.open()

        categoryForm.id = item?.id ?? null
        categoryForm.name = item?.name ?? ''
        categoryForm.slug = item?.slug ?? ''
        categoryForm.description = item?.description ?? ''
        categoryForm.status = item?.status ?? 'published'
    }

    const saveCategory = () => {
        categoryForm.id ? updateCategory() : storeCategory()
    }

    const storeCategory = () => {
        categoryForm.post(route('dashboard.admin.categories.store'), {
            onSuccess: () => {
                manageCategoryPopup.value.close()
            },
        })
    }

    const updateCategory = () => {
        categoryForm.put(route('dashboard.admin.categories.update', categoryForm.id), {
            onSuccess: () => {
                manageCategoryPopup.value.close()
            },
        })
    }

    const deleteCategory = () => {
        categoryForm.delete(route('dashboard.admin.categories.delete', categoryForm.id), {
            onSuccess: () => {
                manageCategoryPopup.value.close()
                deleteCategoryPopup.value.close()
            },
        })
    }
    // END: Category

    
    
    // START: Error Handling
    const errors = computed(() => usePage().props.value.errors)
    const hasErrors = computed(() => Object.keys(errors.value).length > 0)
    // END: Error Handling
</script>

<style lang="sass" scoped>

    .icon-button
        display: flex
        align-items: center
        justify-content: center
        width: 3rem
        height: 2.5rem
        border-radius: 0
        cursor: pointer
        transition: all 100ms ease
        border: none
        outline: none
        background-color: transparent
        font-family: var(--font-icon)
        font-size: 1.3rem
        color: var(--color-text)
        padding: 0

        &:hover
            color: var(--color-heading)

        &.active
            color: black
            background-color: #0000000f

    .item-wrapper
        width: 100%
        margin-block: 2rem

        &.grid
            gap: 1rem
            display: grid
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr))

        &.list
            padding: 1rem 0
            border-radius: var(--radius-m)
            background: var(--color-background)
            box-shadow: var(--shadow-elevation-low)
            display: flex
            flex-direction: column
            
    .grid
        display: grid
        align-items: center
        grid-template-columns: minmax(170px, 2fr) minmax(200px, 3fr) minmax(200px, 3fr) 150px
        grid-auto-rows: 2.5rem
        gap: 0 var(--su)
        width: 100%
        padding: 1rem
        overflow-x: auto

        &.three-columns
            grid-template-columns: minmax(170px, 2fr) minmax(200px, 3fr) 150px

        .row
            display: contents
            cursor: pointer
            text-align: inherit
            font-family: inherit
            font-size: inherit
            color: inherit

            > span
                overflow: hidden
                text-overflow: ellipsis
                white-space: nowrap

            .icon
                font-family: var(--font-icon)
                font-size: 1.5rem
                line-height: 1
                color: var(--color-text)
                user-select: none

                &.notified
                    color: var(--color-warning)

                &.active
                    color: var(--color-primary)

            &:hover
                background: var(--color-background-soft)

    .manage-popup
        --max-width: 1200px

        .input-button
            height: 2rem
            width: 2rem
            display: flex
            align-items: center
            justify-content: center
            padding: 0
            margin: 0
            border: none
            background: none
            cursor: pointer
            user-select: none
            font-family: var(--font-icon)
            font-size: 1.35rem
            text-align: center
            color: var(--color-text)
            border-radius: .25rem
            flex: none

            &:hover,
            &:focus
                color: var(--mui-color__)
                background: var(--mui-background-secondary__)

        .layout-wrapper
            display: flex

            .sidebar
                width: 350px
                background: var(--color-background-soft)
                display: flex
                flex-direction: column
                border-radius: 0 var(--radius-m) var(--radius-m) 0

                .group
                    display: flex
                    flex-direction: column
                    padding: 1rem
                    gap: 1rem
                    border-bottom: 1px solid var(--color-border)

                    .heading
                        color: var(--color-heading)

                    &.no-border
                        border: none

                select
                    border: 1px solid var(--color-border)

                .icon-button
                    height: 1.5rem
                    width: 2.5rem
                    display: flex
                    align-items: center
                    justify-content: center
                    user-select: none
                    font-size: 1.2rem
                    font-family: var(--font-icon)
                    color: var(--color-primary)
                    background: #e0004730
                    border-radius: var(--radius-xl)
                    padding: 0
                    border: none
                    cursor: pointer

                    &:hover,
                    &:focus
                        background: var(--color-primary)
                        color: var(--color-background)

                .date-input
                    display: flex
                    align-items: center
                    height: 3rem
                    border-radius: var(--radius-s)
                    border: 1px solid var(--color-border)

            .editor-content
                flex: 1
                padding: 1rem
                display: flex
                flex-direction: column
                gap: 1rem
                --mui-background: var(--color-background)

                .content-input
                    height: 35rem
</style>