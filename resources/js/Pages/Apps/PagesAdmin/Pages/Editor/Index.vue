<template>
    <div class="page-editor-layout">
        <div class="tool-bar">
            <div class="start">
                <IodButton type="button" class="transparent" variant="contained" icon-left="add" label="Neu" v-tooltip.right="'Neues Element (Shift+N)'" @click="elementCatalog.open()"/>
                <div class="spacer"></div>
                <IodIconButton type="button" class="transparent" variant="text" icon="undo" v-tooltip.bottom="'Rückgangig (Strg+Z)'"/>
                <IodIconButton type="button" class="transparent" variant="text" icon="redo" v-tooltip.bottom="'Wiederherstellen (Strg+Y)'"/>
                <IodIconButton type="button" class="transparent" variant="text" icon="history" v-tooltip.bottom="'Bearbeitungsverlauf'"/>
            </div>
            <div class="center">
                <div class="breakpoint-selector">
                    <IodIconButton
                        type="button"
                        variant="text"
                        v-for="(breakpoint, index) in tab.breakpoints"
                        :key="breakpoint.id"
                        :icon="breakpoint.icon"
                        :class="{'active': index == tab.selected.breakpoint}"
                        v-tooltip.bottom="{content: breakpoint.tooltip, html: true}"
                        @click="tab.selectBreakpoint(index)"
                    />
                </div>
            </div>
            <div class="end">
                <IodIconButton type="button" class="transparent" variant="text" icon="settings" v-tooltip.left="'Media Manager (Strg+M)'" @click="pageSettingsPopup.open()"/>
                <IodIconButton type="button" class="transparent" variant="text" icon="upload" v-tooltip.left="'Seiteneinstellungen (Strg+P)'" @click="picker.open()"/>
                <IodIconButton type="button" class="transparent" variant="text" icon="open_in_new" v-tooltip.left="'Seite öffnen'" is="a" :href="route('app.pages.render.page', tab.data.slug)" target="_blank"/>
                <div class="spacer"></div>
                <IodButton type="button" class="transparent" variant="contained" label="Speichern" v-tooltip.left="'Speichern (Strg+S)'" @click="tab.save()" :loading="tab.processing.saving"/>
            </div>
        </div>



        <div class="navigator">
            <Navigator :tab="tab" />
            <ElementCatalog :tab="tab" ref="elementCatalog"/>
        </div>

        <Viewport class="viewport" :tab="tab" />

        <Inspector class="inspector" :tab="tab" :picker="picker" @update:element="tab.updateElement($event)"/>
    </div>

    

    <Popup ref="pageSettingsPopup">
        <div class="flex vertical">
            <div class="flex padding-1 border-bottom">
                <Tabs v-model="tab.ui.settings.panel" indicator-style="box" :tabs="[
                    { label: 'Allgemein', value: 'general' },
                    { label: 'SEO', value: 'seo' },
                    { label: 'Berechtigungen', value: 'permissions' },
                ]"/>
            </div>
    
            <div class="flex vertical gap-1 padding-1" v-show="tab.ui.settings.panel === 'general'">
                <select class="default-select" v-model="tab.data.status">
                    <option :value="null" disabled>Status</option>
                    <option value="draft">Entwurf</option>
                    <option value="published">Veröffentlicht</option>
                    <option value="hidden">Versteckt</option>
                </select>
                <IodInput label="Titel" v-model="tab.data.title"/>
                <IodInput label="Slug" v-model="tab.data.slug"/>
                <IodInput label="Überseite" v-model="tab.data.parent_id"/>
                <IodInput type="number" :step=".1" :min="0" :max="1" label="Priorität" v-model="tab.data.priority"/>
                <select class="default-select" v-model="tab.data.language">
                    <option value="*">Sprache</option>
                    <option value="de">Deutsch</option>
                    <option value="en">Englisch</option>
                </select>
            </div>
            
            <div class="flex vertical gap-1 padding-1" v-show="tab.ui.settings.panel === 'seo'">
                <IodInput label="Meta-Beschreibung" v-model="tab.data.meta.description"/>
                <IodInput v-model="tab.data.meta.image" label="Meta-Image">
                    <template #right>
                        <IodIconButton type="button" class="folder-trigger" icon="folder_open" shape="radius-s" variant="text" size="small" @click="picker.open((file) => { tab.data.meta.image = file })"/>
                    </template>
                </IodInput>
            </div>
            
            <div class="flex vertical gap-1 padding-1" v-show="tab.ui.settings.panel === 'permissions'">
                <IodToggle v-if="tab.data.parent_of" type="switch" label="Berechtigungen überschreiben" v-model="tab.data.strict_permissions"/>
                <IodToggle type="switch" label="Nutzer müssen angemeldet sein" v-model="tab.data.require_auth"/>
                <IodToggle type="switch" label="Nutzer müssen verifiziert sein" v-model="tab.data.require_verification"/>
            </div>
        </div>
    </Popup>

    <Picker ref="picker" />
