<template>
    <Head title="Formulare verwalten" />

    <AdminLayout title="Formulare verwalten">
        <div class="flex v-center gap-1">
            <Actions v-show="selection.length >= 1" :selection="selection" @deselect="deselectAll()" @delete="openDeletePopup()"/>

            <div class="spacer"></div>

            <div class="flex v-center">
                <!-- <button class="icon-button" aria-hidden="true" v-tooltip="'Suchen'">search</button> -->
                <VDropdown placement="bottom-end">
                    <IconButton type="button" icon="settings" v-tooltip="'Ansichtseinstellungen'" />
                    <template #popper>
                        <div class="flex padding-1 vertical">
                            <mui-toggle type="switch" prepend-label="Bildvorschau" v-model="isPreview" />
                        </div>
                    </template>
                </VDropdown>
            </div>

            <Switcher v-model="layout" :options="[
                { value: 'list', icon: 'view_list', tooltip: 'Listenansicht' },
                { value: 'grid', icon: 'grid_view', tooltip: 'Kachelansicht' },
            ]"/>
        </div>

        <ListItemLayout class="w-100 margin-block-2" :layout="layout" v-show="items.length >= 1">
            <ImageCard
                v-for="item in items"
                :key="item.id"
                :item="item"
                :layout="layout"
                :enable-preview="isPreview"
                :selection="selection"
                @contextmenu.prevent.exact="setSelection(item)"
                @contextmenu.prevent.ctrl="toggleSelection(item)"
                @click.ctrl="toggleSelection(item)"
                @click.exact="openItem(item)"
                @open="openItem(item)"
                @duplicate="duplicateItem(item)"
                @delete="openDeletePopup(item)"
                />
        </ListItemLayout>
        <small v-show="items.length <= 0" class="w-100 flex h-center padding-inline-2 padding-block-5">Keine Kategorien angelegt</small>

        <div class="flex v-center gap-1 border-top padding-top-1">
            <small><b>{{items.length}}</b> Kategorien</small>
        
            <div class="spacer"></div>
        </div>

        <template #fab>
            <button class="fab-button" aria-hidden="true" title="Neue Kategorie" @click="openItem()">add</button>
        </template>
    </AdminLayout>



    <Popup ref="deletePopup" title="Elemente löschen?">
        <form class="confirm-popup-wrapper" @submit.prevent="deleteItems">
            <p>Möchten Sie wirklich <b>{{selection.length}} Elemente</b> entgültig löschen?</p>
            <div class="confirm-popup-footer">
                <mui-button type="button" variant="contained" label="Abbrechen" @click="$refs.deletePopup.close()" />
                <mui-button type="submit" variant="filled" color="error" label="Entgültig löschen" />
            </div>
        </form>
    </Popup>
</template>

<script setup>
    import { Head, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { ref, computed } from 'vue'
    import { Inertia } from '@inertiajs/inertia'
    import PostCategoryInterface from '@/Interfaces/PostCategory.js'

    import AdminLayout from '@/Layouts/Admin.vue'
    import ListItemLayout from '@/Components/Layout/ListItemLayout.vue'
    import ImageCard from '@/Components/Form/Card/ImageCard.vue'
    import IconButton from '@/Components/Form/IconButton.vue'
    import Switcher from '@/Components/Form/Switcher.vue'
    import Actions from '@/Components/Form/Actions.vue'
    import Popup from '@/Components/Form/Popup.vue'

    const props = defineProps({
        items: Array,
    })

    // const items_ = computed(() => props.categories)
    // const items = computed(() => items_.value.map(item => new PostCategoryInterface(item)))



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



    // START: Editor
    const openItem = (item = null) => {
        // Inertia.visit(route('admin.'+props.app+'.categories.editor', item?.id))
    }
    // END: Editor



    // START: Delete
    const deletePopup = ref(null)

    const openDeletePopup = (item = null) => {
        if (item) setSelection(item)
        deletePopup.value.open()
    }
    
    const deleteItems = () => {
        // useForm({ids: selection.value}).delete(route('admin.'+props.app+'.categories.delete'), {
        //     onSuccess: () => {
        //         deletePopup.value.close()
        //         deselectAll()
        //     },
        // })
    }
    // END: Delete



    // START: Duplicate
    const duplicateItem = (item) => {
        // useForm({returnTo: 'current'}).post(route('admin.'+props.app+'.categories.duplicate', item.id), {
        //     onSuccess: () => {
        //         deselectAll()
        //     },
        // })
    }
    // END: Duplicate

    
    
    // START: Error Handling
    const errors = computed(() => usePage().props.value.errors)
    const hasErrors = computed(() => Object.keys(errors.value).length > 0)
    // END: Error Handling
</script>

<style lang="sass" scoped>
</style>