<template>
    <Head title="Dashboard: Dokumente verwalten" />

    <AdminLayout title="Dokumente verwalten">

        <div class="flex v-center gap-1">
            <Actions v-show="selection.length >= 1" :selection="selection" @deselect="deselectAll()"/>
            <Switcher v-show="selection.length <= 0" v-model="searchGroup" @update:modelValue="throttledFetch" :options="[
                { value: 'all', icon: 'apps', tooltip: 'Alle' },
                { value: '', icon: 'public', tooltip: 'Öffentlich' },
                { value: 'customers', icon: 'shopping_cart', tooltip: 'Nur Kunden' },
                { value: 'employees', icon: 'work', tooltip: 'Nur Mitarbeiter' },
                { value: 'hidden', icon: 'visibility_off', tooltip: 'Versteckt' },
            ]"/>
            <select style="height: 2.5rem;" v-model="searchCategory" @change="throttledFetch">
                <option value="" selected>Alle Kategorien</option>
                <option v-for="category in categories" :key="category" :value="category">{{capitalizeWords(category)}}</option>
            </select>
            <mui-input style="height: 2.5rem;" border class="search-input" type="search" no-border placeholder="Suchen" icon-left="search" v-model="searchName" @input="throttledFetch"/>

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
                />
        </ListItemLayout>
        <small v-show="items.length <= 0" class="w-100 flex h-center padding-inline-2 padding-block-5">Keine Dokumente angelegt</small>

        <template #fab>
            <button class="fab-button" aria-hidden="true" title="Neues Dokument" @click="openUploadDocumentPopup()">add</button>
        </template>
    </AdminLayout>



    <Popup ref="uploadDocumentPopup" title="Dokument hochladen" @close="documentForm.reset()">
        <form class="flex vertical gap-1 padding-1" @submit.prevent="saveDocument">

            <div class="upload-box">
                <input type="file" id="file-input" ref="fileInput" :required="!documentForm.id" @input="documentForm.file = $event.target.files[0]">
            </div>

            <div class="flex gap-1">
                <mui-input class="flex-1" label="Name" v-model="documentForm.name"/>
                <mui-input class="flex-1" label="URL freundlicher Name *" required v-model="documentForm.slug">
                    <template #right>
                        <button type="button" class="input-button" title="Aus Namen generieren" @click="generateSlug">move_down</button>
                    </template>
                </mui-input>
            </div>

            <div class="flex gap-1">
                <mui-input class="flex-1" label="Kategorie" v-model="documentForm.category">
                    <template #right>
                        <button type="button" class="input-button" title="Bestehende Kategorie auswählen" @click="$refs.categoryPopup.open()">expand_more</button>
                    </template>
                </mui-input>

                <div class="flex flex-1">
                    <select class="flex-1" v-model="documentForm.group">
                        <option value="">Öffentlich</option>
                        <option value="customers">Nur Kunden</option>
                        <option value="employees">Nur Mitarbeiter</option>
                        <option value="hidden">Versteckt</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-1">
                <mui-input class="flex-1" label="Primärer Tag" v-model="documentForm.primary_tag"/>
                <mui-input class="flex-1" label="Weitere Tags" v-model="documentForm.tags"/>
            </div>

            <div class="flex wrap">
                <mui-toggle type="switch" v-model="documentForm.has_cover" label="Separates Cover"/>
                <div class="spacer"></div>
            </div>

            <div class="upload-box" v-show="documentForm.has_cover">
                <input type="file" id="cover-input" ref="coverInput" @input="documentForm.cover = $event.target.files[0]">
            </div>

            <div class="flex gap-1">
                <mui-input class="flex-1" label="Cover Alt-Text" v-model="documentForm.cover_alt" v-show="documentForm.has_cover">
                    <template #right>
                        <button type="button" class="input-button" title="Namen übernehmen" @click="generateAlt">move_down</button>
                    </template>
                </mui-input>
                <div class="flex flex-1">
                    <select class="flex-1" v-model="documentForm.cover_size" v-show="documentForm.has_cover">
                        <option value="cover">Cover</option>
                        <option value="contain">Contain</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-1">
                <mui-button v-if="documentForm.id" type="button" color="error" variant="contained" label="Dokument Löschen" @click="$refs.deleteDocumentPopup.open()"/>
                <div class="spacer"></div>
                <mui-button v-if="documentForm.id" label="Änderungen Speichern"/>
                <mui-button v-else label="Jetzt Hochladen"/>
            </div>
        </form>
    </Popup>



    <Popup ref="deleteDocumentPopup" title="Dokument löschen?">
        <form class="confirm-popup-wrapper" @submit.prevent="deleteDocument">
            <p>Möchten Sie das Dokument "<b>{{documentForm.name}}</b>" entgültig löschen?</p>
            <div class="confirm-popup-footer">
                <mui-button variant="contained" label="Abbrechen" @click="$refs.deleteDocumentPopup.close()"/>
                <mui-button type="submit" variant="filled" color="error" label="Entgültig löschen"/>
            </div>
        </form>
    </Popup>

    <Popup ref="categoryPopup" title="Kategorie auswählen">
        <div class="flex vertical gap-1 padding-1">
            <mui-button type="button" v-for="category in categories" :key="category" @click="selectCategory(category)" :label="category" variant="contained"/>
        </div>
    </Popup>
