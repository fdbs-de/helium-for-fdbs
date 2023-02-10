<template>
    <AdminLayout :title="(form.name || 'Unbenanntes Formular') + ' – Formular bearbeiten'" :backlink="route('admin.forms.forms.overview')" backlink-text="Zurück zur Übersicht">
        <form class="card flex vertical gap-1 padding-1" @submit.prevent="saveItem()">
            <div class="limiter text-limiter" v-if="hasErrors">
                <h3><b>Fehler!</b></h3>
                <p v-for="(error, key) in errors" :key="key">{{ error }}</p>
            </div>

            <div class="flex v-center gap-1">
                <select class="header-select" v-model="editor.tab.status">
                    <option :value="null" disabled>Status auswählen</option>
                    <option value="draft">Entwurf</option>
                    <option value="published">Veröffentlicht</option>
                    <option value="hidden">Versteckt</option>
                </select>

                <div class="spacer"></div>
                
                <mui-button v-if="editor.tab.id" label="Formular Speichern" size="large" :loading="form.processing" @click="saveItem()"/>
                <mui-button v-else label="Formular erstellen" size="large" :loading="form.processing" @click="saveItem()"/>
            </div>
            
            <div class="flex gap-1 v-center">
                <mui-input type="text" class="flex-1" label="Name" required v-model="editor.tab.title"/>
            </div>
            
            <fieldset class="flex gap-1 vertical" v-for="page in editor.tab.pages">
                <mui-input type="text" class="flex-1" label="Seitentitel" required v-model="page.title"/>
            </fieldset>

            <!-- <mui-button label="Seite hinzufügen" size="large" @click="editor.tab.addPage()"/> -->
            <!-- <mui-button type="button" label="Test" size="large" @click="test()"/> -->
        </form>
    </AdminLayout>
</template>

<script setup>
    import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { slugify } from '@/Utils/String'
    import { ref, computed, watch } from 'vue'
    import FormEditor from '@/Classes/Apps/Forms/FormEditor'
    import FormTab from '@/Classes/Apps/Forms/FormTab'

    import AdminLayout from '@/Layouts/Admin.vue'
    import Switcher from '@/Components/Form/Switcher.vue'
    import TextEditor from '@/Components/Form/TextEditor.vue'

    const props = defineProps({
        item: Object,
    })

    const baseTab = new FormTab('form-editor').hydrate(props.item)
    const editor = ref(new FormEditor().addTab(baseTab, true))

    const test = () => {
        console.log(editor.value.tab.serialize())
    }



    // START: Item Form
    const form = useForm({
        id: null,
        name: '',
        status: 'draft',
        pages: [],
        actions: [],
    })

    const openItem = (item = null) => {
        form.id = item?.id ?? null
        form.name = item?.name ?? ''
        form.status = item?.status ?? 'draft'
        form.pages = item?.pages ?? []
        form.actions = item?.actions ?? []
    }

    watch((props) => props?.item, () => {
        openItem(props?.item)
    },{
        immediate: true,
        deep: true
    })

    const saveItem = () => {
        form.id ? updateItem() : storeItem()
    }

    const storeItem = () => {
        form.post(route('admin.forms.forms.store'), {
            onSuccess: (data) => {
                console.log(data?.props?.item)
                openItem(data?.props?.item)
            },
        })
    }

    const updateItem = () => {
        form.put(route('admin.forms.forms.update', form.id), {
            onSuccess: (data) => {
                openItem(data?.props?.item)
            },
        })
    }
    // END: Item Form

    
    
    // START: Error Handling
    const errors = computed(() => usePage().props.value.errors)
    const hasErrors = computed(() => Object.keys(errors.value).length > 0)
    // END: Error Handling
</script>

<style lang="sass" scoped>
    .card
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-m)

    .header-switcher
        height: 3rem
        box-shadow: none
        background: var(--color-background-soft)
        border-radius: var(--radius-s)

    .header-select
        height: 3rem
        cursor: pointer

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
        font-size: 1.35rem
        text-align: center
        color: var(--color-text)
        border-radius: .25rem
        flex: none

        &:hover,
        &:focus
            color: var(--mui-color__)
            background: var(--mui-background-secondary__)

        &.active
            color: var(--color-primary)

    input[type="color"]
        height: 2rem
        width: 3.5rem
        border: none
        padding: 0
        margin: 0
        -webkit-appearance: none

        &::-webkit-color-swatch-wrapper
            padding: 0

        &::-webkit-color-swatch
            border-radius: var(--radius-s)
            border: 1px solid white
        
    .content-input
        min-height: 25rem
</style>