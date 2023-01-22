<template>
    <Popup ref="picker" title="Datei auswählen" @close="reset()">
        <div class="flex v-center gap-1 padding-1 radius-top-m border-bottom" style="position: relative;">
            <Breadcrumbs :breadcrumbs="breadcrumbs" @open="openDirectory($event)" />

            <Loader class="loader" v-show="loading" />
        </div>

        <div class="list-wrapper">
            <ListItemLayout class="list-layout w-100" :layout="layout" v-show="items.length >= 1">
                <DirectoryItem
                    v-for="item in items"
                    :key="item.id"
                    :item="item"
                    :layout="layout"
                    :enable-preview="isPreview"
                    :selection="selection"
                    @click.exact="openItem(item)"
                    @open="openItem(item)"
                    />
            </ListItemLayout>
            <small v-show="items.length <= 0" class="w-100 flex h-center padding-inline-2 padding-block-5">Dieser Ordner ist leer</small>
        </div>

        <div class="flex v-center gap-1 padding-1 radius-bottom-m border-top">
            <b>{{ getName(selectedPath) }}</b>
            <div class="spacer"></div>
            <mui-button :disabled="!selectedPath" label="Datei Auswählen" @click="select(selectedPath)"/>
        </div>
    </Popup>
</template>

<script setup>
    import { ref } from 'vue'

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
        }
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
    const workingDirectory = ref(null)

    const selectedPath = ref('')
    // END: Refs



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
        selectedPath.value = item.path.url
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
        fetch()
        picker.value.open()
    }
    // END: Open



    // START: Fetch
    const loading = ref(false)

    const fetch = async () => {
        loading.value = true

        try {
            let url = workingDirectory.value ? route('admin.media', workingDirectory.value) : route('admin.media')

            let response = await axios.get(url, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })

            breadcrumbs.value = response.data?.breadcrumbs
            items.value = response.data?.items
            workingDirectory.value = workingDirectory.value ? response.data?.breadcrumbs[response.data.breadcrumbs?.length - 1].id : null
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
        workingDirectory.value = directory
        await fetch()
    }
    // END: Open



    // START: Select
    const select = (file) => {
        picker.value.close()
        successCallback.value(file)
        reset()
    }
    // END: Select



    // START: Reset
    const reset = () => {
        selectedPath.value = ''
        deselectAll()
    }



    // START: Get name
    const getName = (path) => {
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

    .list-wrapper
        height: 30rem
        overflow-y: scroll

    .list-layout
        border-radius: 0 !important
        box-shadow: none !important
</style>