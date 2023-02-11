<template>
    <AdminLayout :title="(editor.tab.title || 'Unbenanntes Formular') + ' – Formular bearbeiten'" :backlink="route('admin.forms.forms.overview')" backlink-text="Zurück zur Übersicht">
        <form class="card flex vertical gap-1 padding-1" @submit.prevent="saveItem()">
            <div class="limiter text-limiter" v-if="hasErrors">
                <h3><b>Fehler!</b></h3>
                <p v-for="(error, key) in errors" :key="key">{{ error }}</p>
            </div>

            <div class="grid">
                <div class="content">
                    <div class="flex v-center gap-1">
                        <select class="header-select" v-model="editor.tab.status">
                            <option :value="null" disabled>Status auswählen</option>
                            <option value="draft">Entwurf</option>
                            <option value="published">Veröffentlicht</option>
                            <option value="hidden">Versteckt</option>
                        </select>
        
                        <div class="spacer"></div>
                        
                        <mui-button v-if="editor.tab.id" label="Speichern" size="large"/>
                        <mui-button v-else label="Erstellen" size="large"/>
                    </div>
                    
                    <div class="flex gap-1 v-center">
                        <mui-input type="text" class="flex-1" label="Name" required v-model="editor.tab.title"/>
                    </div>

                    <fieldset class="flex gap-1 vertical">
                        <legend>Seiten</legend>

                        <fieldset class="flex gap-1 vertical" v-for="page in editor.tab.pages">
                            <legend class="flex v-center gap-1">
                                {{ page.title }}
                                <span class="flex radius-m background-soft">
                                    <IconButton type="button" icon="edit" @click="editor.tab.selectPage(page)"/>
                                    <IconButton type="button" icon="delete" style="color: var(--color-error)" @click="editor.tab.removePage(page)" />
                                </span>
                            </legend>
                            
                            <fieldset class="flex vertical" v-for="input in page.inputs">
                                <legend class="flex v-center gap-1">
                                    <Tag shape="pill" color="var(--color-heading)" :icon="input.icon">{{ input.options.label }}</Tag>
                                    <span class="flex radius-m background-soft">
                                        <IconButton type="button" icon="edit" @click="editor.tab.selectInput(input)"/>
                                        <IconButton type="button" icon="delete" style="color: var(--color-error)" @click="editor.tab.removeInput(input)"/>
                                    </span>
                                </legend>
                                <span>Name: {{ input.key }}</span>
                                <span>Typ: {{ input.inputType }}</span>
                                <span>
                                    Ausfüllen:
                                    <Tag shape="pill" variant="contained" color="var(--color-red)" v-if="input.validation.required">Verpflichtend</Tag>
                                    <Tag shape="pill" variant="contained" color="var(--color-green)" v-else>Optional</Tag>
                                </span>
                            </fieldset>
                            
                            <mui-button type="button" label="Feld hinzufügen" @click="addInput(page)"/>
                        </fieldset>
            
                        <mui-button type="button" label="Seite hinzufügen" @click="addPage(editor.tab)"/>
                    </fieldset>
                    


                    <fieldset class="flex gap-1 vertical">
                        <legend>Aktionen</legend>

                        <fieldset class="flex gap-1 vertical" v-for="action in editor.tab.actions">
                            <div class="flex v-center gap-1">
                                <span class="flex-1">{{ action.type }}</span>
                                <IconButton type="button" icon="edit" @click="editor.tab.selectAction(action)"/>
                                <IconButton type="button" icon="delete" style="color: var(--color-error)" @click="editor.tab.removeAction(action)"/>
                            </div>
                        </fieldset>
    
                        <mui-button type="button" label="Aktion hinzufügen" @click="addAction(editor.tab)"/>
                    </fieldset>
                </div>



                <div class="inspector">
                    <template v-if="editor.tab.selection.action">
                        <select v-model="editor.tab.selection.action.type">
                            <option :value="null" disabled>Aktionstyp auswählen</option>
                            <option value="send-mail">Email Versenden</option>
                            <option value="show-message">Nachricht anzeigen</option>
                        </select>

                        <template v-if="editor.tab.selection.action.type === 'send-mail'">
                            <mui-input type="text" label="Empfänger" v-model="editor.tab.selection.action.options.mail.to"/>
                            <mui-input type="text" label="CC" v-model="editor.tab.selection.action.options.mail.cc"/>
                            <mui-input type="text" label="BCC" v-model="editor.tab.selection.action.options.mail.bcc"/>
                            <mui-input type="text" label="Absender" v-model="editor.tab.selection.action.options.mail.from"/>
                            <mui-input type="text" label="Absendername" v-model="editor.tab.selection.action.options.mail.fromName"/>
                            <mui-input type="text" label="Betreff" v-model="editor.tab.selection.action.options.mail.subject"/>
                            <mui-input type="textarea" label="Inhalt" v-model="editor.tab.selection.action.options.mail.body"/>
                        </template>

                        <template v-if="editor.tab.selection.action.type === 'show-message'">
                            <mui-input type="text" label="Titel" v-model="editor.tab.selection.action.options.message.title"/>
                            <mui-input type="textarea" label="Inhalt" v-model="editor.tab.selection.action.options.message.body"/>
                        </template>

                        <hr>

                        <mui-button type="button" label="Aktion löschen" color="error" @click="editor.tab.removeAction(editor.tab.selection.action)"/>
                    </template>

                    <template v-if="editor.tab.selection.page">
                        <mui-input type="text" label="Seitentitel" required v-model="editor.tab.selection.page.title"/>
                        <mui-button type="button" label="Seite löschen" color="error" @click="editor.tab.removePage(editor.tab.selection.page)"/>
                    </template>

                    <template v-if="editor.tab.selection.input">
                        <select v-model="editor.tab.selection.input.inputType">
                            <option :value="null" disabled>Feldtyp auswählen</option>
                            <option value="text">Text</option>
                            <option value="email">Email</option>
                            <option value="tel">Telefon</option>
                            <option value="password">Passwort</option>
                            <option value="number">Zahl</option>
                            <option value="textarea">Textbereich</option>
                            <option value="select">Select</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="radio">Radio</option>
                        </select>
                        <mui-input type="text" label="Label" v-model="editor.tab.selection.input.options.label"/>
                        <mui-input type="text" label="Feldname" required v-model="editor.tab.selection.input.key"/>
                        <mui-input type="text" label="Placeholder" v-model="editor.tab.selection.input.options.placeholder"/>
                        <mui-input type="text" label="Hilfetext" v-model="editor.tab.selection.input.options.helpText"/>
                        <hr>
                        <mui-toggle label="Pflichtfeld" v-model="editor.tab.selection.input.validation.required"/>
                        <mui-input type="text" label="Fehlermeldung" v-model="editor.tab.selection.input.validation.errorMessage"/>
                        <hr>
                        <mui-button type="button" label="Feld löschen" color="error" @click="editor.tab.removeInput(editor.tab.selection.input)"/>
                    </template>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>

