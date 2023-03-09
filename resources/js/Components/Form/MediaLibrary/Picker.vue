<template>
    <Popup class="picker-popup" ref="picker" title="Datei auswählen" @close="reset()">
        <div class="picker-layout">
            <div class="breadcrumbs-wrapper">
                <Breadcrumbs :breadcrumbs="breadcrumbs" @open="openDirectory($event)" />
    
                <div class="spacer"></div>
    
                <!--
                    Oh, why dont you just use a label?
                    Fuck you, and fuck Vue. A label in this context is not possible,
                    because Vue just eats up all reactivity and leaves workingDirectory
                    with its default value (which is {}). Dont EVER question me again!
    
                    (If there is a way to pass the context to the input via a label, please do tell me tho)
                -->
                <mui-button type="button" icon-left="upload" label="Neu" variant="contained" size="small" @click="$refs.fileUpload.click()"/>
                <input type="file" ref="fileUpload" id="file-upload" style="display: none;" multiple @input="storeFiles($event.target.files, workingDirectory)">
    
                <Loader class="loader" v-show="loading" />
            </div>
    
            <div class="list-wrapper small-scrollbar">
                <ListItemLayout class="list-layout w-100" :layout="layout" v-show="filteredItems.length">
                    <DirectoryItem
                        v-for="item in filteredItems"
                        :key="item.id"
                        :item="item"
                        :layout="layout"
                        :enable-preview="isPreview"
                        :show-actions="false"
                        :selection="selection"
                        @click.exact="openItem(item)"
                        @open="openItem(item)"
                        />
                </ListItemLayout>
                <small v-show="!filteredItems.length" class="w-100 flex h-center padding-inline-2 padding-block-5">Dieser Ordner ist leer</small>
            </div>

            <div class="flex preview-wrapper">
                <template v-if="selected">
                    <img v-if="selected.mime.type === 'image'" :src="selected.path.url" :alt="selected.meta.alt" class="content-image">
                    <b class="detail font-heading">{{ selected.path.filename }}</b>
                    <div class="detail table">
                        <span>Alt:</span>
                        <b>{{ selected.meta.alt || 'Nicht eingetragen' }}</b>
                        <span>Titel:</span>
                        <b>{{ selected.meta.title || 'Nicht eingetragen' }}</b>
                    </div>
                    <div class="spacer"></div>
                    <div class="detail flex vertical padding-1">
                        <mui-button label="Datei Auswählen" @click="select(selected)"/>
                    </div>
                </template>
                <div v-else class="flex flex-1 h-center v-center padding-1">
                    <small>Keine Datei ausgewählt</small>
                </div>
            </div>
    
            <div class="footer-wrapper">
                <small>
                    {{ items.length }} Elemente
                </small>
                <div class="spacer"></div>
            </div>
        </div>
    </Popup>
</template>

