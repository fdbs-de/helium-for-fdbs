<template>
    <Head title="Media Library" />

    <AdminLayout title="Media Library">
        <div class="flex v-center gap-1">
            <Actions v-show="selection.length >= 1" :selection="selection" @deselect="deselectAll()" @delete="$refs.deletePopup.open()" />
            <Breadcrumbs v-show="selection.length <= 0" :path="path" :base-paths="basePaths" @open="openDirectory($event)"/>

            <div class="spacer"></div>

            <div class="flex v-center">
                <!-- <button class="icon-button" aria-hidden="true" v-tooltip="'In Dateien suchen'">search</button> -->
                <VDropdown placement="bottom-end">
                    <button class="icon-button" v-tooltip="'Ansichtseinstellungen'">settings</button>
                    <template #popper>
                        <div class="flex padding-1 vertical">
                            <mui-toggle type="switch" prepend-label="Bildvorschau" v-model="isPreview" />
                        </div>
                    </template>
                </VDropdown>
            </div>

            <div class="view-switcher">
                <button class="icon-button" @click="layout = 'list'" :class="{'active': layout === 'list'}" v-tooltip="'Listenansicht'">view_list</button>
                <button class="icon-button" @click="layout = 'grid'" :class="{'active': layout === 'grid'}" v-tooltip="'Kachelansicht'">grid_view</button>
                <button class="icon-button" @click="layout = 'icon'" :class="{'active': layout === 'icon'}" v-tooltip="'Iconansicht'">grid_on</button>
            </div>
        </div>

        <template #fab>
            <VDropdown placement="top-end">
                <button class="fab-button" aria-hidden="true" title="Neu...">add</button>
                <template #popper>
                    <div class="flex padding-1 vertical">
                        <mui-button class="dropdown-button" variant="text" label="Neue Dateien" icon-left="upload" as="label" for="file-upload"/>
                        <input type="file" id="file-upload" style="display: none" multiple @input="uploadFiles($event.target.files, path)">

                        <mui-button class="dropdown-button" variant="text" label="Neuer Ordner" icon-left="create_new_folder" @click="storeDirectory(path)"/>
                    </div>
                </template>
            </VDropdown>
        </template>
        
        <div class="grid">
            <DirectoryItem
                v-for="item in items"
                :key="item.path"
                :item="item"
                :layout="layout"
                :enable-preview="isPreview"
                :selection="selection"
                @dblclick.exact="openItem(item)"
                @click.exact="setSelection(item)"
                @click.ctrl="toggleSelection(item)"
                @delete="deleteItem(item)"
                />
        </div>

        <div class="flex v-center gap-1 border-top padding-top-1 margin-top-1">
            <small><b>{{items.filter(i => i.mime !== 'folder').length}}</b> Dateien</small>
            <small><b>{{fileSize(items.reduce((a, b) => a + b.size, 0))}}</b> gesamt</small>

            <div class="spacer"></div>
        </div>
    </AdminLayout>



    <Popup ref="deletePopup" title="Elemente löschen?">
        <form class="confirm-popup-wrapper" @submit.prevent="deleteItems">
            <p>Möchten Sie wirklich <b>{{selection.length}} Elemente</b> entgültig löschen?</p>
            <div class="confirm-popup-footer">
                <mui-button type="button" variant="contained" label="Abbrechen" @click="$refs.deletePopup.close()"/>
                <mui-button type="submit" variant="filled" color="error" label="Entgültig löschen"/>
            </div>
        </form>
    </Popup>
</template>

<script setup>
    import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { ref, watch, computed } from 'vue'
    import { Inertia } from '@inertiajs/inertia'
    import { fileSize } from '@/Utils/String'
    
    import AdminLayout from '@/Layouts/Admin.vue'
    import DirectoryItem from '@/Components/Form/MediaLibrary/DirectoryItem.vue'
    import Breadcrumbs from '@/Components/Form/MediaLibrary/Breadcrumbs.vue'
    import Actions from '@/Components/Form/MediaLibrary/Actions.vue'
    import Popup from '@/Components/Form/Popup.vue'



    const { items, path } = defineProps({
        items: Array,
        path: String,
    })



    // START: View Parameters
    const layout = ref('grid')
    const isPreview = ref(false)
    // END: View Parameters



    // START: Folder Navigation
    const basePaths = ref([
        {path: 'public/media', label: 'Öffentlich', icon: 'public', default: true},
        {path: 'private/media', label: 'Privat', icon: 'lock', default: false},
    ])



    const startsWithBasePath = (path) => {
        return basePaths.value.some(p => path.startsWith(p.path))
    }

    const openItem = (item) => {
        if (item.mime === 'folder') return openDirectory(item.path)
        if (item.mime !== 'folder') return openFile(item)
    }

    const openDirectory = (path) => {
        // Block invalid paths
        if (!startsWithBasePath(path)) return

        Inertia.visit(route('dashboard.admin.media', { path: encodeURIComponent(path) }), {
            preserveState: true,
            preserveScroll: true,
            onSuccess() {
                // Reset selection
                deselectAll()
            },
        })
    }

    const openFile = (item) => {
        console.log('open file', item)
    }
    // END: Folder Navigation



    // START: Upload Document
    const uploadForm = useForm({
        files: null,
        path: null,
    })

    const uploadFiles = (files, path) => {
        if (files.length <= 0) return
        
        uploadForm.files = files
        uploadForm.path = path

        uploadForm.post(route('dashboard.admin.media.store'), {
            forceFormData: true,
            onSuccess() {
                uploadForm.reset()
            },
        })
    }
    // END: Upload Document



    // START: Create Directory
    const storeDirectory = (path) => {
        useForm({
            path: path + '/' + 'test',
        }).post(route('dashboard.admin.media.store.directory'))
    }
    // END: Create Directory



    // START: Selection
    const selection = ref([])

    const toggleSelection = (item) => {
        if (selection.value.includes(item.path))
        {
            selection.value = selection.value.filter(p => p !== item.path)
        }
        else
        {
            selection.value.push(item.path)
        }
    }

    const setSelection = (item) => {
        selection.value = [item.path]
    }

    const selectAll = () => {
        selection.value = items.map(i => i.path)
    }

    const deselectAll = () => {
        selection.value = []
    }
    // END: Selection



    // START: Delete Item
    const deletePopup = ref(null)

    const deleteItem = (item) => {
        setSelection(item)
        deletePopup.value.open()
    }
    
    const deleteItems = () => {
        useForm({
            paths: selection.value,
        }).delete(route('dashboard.admin.media.delete'), {
            onSuccess() {
                deletePopup.value.close()
                deselectAll()
            },
        })
    }
    // END: Delete Item
</script>

<style lang="sass" scoped>
    .loader
        position: absolute
        bottom: -2px
        height: 2px
        left: 0


    .grid
        display: grid
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr))
        gap: 1rem
        width: 100%
        padding: 2rem 0

        img
            width: 100%
            aspect-ratio: 1
            object-fit: contain
            border-radius: var(--radius-m)
            background-color: var(--color-background-soft)

    .view-switcher
        display: flex
        user-select: none
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-m)
        overflow: hidden
        
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
</style>