</template>

<script setup>
    import { ref } from 'vue'
    import hotkeys from 'hotkeys-js'

    import ElementCatalog from '@/Pages/Apps/PagesAdmin/Pages/Editor/Partials/ElementCatalog.vue'
    import Navigator from '@/Pages/Apps/PagesAdmin/Pages/Editor/Partials/Navigator.vue'
    import Inspector from '@/Pages/Apps/PagesAdmin/Pages/Editor/Partials/Inspector.vue'
    import Viewport from '@/Pages/Apps/PagesAdmin/Pages/Editor/Partials/Viewport.vue'
    import Picker from '@/Components/Form/MediaLibrary/Picker.vue'
    import Tabs from '@/Components/Form/Tabs.vue'
    import Popup from '@/Components/Form/Popup.vue'



    const props = defineProps({
        tab: {
            type: Object,
            required: true,
        },
    })

    const picker = ref(null)
    const pageSettingsPopup = ref(null)
    const elementCatalog = ref(null)
    


    props.tab.prefetchData()

    
    
    // START: Keyboard Shortcuts
    hotkeys('ctrl+s', (event, handler) => { event.preventDefault(); props.tab.save() })

    // Page Editor specific
    hotkeys('ctrl+z', (event, handler) => { event.preventDefault(); console.log('UNDO') })
    hotkeys('ctrl+y, ctrl+shift+z', (event, handler) => { event.preventDefault(); console.log('REDO') })
    
    hotkeys('ctrl+p', (event, handler) => { event.preventDefault(); pageSettingsPopup.value.open() })
    hotkeys('ctrl+m', (event, handler) => { event.preventDefault(); picker.value.open() })

    hotkeys('num_add, shift+n', (event, handler) => { event.preventDefault(); elementCatalog.value.open() })
    hotkeys('delete, backspace', (event, handler) => { event.preventDefault(); props.tab.removeElements(props.tab.selectedElements) })
    // END: Keyboard Shortcuts
</script>

<style lang="sass" scoped>
    .page-editor-layout
        flex: 1
        height: calc(100% - 2.25rem)
        display: grid
        background: var(--color-background-soft)
        grid-template-columns: 25rem 1fr 25rem
        grid-template-rows: 4rem 1fr auto
        grid-template-areas: "tool-bar tool-bar tool-bar" "navigator viewport inspector" "navigator code-editor inspector"

        .iod-button.transparent,
        .iod-icon-button.transparent
            --local-color-background: var(--color-text-on-background-dark)

        .tool-bar
            grid-area: tool-bar
            display: flex
            align-items: center
            background: var(--color-background-dark)
            color: var(--color-background)
            box-shadow: var(--shadow-elevation-low)

            .spacer
                flex: 1

            .start,
            .end
                display: flex
                align-items: center
                width: 25rem
                padding-inline: 1rem
                gap: .5rem

            .center
                flex: 1
                display: flex
                align-items: center
                justify-content: center

                .breakpoint-selector
                    display: flex
                    align-items: center
                    justify-content: center
                    border-radius: var(--radius-m)
                    padding: .25rem
                    gap: .25rem
                    height: 2.5rem
                    background: var(--color-background-dark-soft)

                    .iod-button,
                    .iod-icon-button
                        border-radius: var(--radius-s)
                        height: 100%
                        --local-color-background: var(--color-text-soft-on-background-dark)

                        &.active
                            background: var(--color-background-dark)
                            color: var(--color-text-on-background-dark)


        .navigator,
        .inspector
            height: 100%
            background: var(--color-background)
            box-shadow: var(--shadow-elevation-low)
            color: var(--color-text)
            display: flex
            flex-direction: column
            overflow-y: auto
            position: relative

        .navigator
            grid-area: navigator

        .inspector
            grid-area: inspector

        .viewport-wrapper
            grid-area: viewport
</style>