<script setup>
    import { ref, computed } from 'vue'
    import { useForm } from '@inertiajs/inertia-vue3'

    import Popup from '@/Components/Form/Popup.vue'
    import Loader from '@/Components/Form/Loader.vue'
    import ListItemLayout from '@/Components/Layout/ListItemLayout.vue'
    import Breadcrumbs from '@/Components/Form/MediaLibrary/Breadcrumbs.vue'
    import DirectoryItem from '@/Components/Form/MediaLibrary/DirectoryItem.vue'



    // START: Props
    const props = defineProps({
        type: {
            type: String,
            default: 'image'
        },
        multiple: {
            type: Boolean,
            default: false
        },
        accept: {
            type: String,
            default: '*'
        },
        drive: {
            type: String,
            default: 'public'
        },
    })
    // END: Props



    // START: View Parameters
    const layout = ref('list')
    const isPreview = ref(true)
    // END: View Parameters



    // START: Refs
    const picker = ref(null)
    const successCallback = ref(null)
    const breadcrumbs = ref([])
    const items = ref([])
    const selected = ref(null)
    // END: Refs
    


    // START: Working Directory
    const workingDirectory = computed(() => {
        return breadcrumbs.value[breadcrumbs.value?.length - 1] ?? {}
    })
    // END: Working Directory


    // START: Accept Filter
    const filteredItems = computed(() => {
        if (props.accept === '*') return items.value

        const acceptedTypes = props.accept.split(',')

        return items.value.filter(item => {
            return (
                item.mime.string === 'folder'                           // Accept folders
                || acceptedTypes.includes('*')                          // Accept wildcard match
                || acceptedTypes.includes(item.mime.string)             // Accept exact match
                || acceptedTypes.includes(`${item.mime.type}/*`)        // Accept major type match
                || acceptedTypes.includes(`*/*${item.mime.subtype}`)    // Accept extension wildcard match
            )
        })
    })



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
        selected.value = item
        selection.value = [item.id]
    }

    const selectAll = () => {
        selection.value = itemObjects.map(i => i.id)
    }

    const deselectAll = () => {
        selection.value = []
    }
    // END: Selection
    
    
    
    // START: Open
    const open = (callback) => {
        successCallback.value = callback
        picker.value.open()
        fetch()
    }
    // END: Open



    // START: Fetch
    const loading = ref(false)

    const fetch = async (directory = null) => {
        loading.value = true

        try {
            let url = directory?.id ? route('admin.media', [props.drive, directory?.id]) : route('admin.media', [props.drive])

            let response = await axios.get(url, { headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }})

            breadcrumbs.value = response.data?.breadcrumbs
            items.value = response.data?.items
        }
        catch (error) {
            console.log(error)
        }

        loading.value = false
    }
    // END: Fetch



    // START: Open
    const openItem = (item) => {
        if (item.mime.type === 'folder') return openDirectory(item)
        if (item.mime.type !== 'folder') return setSelection(item)
    }

    const openDirectory = async (directory) => {
        await fetch(directory)
    }
    // END: Open



    // START: Upload Document
    const dragFiles = ref(false)

    // window.addEventListener('dragover', () => dragFiles.value = true)
    // window.addEventListener('dragleave', dragLeave)

    const uploadForm = useForm({
        files: null,
    })

    const storeFiles = (files, directory) => {
        if (files.length <= 0) return
        
        uploadForm.files = files

        uploadForm.post(route('admin.media.store.files', directory?.id), {
            forceFormData: true,
            onSuccess() {
                uploadForm.reset()
                fetch(directory)
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
        storeFiles(e.dataTransfer.files, workingDirectory.value)
    }
    // END: Upload Document



    // START: Select
    const select = (file) => {
        picker.value.close()
        successCallback.value(file?.path?.url ?? '')
        reset()
    }
    // END: Select



    // START: Reset
    const reset = () => {
        selected.value = null
        deselectAll()
    }



    // START: Get name
    const getName = (file) => {
        const path = file?.path?.url ?? ''
        const parts = path.split('/')
        return parts[parts.length - 1]
    }
    // END: Get name



    // START: Expose
    defineExpose({
        open
    })
    // END: Expose
</script>

<style lang="sass" scoped>
    .loader
        position: absolute
        bottom: 0
        left: 0
        height: 2px
        width: 100%

    .picker-popup
        --max-width: 1000px

    .picker-layout
        display: grid
        grid-template-columns: auto 300px
        grid-template-rows: 4rem auto 2rem
        grid-template-areas: "breadcrumbs preview" "list preview" "footer preview"

    .breadcrumbs-wrapper
        grid-area: breadcrumbs
        display: flex
        align-items: center
        height: 100%
        padding: 0 1rem
        position: relative

    .list-wrapper
        grid-area: list
        height: 30rem
        overflow-y: scroll
        border-top: 1px solid var(--color-border)
        border-bottom: 1px solid var(--color-border)

    .preview-wrapper
        grid-area: preview
        display: flex
        flex-direction: column
        background: var(--color-background-soft)
        border-radius: 0 var(--radius-m) var(--radius-m) 0
        overflow: hidden
        gap: .5rem

        .detail
            padding-inline: 1rem

        .content-image
            width: 100%
            aspect-ratio: 1.5
            background-image: url('/images/app/image_transparency.svg')
            background-position: center
            background-size: 10px
            overflow: hidden
            object-fit: contain
            border-radius: 0

        .table
            display: grid
            grid-template-columns: auto 1fr
            grid-template-rows: auto
            gap: 0 .5rem

    .footer-wrapper
        grid-area: footer
        padding: 0 1rem

    .list-layout
        border-radius: 0 !important
        box-shadow: none !important
</style>