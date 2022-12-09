<template>
    <Head title="Media Library" />

    <DashboardSubLayout title="Media Library" area="Adminbereich">
        <div class="flex v-center background-soft padding-1 gap-1 radius-l">
            <mui-input class="search-input" type="search" no-border placeholder="Suchen" icon-left="search" v-model="searchName" @input="throttledFetch"/>
            
            <div class="spacer"></div>
            
            <mui-button variant="filled" color="primary" label="Grid" @click="layout = 'grid'" />
            <mui-button variant="filled" color="primary" label="Liste" @click="layout = 'list'" />
            <mui-toggle type="switch" label="Vorschau" v-model="isPreview" />
            
            <Loader class="loader" v-show="loading" />
        </div>

        <div class="flex v-center background-soft padding-1 gap-1 radius-l margin-top-1">
            <input type="file" multiple @input="uploadFiles($event.target.files)">
        </div>
        
        <div class="grid">
            <DirectoryItem v-for="item in items" :key="item.path" :item="item" :layout="layout" :enable-preview="isPreview"/>
        </div>

        <div class="flex v-center gap-1 border-top padding-top-1 margin-top-1">
            <small><b>{{items.filter(i => i.mime !== 'folder').length}}</b> Dateien</small>
            <small><b>{{fileSize(items.reduce((a, b) => a + b.size, 0))}}</b> gesamt</small>
        </div>
        
        <!-- {{JSON.stringify(items)}} -->
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
    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
    import Popup from '@/Components/Form/Popup.vue'
    import Loader from '@/Components/Form/Loader.vue'
    import { ref, watch, computed } from 'vue'
    import { fileSize } from '@/Utils/String'
    import DirectoryItem from '@/Components/Form/MediaLibrary/DirectoryItem.vue'



    const props = defineProps({
        items: Object,
    })



    const uploadDocumentPopup = ref(null)
    const deleteDocumentPopup = ref(null)

    // Search parameters
    const loading = ref(false)
    const searchName = ref('')
    const searchCategory = ref('')
    const searchGroup = ref('all')
    const documents = ref([])
    
    // View Parameters
    const layout = ref('grid')
    const isPreview = ref(false)



    const fetch = async () => {
        loading.value = true

        try
        {
            let response = await axios.get(route('dashboard.admin.docs.search', {
                name: searchName.value,
                category: searchCategory.value,
                group: searchGroup.value,
            }))

            documents.value = response.data
        }
        catch (error)
        {
            console.log(error.response)
        }
        
        loading.value = false
    }



    const uploadForm = useForm({
        files: null,
    })



    const uploadFiles = (files) => {
        if (files.length <= 0) return
        
        uploadForm.files = files

        uploadForm.post(route('dashboard.admin.media.store'), {
            forceFormData: true,
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
        padding: 1rem 0

        img
            width: 100%
            aspect-ratio: 1
            object-fit: contain
            border-radius: var(--radius-m)
            background-color: var(--color-background-soft)
</style>