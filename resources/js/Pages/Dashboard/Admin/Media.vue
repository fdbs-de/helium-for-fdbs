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
                <!-- <button class="icon-button" @click="layout = 'icon'" :class="{'active': layout === 'icon'}" v-tooltip="'Iconansicht'">grid_on</button> -->
            </div>
        </div>

        <template #fab>
            <VDropdown placement="top-end">
                <button class="fab-button" aria-hidden="true" title="Neu...">add</button>
                <template #popper>
                    <div class="flex padding-1 vertical">
                        <mui-button class="dropdown-button" variant="text" label="Neue Dateien" icon-left="upload" as="label" for="file-upload"/>
                        <input type="file" id="file-upload" style="display: none" multiple @input="uploadFiles($event.target.files, path)">

                        <mui-button class="dropdown-button" variant="text" label="Neuer Ordner" icon-left="create_new_folder" @click="openCreateDirectoryPopup(path)"/>
                    </div>
                </template>
            </VDropdown>
        </template>
        
        <div class="item-wrapper" :class="layout" v-show="exists && items.length >= 1">
            <DirectoryItem
                v-for="item in items"
                :key="item.path"
                :item="item"
                :layout="layout"
                :enable-preview="isPreview"
                :selection="selection"
                @contextmenu.prevent.exact="setSelection(item)"
                @contextmenu.prevent.ctrl="toggleSelection(item)"
                @click.ctrl="toggleSelection(item)"
                @click.exact="openItem(item)"
                @open="openItem(item)"
                @delete="openDeletePopup(item)"
                @rename="openRenamePopup(item)"
                />
        </div>
        <small v-show="exists && items.length <= 0" class="w-100 flex h-center padding-inline-2 padding-block-5">Dieser Ordner ist leer</small>
        <small v-show="!exists" class="w-100 flex h-center padding-inline-2 padding-block-5">Dieser Ordner existiert nicht</small>

        <div class="flex v-center gap-1 border-top padding-top-1">
            <small><b>{{items.filter(i => i.mime !== 'folder').length}}</b> Dateien</small>
            <small><b>{{fileSize(items.reduce((a, b) => a + b.size, 0))}}</b> gesamt</small>

            <div class="spacer"></div>
        </div>
    </AdminLayout>



    <Popup ref="createDirectoryPopup" title="Ordner erstellen">
        <form class="confirm-popup-wrapper" @submit.prevent="storeDirectory(path)">
            <mui-input class="w-100" v-model="createDirectoryForm.name" :prefix="createDirectoryForm.prefix" label="Name" required />
            <div class="confirm-popup-footer">
                <mui-button type="button" variant="contained" label="Abbrechen" @click="$refs.createDirectoryPopup.close()" />
                <mui-button type="submit" variant="filled" label="Ordner erstellen" />
            </div>
        </form>
    </Popup>

    <Popup ref="renamePopup" title="Umbennenen">
        <form class="confirm-popup-wrapper" @submit.prevent="renameItem">
            <mui-input class="w-100" v-model="renameForm.new_name" :prefix="renameForm.prefix" label="Name" required />
            <div class="confirm-popup-footer">
                <mui-button type="button" variant="contained" label="Abbrechen" @click="$refs.renamePopup.close()" />
                <mui-button type="submit" variant="filled" label="Umbennenen" />
            </div>
        </form>
    </Popup>

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
    import { fileSize, lastCharacters } from '@/Utils/String'
    import DirectoryItemClass from '@/Components/Form/MediaLibrary/DirectoryItem.js'
    
    import AdminLayout from '@/Layouts/Admin.vue'
    import DirectoryItem from '@/Components/Form/MediaLibrary/DirectoryItem.vue'
    import Breadcrumbs from '@/Components/Form/MediaLibrary/Breadcrumbs.vue'
    import Actions from '@/Components/Form/Actions.vue'
    import Popup from '@/Components/Form/Popup.vue'



    const props = defineProps({
        items: Array,
        path: String,
        exists: Boolean,
    })

    const path = computed(() => props.path)
    const items_ = computed(() => props.items)
    const items = computed(() => items_.value.map(item => new DirectoryItemClass(item)))



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
        if (item.mime.type === 'folder') return openDirectory(item.path.path)
        if (item.mime.type !== 'folder') return openFile(item)
    }

    const openDirectory = (path) => {
        // Block invalid paths
        if (!startsWithBasePath(path)) return

        Inertia.visit(route('admin.media', { path: encodeURIComponent(path) }), {
            preserveState: true,
            preserveScroll: true,
            onSuccess() {
                // Reset selection
                deselectAll()
            },
        })
    }

    const openFile = (item) => {
        // console.log('open file', item)
    }
    // END: Folder Navigation



    // START: Selection
    const selection = ref([])

    const toggleSelection = (item) => {
        if (selection.value.includes(item.path.path))
        {
            selection.value = selection.value.filter(p => p !== item.path.path)
        }
        else
        {
            selection.value.push(item.path.path)
        }
    }

    const setSelection = (item) => {
        selection.value = [item.path.path]
    }

    const selectAll = () => {
        selection.value = itemObjects.map(i => i.path.path)
    }

    const deselectAll = () => {
        selection.value = []
    }
    // END: Selection



    // START: Upload Document
    const uploadForm = useForm({
        files: null,
        path: null,
    })

    const uploadFiles = (files, path) => {
        if (files.length <= 0) return
        
        uploadForm.files = files
        uploadForm.path = path

        uploadForm.post(route('admin.media.store.file'), {
            forceFormData: true,
            onSuccess() {
                uploadForm.reset()
            },
        })
    }
    // END: Upload Document



    // START: Create Directory
    const createDirectoryPopup = ref(null)

    const createDirectoryForm = useForm({
        prefix: '',
        name: null,
        path: null,
    })

    const openCreateDirectoryPopup = (path) => {
        createDirectoryForm.prefix = lastCharacters(path, 20) + '/'
        createDirectoryPopup.value.open()
    }

    const storeDirectory = (path) => {
        createDirectoryForm.path = path + '/' + createDirectoryForm.name
        createDirectoryForm.post(route('admin.media.store.directory'), {
            onSuccess() {
                createDirectoryForm.reset()
                createDirectoryPopup.value.close()
            },
        })
    }
    // END: Create Directory



    // START: Rename Item
    const renamePopup = ref(null)

    const renameForm = useForm({
        prefix: '',
        current_name: null,
        new_name: null,
        current_path: null,
        new_path: null,
    })

    const openRenamePopup = (item) => {
        let prefix = item.path.path.substring(0, item.path.path.length - item.path.filename.length)

        renameForm.prefix = lastCharacters(prefix, 20)
        renameForm.new_name = item.path.filename
        renameForm.current_name = item.path.filename
        renameForm.current_path = item.path.path
        renamePopup.value.open()
    }

    const renameItem = () => {
        renameForm.new_path = renameForm.current_path.substring(0, renameForm.current_path.length - renameForm.current_name.length) + renameForm.new_name
        renameForm.put(route('admin.media.rename'), {
            onSuccess() {
                renameForm.reset()
                renamePopup.value.close()
            },
        })
    }
    // END: Rename Item



    // START: Delete Item
    const deletePopup = ref(null)

    const openDeletePopup = (item) => {
        setSelection(item)
        deletePopup.value.open()
    }
    
    const deleteItems = () => {
        useForm({
            paths: selection.value,
        }).delete(route('admin.media.delete'), {
            onSuccess() {
                deselectAll()
                deletePopup.value.close()
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