</template>

<script setup>
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
    import { Inertia } from '@inertiajs/inertia'
    import { slugify, capitalizeWords } from '@/Utils/String'
    import { ref, watch, computed } from 'vue'
    import DocumentInterface from '@/Interfaces/Document.js'

    import AdminLayout from '@/Layouts/Admin.vue'
    import ListItemLayout from '@/Components/Layout/ListItemLayout.vue'
    import ImageCard from '@/Components/Form/Card/ImageCard.vue'
    import IconButton from '@/Components/Form/IconButton.vue'
    import Switcher from '@/Components/Form/Switcher.vue'
    import Actions from '@/Components/Form/Actions.vue'
    import Popup from '@/Components/Form/Popup.vue'
    import Loader from '@/Components/Form/Loader.vue'
    import Tag from '@/Components/Form/Tag.vue'



    defineProps({
        // documents: Array,
        categories: Array,
    })

    const items_ = computed(() => documents.value)
    const items = computed(() => items_.value.map(item => new DocumentInterface(item)))



    // START: View Parameters
    const layout = ref('list')
    const isPreview = ref(true)
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



    const uploadDocumentPopup = ref(null)
    const deleteDocumentPopup = ref(null)
    const categoryPopup = ref(null)
    const fileInput = ref(null)
    const coverInput = ref(null)

    // Search parameters
    const loading = ref(false)
    const searchName = ref('')
    const searchCategory = ref('')
    const searchGroup = ref('all')
    const documents = ref([])



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



    const documentFormName = computed(() => documentForm.name)

    const getGroupName = (group) => {
        switch (group)
        {
            case 'customers': return 'Nur Kunden';
            case 'employees': return 'Nur Mitarbeiter';
            case 'hidden': return 'Versteckt';
            default: return 'Öffentlich';
        }
    }



    const documentForm = useForm({
        id: null,
        file: null,
        slug: '',
        name: '',
        group: '',
        category: '',
        primary_tag: '',
        tags: '',
        cover: null,
        has_cover: false,
        cover_alt: '',
        cover_size: 'cover',
    })

    const generateSlug = () => {
        documentForm.slug = slugify(documentForm.name)
    }

    const generateAlt = () => {
        documentForm.cover_alt = documentForm.name
    }

    const selectCategory = (category) => {
        documentForm.category = category
        categoryPopup.value.close()
    }



    const openItem = (document) => {
        uploadDocumentPopup.value.open()

        if (document)
        {
            documentForm.id = document.id || null
            documentForm.file = null
            documentForm.slug = document.slug || ''
            documentForm.name = document.name || ''
            documentForm.category = document.category || ''
            documentForm.group = document.group || ''
            documentForm.primary_tag = document.primary_tag || ''
            documentForm.tags = document.tags || ''
            documentForm.has_cover = document.has_cover || false
            documentForm.cover = null
            documentForm.cover_alt = document.cover_alt || ''
            documentForm.cover_size = document.cover_size || 'cover'
        }
    }

    const closeUploadDocumentPopup = () => {
        uploadDocumentPopup.value.close()
        documentForm.reset()
        fileInput.value.value = ''
        coverInput.value.value = ''
    }



    const saveDocument = () => {
        (documentForm.id) ? updateDocument() : storeDocument()
    }



    const storeDocument = () => {
        documentForm.post(route('dashboard.admin.docs.store'), {
            forceFormData: true,

            onSuccess() {
                closeUploadDocumentPopup()
                throttledFetch()
            },
        })
    }

    const updateDocument = () => {
        Inertia.post(route('dashboard.admin.docs.update', documentForm.id), {
            _method: 'put',
            ...documentForm,
        }, {
            forceFormData: true,
            onSuccess() {
                closeUploadDocumentPopup()
                throttledFetch()
            },
        })
    }

    const deleteDocument = () => {
        documentForm.delete(route('dashboard.admin.docs.delete', documentForm.id), {
            onSuccess() {
                closeUploadDocumentPopup()
                deleteDocumentPopup.value.close()
                throttledFetch()
            },
        })
    }



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

    .upload-box
        display: flex
        align-items: center
        justify-content: center
        width: 100%
        height: 100px
        background: var(--color-background-soft)
        border-radius: .325rem

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
        font-size: 1.25rem
        text-align: center
        color: var(--mui-color-light__)
        border-radius: .25rem
        flex: none

        &:hover,
        &:focus
            color: var(--mui-color__)
            background: var(--mui-background-secondary__)
</style>