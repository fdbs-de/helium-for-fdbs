<template>
    <Head title="Media Library" />

    <DashboardSubLayout title="Media Library" area="Adminbereich">
        <div class="flex v-center gap-1">
            <VDropdown placement="bottom-start">
                <mui-button icon-left="upload" label="Neu"/>
                <template #popper>
                    <div class="flex padding-1 vertical">
                        <mui-button class="dropdown-button" variant="text" label="Neue Datei" icon-left="upload" as="label" for="file-upload"/>
                        <input type="file" id="file-upload" style="display: none" multiple @input="uploadFiles($event.target.files)">

                        <mui-button class="dropdown-button" variant="text" label="Neuer Ordner" icon-left="create_new_folder" @click="storeDirectory()"/>
                    </div>
                </template>
            </VDropdown>
            
            <Breadcrumbs :path="workPath" :base-paths="basePaths" @open="openDirectory($event)"/>

            <div class="spacer"></div>

            <div class="flex v-center">
                <button class="icon-button">search</button>
                <VDropdown placement="bottom-end">
                    <button class="icon-button">settings</button>
                    <template #popper>
                        <div class="flex padding-1 vertical">
                            <mui-toggle type="switch" prepend-label="Bildvorschau" v-model="isPreview" />
                        </div>
                    </template>
                </VDropdown>
            </div>

            <div class="view-switcher">
                <button class="icon-button" @click="layout = 'list'" :class="{'active': layout === 'list'}">view_list</button>
                <button class="icon-button" @click="layout = 'grid'" :class="{'active': layout === 'grid'}">grid_view</button>
                <button class="icon-button" @click="layout = 'icon'" :class="{'active': layout === 'icon'}">grid_on</button>
            </div>
            
            <Loader class="loader" v-show="loading" />
        </div>
        
        <div class="grid">
            <DirectoryItem v-for="item in items" :key="item.path" :item="item" :layout="layout" :enable-preview="isPreview" @open="openItem(item)"/>
        </div>

        <div class="flex v-center gap-1 border-top padding-top-1 margin-top-1">
            <small><b>{{items.filter(i => i.mime !== 'folder').length}}</b> Dateien</small>
            <small><b>{{fileSize(items.reduce((a, b) => a + b.size, 0))}}</b> gesamt</small>

            <div class="spacer"></div>
        </div>
    </DashboardSubLayout>



    <!-- <Popup ref="deleteDocumentPopup" title="Dokument löschen?">
        <form class="confirm-popup-wrapper" @submit.prevent="deleteDocument">
            <p>Möchten Sie das Dokument "<b>{{documentForm.name}}</b>" entgültig löschen?</p>
            <div class="confirm-popup-footer">
                <mui-button variant="contained" label="Abbrechen" @click="$refs.deleteDocumentPopup.close()"/>
                <mui-button type="submit" variant="filled" color="error" label="Entgültig löschen"/>
            </div>
        </form>
    </Popup> -->
</template>

<script setup>
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
    import { ref, watch, computed } from 'vue'
    import { fileSize } from '@/Utils/String'
    
    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
    import DirectoryItem from '@/Components/Form/MediaLibrary/DirectoryItem.vue'
    import Breadcrumbs from '@/Components/Form/MediaLibrary/Breadcrumbs.vue'
    import Popup from '@/Components/Form/Popup.vue'
    import Loader from '@/Components/Form/Loader.vue'



    // START: Folder Navigation
    const basePaths = ref([
        {path: 'public/media', label: 'Öffentlich', icon: 'public', default: true},
        {path: 'private/media', label: 'Privat', icon: 'lock', default: false},
    ])

    const workPath = ref(basePaths.value.find(p => p.default).path)



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

        workPath.value = path

        // Load new directory
        throttledFetch()
    }

    const openFile = (item) => {
        console.log('open file', item)
    }
    // END: Folder Navigation



    const uploadDocumentPopup = ref(null)
    const deleteDocumentPopup = ref(null)

    // Search parameters
    const loading = ref(false)
    const items = ref([])
    
    // View Parameters
    const layout = ref('grid')
    const isPreview = ref(false)



    const fetch = async () => {
        loading.value = true

        try
        {
            let response = await axios.get(route('dashboard.admin.media.search', {
                path: workPath.value,
            }))

            items.value = response.data
        }
        catch (error)
        {
            console.log(error)
        }
        
        loading.value = false
    }



    const uploadForm = useForm({
        files: null,
        path: null,
    })



    const uploadFiles = (files) => {
        if (files.length <= 0) return
        
        uploadForm.files = files
        uploadForm.path = workPath.value

        uploadForm.post(route('dashboard.admin.media.store'), {
            forceFormData: true,
            onSuccess() {
                throttledFetch()
            },
        })
    }

    const storeDirectory = () => {
        useForm({
            path: workPath.value + '/' + 'test',
        }).post(route('dashboard.admin.media.store.directory'), {
            onSuccess() {
                throttledFetch()
            },
        })
    }

    // const deleteDocument = () => {
    //     documentForm.delete(route('dashboard.admin.media.delete', documentForm.id), {
    //         onSuccess() {
    //             closeUploadDocumentPopup()
    //             deleteDocumentPopup.value.close()
    //             throttledFetch()
    //         },
    //     })
    // }



    //////////////
    // On Mount //
    //////////////

    const throttledFetch = _.throttle(fetch, 300)
    fetch()
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
        background: var(--color-background-soft)
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
            color: var(--color-primary)
            background-color: #0000000f
</style>