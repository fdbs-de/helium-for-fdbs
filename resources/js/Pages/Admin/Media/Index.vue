<template>
    <Head title="Media Library" />

    <AdminLayout :title="`${drive} Drive – Media Library`">
        <div class="flex v-center gap-1">
            <Actions v-show="selection.length >= 1" :selection="selection" @deselect="deselectAll()" @delete="$refs.deletePopup.open()" />
            <Breadcrumbs v-show="selection.length <= 0" :breadcrumbs="breadcrumbs" @open="openDirectory($event)"/>

            <div class="spacer"></div>

            <div class="flex v-center">
                <!-- <IconButton type="button" icon="search" v-tooltip="'Suchen'" /> -->
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
                // { value: 'icon', icon: 'grid_on', tooltip: 'Iconansicht' },
            ]"/>
        </div>

        <template #fab>
            <VDropdown placement="top-end">
                <button class="fab-button" aria-hidden="true" title="Neu...">add</button>
                <template #popper>
                    <div class="flex padding-1 vertical">
                        <mui-button class="dropdown-button" variant="text" label="Neue Dateien" icon-left="upload" as="label" for="file-upload" v-close-popper/>
                        <input type="file" id="file-upload" style="display: none" multiple @input="storeFiles($event.target.files, workingDirectory.id)">

                        <mui-button class="dropdown-button" variant="text" label="Neuer Ordner" icon-left="create_new_folder" @click="openCreateDirectoryPopup()" v-close-popper/>
                    </div>
                </template>
            </VDropdown>
        </template>
        
        <ListItemLayout class="w-100 margin-block-2" :layout="layout" v-show="items.length >= 1">
            <DirectoryItem
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
                @delete="openDeletePopup(item)"
                @rename="openRenamePopup(item)"
                />
        </ListItemLayout>
        <small v-show="items.length <= 0" class="w-100 flex h-center padding-inline-2 padding-block-5">Dieser Ordner ist leer</small>

        <div class="flex v-center gap-1 border-top padding-top-1">
            <small><b>{{items.filter(i => i.mime !== 'folder').length}}</b> Dateien</small>
            <!-- <small><b>{{fileSize(items.reduce((a, b) => a + b.size, 0))}}</b> gesamt</small> -->

            <div class="spacer"></div>
        </div>
    </AdminLayout>

    <div class="dropzone" @dragover.prevent="dragOver" @drop.prevent="drop" :class="{'active': dragFiles}">
        <span class="icon" aria-hidden="true">cloud_upload</span>
        <span>Dateien hierher ziehen</span>
    </div>



    <Popup ref="createDirectoryPopup" title="Ordner erstellen">
        <form class="confirm-popup-wrapper" @submit.prevent="storeDirectory(createDirectoryForm.name, workingDirectory.id)">
            <mui-input class="w-100" v-model="createDirectoryForm.name" label="Name" required />
            <div class="confirm-popup-footer">
                <mui-button type="button" variant="contained" label="Abbrechen" @click="$refs.createDirectoryPopup.close()" />
                <mui-button type="submit" variant="filled" label="Ordner erstellen" />
            </div>
        </form>
    </Popup>

    <Popup ref="renamePopup" title="Umbennenen">
        <form class="confirm-popup-wrapper" @submit.prevent="renameItem(renameForm.name, renameForm.item)">
            <mui-input class="w-100" v-model="renameForm.name" label="Name" required />
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
    
    import AdminLayout from '@/Layouts/Admin.vue'
    import ListItemLayout from '@/Components/Layout/ListItemLayout.vue'
    import DirectoryItem from '@/Components/Form/MediaLibrary/DirectoryItem.vue'
    import Breadcrumbs from '@/Components/Form/MediaLibrary/Breadcrumbs.vue'
    import IconButton from '@/Components/Form/IconButton.vue'
    import Switcher from '@/Components/Form/Switcher.vue'
    import Actions from '@/Components/Form/Actions.vue'
    import Popup from '@/Components/Form/Popup.vue'



    const props = defineProps({
        items: Array,
        breadcrumbs: Array,
        drive: String,
    })

    const workingDirectory = computed(() => props.breadcrumbs[props.breadcrumbs?.length - 1] ?? {})



    // START: View Parameters
    const layout = ref('grid')
    const isPreview = ref(true)
    // END: View Parameters



    // START: Folder Navigation
    const openItem = (item) => {
        if (item.mime.type === 'folder') return openDirectory(item)
        if (item.mime.type !== 'folder') return openFile(item)
    }

    const openDirectory = (item) => {
        Inertia.visit(route('admin.media', [props.drive, item.id]), {
            preserveState: true,
            preserveScroll: true,
            onSuccess() {
                deselectAll()
            },
        })
    }

    const openFile = (item) => {
        console.log(item)
    }
    // END: Folder Navigation



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



    // START: Upload Document
    const dragFiles = ref(false)

    window.addEventListener('dragover', () => dragFiles.value = true)
    window.addEventListener('dragleave', dragLeave)

    const uploadForm = useForm({
        files: null,
    })

    const storeFiles = (files, directoryId) => {
        if (files.length <= 0) return
        
        uploadForm.files = files

        uploadForm.post(route('admin.media.store.files', directoryId), {
            forceFormData: true,
            onSuccess() {
                uploadForm.reset()
            },
        })
    }

    const dragOver = (e) => {
        e.preventDefault()
        dragFiles.value = true
    }

    const dragLeave = (e) => {
        e.preventDefault()
        dragFiles.value = false
    }

    const drop = (e) => {
        e.preventDefault()
        dragFiles.value = false
        storeFiles(e.dataTransfer.files, workingDirectory.value.id)
    }
    // END: Upload Document



    // START: Create Directory
    const createDirectoryPopup = ref(null)

    const createDirectoryForm = useForm({
        name: '',
    })

    const openCreateDirectoryPopup = () => {
        createDirectoryPopup.value.open()
    }

    const storeDirectory = (name, directoryId) => {
        useForm({name}).post(route('admin.media.store.directory', directoryId), {
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
        name: '',
        item: null,
    })

    const openRenamePopup = (item) => {
        renameForm.name = item.path.filename
        renameForm.item = item
        renamePopup.value.open()
    }

    const renameItem = (name, item) => {
        useForm({name}).put(route('admin.media.update.rename', item.id), {
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
            ids: selection.value,
        }).delete(route('admin.media.delete'), {
            onSuccess() {
                deselectAll()
                deletePopup.value.close()
            },

            onError(e) {
                console.log(e);
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

    .dropzone
        position: fixed
        top: 0
        left: 0
        right: 0
        bottom: 0
        background: rgba(0, 0, 0, 0.5)
        z-index: 1000
        display: flex
        align-items: center
        justify-content: center
        user-select: none
        gap: 1rem
        color: white
        pointer-events: none
        opacity: 0

        &.active
            pointer-events: all
            opacity: 1

        > span
            pointer-events: none

        .icon
            font-size: 3rem
            line-height: 1
            color: white
            font-family: var(--font-icon)
</style>