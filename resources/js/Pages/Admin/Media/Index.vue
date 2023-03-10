<template>
    <AdminLayout :title="`${drive.name} Media`">
        <div class="flex v-center gap-1">
            <Actions v-show="selection.length >= 1" :selection="selection" @deselect="deselectAll()" @delete="$refs.deletePopup.open()" />
            <Breadcrumbs v-show="selection.length <= 0" :breadcrumbs="breadcrumbs" @open="openDirectory($event)" :root-icon="drive.icon" :root-name="drive.name"/>

            <div class="spacer"></div>

            <div class="flex v-center">
                <IconButton type="button" icon="search" v-tooltip="'Suchen'" />
                <VDropdown placement="bottom-end">
                    <IconButton type="button" icon="settings" v-tooltip="'Ansichtseinstellungen'" />
                    <template #popper>
                        <div class="flex padding-1 vertical">
                            <mui-toggle type="switch" label="Bildvorschau" v-model="isPreview" />
                            <!-- <mui-toggle type="switch" off-value="grid" label="Listenansicht" value="list" v-model="layout" /> -->
                        </div>
                    </template>
                </VDropdown>
            </div>

            <VDropdown placement="bottom-end">
                <mui-button type="button" variant="filled" label="Neu" icon-left="add" />
                <template #popper>
                    <div class="flex padding-1 vertical">
                        <mui-button class="dropdown-button" variant="text" label="Hochladen" icon-left="upload" as="label" for="file-upload" v-close-popper/>
                        <input type="file" id="file-upload" style="display: none" multiple @input="storeFiles($event.target.files, workingDirectory.id)">

                        <mui-button class="dropdown-button" variant="text" label="Ordner" icon-left="create_new_folder" @click="openCreateDirectoryPopup()" v-close-popper/>
                    </div>
                </template>
            </VDropdown>
        </div>
        
        <ListItemLayout class="w-100 margin-block-2" :layout="layout" v-show="items.length >= 1">
            <DirectoryItem
                v-for="item in items.slice(offset, offset+size)"
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
                @edit="openEditPopup(item)"
                />
        </ListItemLayout>
        <small v-show="items.length <= 0" class="w-100 flex h-center padding-inline-2 padding-block-5">Dieser Ordner ist leer</small>
        
        <div class="flex v-center gap-1 border-top padding-top-1">
            <div class="flex-1">
                <small><b>{{items.filter(i => i.mime !== 'folder').length}}</b> Dateien</small>
            </div>
            
            <div class="flex-3 flex h-center">
                <TablePagination v-model="page" :total="total" :size="size"/>
            </div>

            <div class="flex-1"></div>
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

    <Popup ref="renamePopup" title="Umbenennen">
        <form class="confirm-popup-wrapper" @submit.prevent="renameItem(renameForm.name, renameForm.item)">
            <mui-input class="w-100" v-model="renameForm.name" label="Name" required />
            <div class="confirm-popup-footer">
                <mui-button type="button" variant="contained" label="Abbrechen" @click="$refs.renamePopup.close()" />
                <mui-button type="submit" variant="filled" label="Umbennenen" />
            </div>
        </form>
    </Popup>

    <Popup ref="editPopup" title="Bearbeiten" position="right" style="--max-width: 400px;">
        <form class="flex-1 flex vertical" @submit.prevent="saveItem()">
            <div class="preview-wrapper" v-if="editForm.item && editForm.item.mime.type === 'image'">
                <img class="image" :src="editForm.item.path.url" />
            </div>

            <div class="flex padding-inline-1 border-bottom">
                <Tabs v-model="editForm.tab" :tabs="[
                    { label: 'Allgemeines', value: 'general' },
                    { label: 'Berechtigungen', value: 'permissions' },
                ]" />
            </div>

            <div class="flex-1 flex vertical gap-1 padding-1">
                <template v-if="editForm.tab === 'general'">
                    <mui-input v-model="editForm.title" label="Titel" />
                    <mui-input v-model="editForm.alt" label="Alt-Text" />
                    <mui-input type="textarea" class="textarea" v-model="editForm.description" label="Beschreibung" />
                </template>
    
                <template v-if="editForm.tab === 'permissions'">
                    <select class="w-100" v-model="editForm.permission_mode">
                        <option value="inherit">Vererbt</option>
                        <option value="public">Öffentlich</option>
                        <option value="custom">Benutzerdefiniert</option>
                    </select>
        
                    <template v-if="editForm.permission_mode === 'custom'">
                        <mui-input class="w-100" v-model="editForm.profiles" label="Profile" />
                    </template>
                </template>
            </div>

            <div class="flex padding-1 border-top">
                <mui-button type="submit" class="flex-1" variant="filled" label="Speichern" />
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
    import TablePagination from '@/Components/Form/Table/TablePagination.vue'
    import Breadcrumbs from '@/Components/Form/MediaLibrary/Breadcrumbs.vue'
    import IconButton from '@/Components/Form/IconButton.vue'
    import Actions from '@/Components/Form/Actions.vue'
    import Popup from '@/Components/Form/Popup.vue'
    import Tabs from '@/Components/Form/Tabs.vue'



    const props = defineProps({
        items: Array,
        breadcrumbs: Array,
        drive: Object,
    })

    const workingDirectory = computed(() => props.breadcrumbs[props.breadcrumbs?.length - 1] ?? {})

    const page = ref(0)
    const size = ref(120)
    const total = computed(() => props.items.length)

    const offset = computed(() => {
        let offset = size.value * (page.value ?? 0) - size.value

        // Clamp the offset to 0 and size
        return Math.min(Math.max(0, offset), (~~(total.value / size.value)) * size.value);
    })



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
        Inertia.visit(route('admin.media', [props.drive.alias, item.id]), {
            preserveState: true,
            preserveScroll: true,
            onSuccess() {
                deselectAll()
            },
        })
    }

    const openFile = (item) => {
        openEditPopup(item)
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



    // START: Edit Item
    const editPopup = ref(null)

    const editForm = useForm({
        tab: 'general',
        alt: '',
        title: '',
        description: '',
        permission_mode: 'inherit',
        users: [],
        roles: [],
        profiles: '',
        item: null,
    })

    const openEditPopup = (item) => {
        editForm.alt = item?.meta?.alt ?? ''
        editForm.title = item?.meta?.title ?? ''
        editForm.description = item?.meta?.description ?? ''
        editForm.permission_mode = item?.permission_mode ?? 'inherit'
        editForm.users = []
        editForm.roles = []
        editForm.profiles = item?.permission_config?.profiles?.join(', ') ?? ''
        editForm.item = item
        editPopup.value.open()
    }

    const saveItem = () => {
        editForm
        .transform((data) => ({
            ...data,
            profiles: data?.profiles?.split(',')?.map(e => e.trim())?.filter(e => e.length > 0) ?? [],
        }))
        .put(route('admin.media.update', editForm.item.id), {
            onSuccess() {
                editForm.reset()
                editPopup.value.close()
            },
            onError(e) {
                console.log(e);
            },
        })
    }
    // END: Edit Item



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

    .preview-wrapper
        background: var(--color-background-soft)
        margin-bottom: 1rem

        img.image
            display: block
            height: 12rem
            width: 100%
            object-fit: contain
            background-image: url('/images/app/image_transparency.svg')
            background-position: center
            background-size: 10px

    .textarea
        --base-height: 10rem !important

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