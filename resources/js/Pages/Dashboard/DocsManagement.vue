<template>
    <Head title="Dashboard: Dokumente verwalten" />

    <DashboardSubLayout title="Dokumente verwalten">
        <template #head>
            <mui-button label="Neues Dokument Hochladen" @click="openUploadDocumentPopup()"/>
            <!-- <mui-input class="search-input" type="search" no-border placeholder="Suchen" icon-left="search"/> -->
        </template>

        <div class="grid">
            <div class="row">
                <b>Cover</b>
                <b>Sichtbarkeit</b>
                <b>Name</b>
                <b>Datei</b>
                <b>Kategorie</b>
            </div>
            
            <button class="row" v-for="document in documents" :key="document.id" @click="openUploadDocumentPopup(document)">
                <img v-if="document.has_cover" class="cover" :src="route('dokumentcover', document.id)" :alt="document.cover_alt" width="80" height="50" />
                <i v-else>Kein Cover</i>
                
                <span :title="getGroupName(document.group)">{{getGroupName(document.group)}}</span>
                
                <span v-if="document.name" :title="document.name">{{document.name}}</span>
                <i v-else title="document.name">Kein Name</i>
                
                <a target="_blank" :href="route('dokument', document.id)" :title="document.filename" @click.stop>{{document.filename}}</a>
                
                <span v-if="document.category" :title="document.category">{{document.category}}</span>
                <i v-else title="Keine Kategorie">Keine Kategorie</i>
            </button>
        </div>
    </DashboardSubLayout>



    <Popup ref="uploadDocumentPopup" title="Dokument hochladen" @close="documentForm.reset()">
        <form class="flex vertical gap-1 padding-1" @submit.prevent="saveDocument">

            <div class="upload-box">
                <!-- <mui-button as="label" for="file-input" size="small" variant="contained" label="Dokument auswählen"/> -->
                <input type="file" id="file-input" ref="fileInput" :required="!documentForm.id" @input="documentForm.file = $event.target.files[0]">
            </div>

            <div class="flex gap-1">
                <mui-input class="flex-1" label="Name" v-model="documentForm.name"/>
                <mui-input class="flex-1" label="URL freundlicher Name *" required v-model="documentForm.slug"/>
            </div>

            <div class="flex gap-1">
                <mui-input class="flex-1" label="Kategorie" v-model="documentForm.category"/>
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
                <mui-input class="flex-1" label="Tags" v-model="documentForm.tags"/>
            </div>

            <div class="flex wrap">
                <mui-toggle type="switch" v-model="documentForm.has_cover" label="Separates Cover"/>
                <div class="spacer"></div>
            </div>

            <div class="upload-box" v-show="documentForm.has_cover">
                <!-- <mui-button as="label" for="cover-input" size="small" variant="contained" label="Cover auswählen"/> -->
                <input type="file" id="cover-input" ref="coverInput" @input="documentForm.cover = $event.target.files[0]">
            </div>

            <div class="flex gap-1">
                <mui-input class="flex-1" label="Cover Alt-Text" v-model="documentForm.alt" v-show="documentForm.has_cover"/>
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
</template>

<script setup>
    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
    import { Inertia } from '@inertiajs/inertia'
    import Popup from '@/Components/Form/Popup.vue'
    import Loader from '@/Components/Form/Loader.vue'
    import Tag from '@/Components/Form/Tag.vue'
    import { slugify } from '@/Utils/String'
    import { ref, watch, computed } from 'vue'



    defineProps({
        documents: Array,
    })



    const uploadDocumentPopup = ref(null)
    const deleteDocumentPopup = ref(null)
    const fileInput = ref(null)
    const coverInput = ref(null)



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



    // watch(documentFormName, () => {
    //     documentForm.slug = slugify(documentForm.name)
    // })



    const openUploadDocumentPopup = (document) => {
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
            },
        })
    }

    const deleteDocument = () => {
        documentForm.delete(route('dashboard.admin.docs.delete', documentForm.id), {
            onSuccess() {
                closeUploadDocumentPopup()
                deleteDocumentPopup.value.close()
            },
        })
    }
</script>

<style lang="sass" scoped>
    .upload-box
        display: flex
        align-items: center
        justify-content: center
        width: 100%
        height: 150px
        background: var(--color-background-soft)
        border-radius: 8px

    .grid
        display: grid
        align-items: center
        grid-template-columns: minmax(170px, 2fr) minmax(200px, 3fr) minmax(200px, 3fr) minmax(200px, 3fr) minmax(200px, 3fr)
        grid-auto-rows: 50px
        gap: .5rem var(--su)
        width: 100%
        padding: 1rem
        overflow-x: auto

        .row
            display: contents
            cursor: pointer
            text-align: inherit
            font-family: inherit
            font-size: inherit
            color: inherit

            > span,
            > a
                overflow: hidden
                text-overflow: ellipsis
                white-space: nowrap

            .cover
                object-fit: contain
                background: var(--color-background-soft)
                border-radius: 5px

            .icon
                font-family: var(--font-icon)
                font-size: 1.5rem
                line-height: 1
                color: var(--color-text)
                user-select: none

                &.notified
                    color: var(--color-warning)

                &.active
                    color: var(--color-primary)

            &:hover
                background: var(--color-background-soft)
</style>