<script setup>
    import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { slugify } from '@/Utils/String'
    import { ref, computed, watch } from 'vue'
    import FormEditor from '@/Classes/Apps/Forms/FormEditor'
    import FormTab from '@/Classes/Apps/Forms/FormTab'
    import FormPage from '@/Classes/Apps/Forms/FormPage'
    import FormInput from '@/Classes/Apps/Forms/FormInput'
    import FormAction from '@/Classes/Apps/Forms/FormAction'

    import AdminLayout from '@/Layouts/Admin.vue'
    import Switcher from '@/Components/Form/Switcher.vue'
    import TextEditor from '@/Components/Form/TextEditor.vue'
    import Tag from '@/Components/Form/Tag.vue'
    import IconButton from '@/Components/Apps/Pages/IconButton.vue'

    const props = defineProps({
        item: Object,
    })

    const baseTab = new FormTab('form-editor').hydrate(props.item)
    const editor = ref(new FormEditor().addTab(baseTab, true))



    const addAction = (tab) => {
        tab.addAction(new FormAction())
    }

    const addPage = (tab) => {
        tab.addPage(new FormPage())
    }

    const addInput = (page) => {
        page.addInput(new FormInput())
    }



    // START: Item Form
    const openItem = (item = null) => {
        
    }

    watch((props) => props?.item, () => {
        openItem(props?.item)
    },{
        immediate: true,
        deep: true
    })

    const saveItem = () => {
        editor.value.tab.id ? updateItem() : storeItem()
    }

    const storeItem = () => {
        useForm(editor.value.tab.serialize())
        .post(route('admin.forms.forms.store'), {
            onSuccess: (data) => {
                console.log(data?.props?.item)
                openItem(data?.props?.item)
            },
        })
    }

    const updateItem = () => {
        console.log(editor.value.tab.serialize())
        // return false
        useForm(editor.value.tab.serialize())
        .put(route('admin.forms.forms.update', editor.value.tab.id), {
            onSuccess: (data) => {
                // openItem(data?.props?.item)
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

    .grid
        display: grid
        grid-template-columns: 1fr 350px
        grid-template-areas: "content inspector"
        grid-gap: 1rem

        .content
            grid-area: content
            display: flex
            flex-direction: column
            gap: 1rem

        .inspector
            grid-area: inspector
            display: flex
            flex-direction: column
            gap: 1rem
</style>