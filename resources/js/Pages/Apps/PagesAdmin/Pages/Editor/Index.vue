<template>
    <div class="page-editor-layout">
        <div class="tool-bar">
            <div class="start">
                <mui-button class="with-label" variant="contained" icon-left="add" label="Neu"/>
                <div class="spacer"></div>
            </div>
            <div class="center">
                <div class="breakpoint-selector">
                    <IconButton
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
                <IconButton icon="undo" v-tooltip.bottom="'Rückgangig (Strg+Z)'"/>
                <IconButton icon="redo" v-tooltip.bottom="'Wiederherstellen (Strg+Y)'"/>
                <IconButton icon="history" v-tooltip.bottom="'Bearbeitungsverlauf'"/>
                <div class="spacer"></div>
                <mui-button class="with-label" variant="contained" label="Speichern" v-tooltip.bottom="'Speichern (Strg+S)'" @click="tab.save()"/>
                <IconButton is="a" icon="open_in_new" v-tooltip.bottom="'Seite öffnen'" :href="route('app.pages.render.page', tab.data.slug)" target="_blank"/>
            </div>
        </div>



        <div class="sidebar navigator small-scrollbar">
            <div class="group no-padding">
                <Tabs v-model="tab.ui.navigator.panel" :tabs="[
                    { label: 'Elemente', value: 'elements' },
                ]" />
            </div>
            <div class="flex vertical">
                <button type="button" class="flex vertical" v-for="elementTemplate, key in ElementTemplates" :key="key" @click="tab.createElement(elementTemplate)">
                    <b>{{ elementTemplate.name }}</b>
                    <span>{{ elementTemplate.description }}</span>
                </button>

                <Container @drop="tab.dropElement($event)" lock-axis="y" drag-handle-selector=".handle">            
                    <Draggable v-for="element in tab.data.content" :key="element.localId">
                        <div class="content-element flex v-center" :class="{'selected': tab.selected.elements.includes(element.localId)}">
                            <IconButton class="handle" icon="drag_indicator"/>
                            <div class="flex-1 flex vertical" @click="tab.selectElement(element)">
                                {{ element.type }}
                            </div>
                            <IconButton icon="delete" @click=""/>
                        </div>
                    </Draggable>
                </Container>
            </div>
        </div>



        <div class="viewport-wrapper">
            <div class="viewport" :style="`max-width: ${tab.breakpoint.width}px`">
                <BlockBuilderCollector :elements="tab.data.content" />
            </div>
        </div>



        <div class="sidebar inspector small-scrollbar">
            <div class="group no-padding">
                <Tabs v-model="tab.ui.inspector.panel" :tabs="[
                    { label: 'Element', value: 'element' },
                    { label: 'Seite', value: 'page' },
                ]" />
            </div>

            <template v-if="tab.ui.inspector.panel == 'page'">
                <div class="group">
                    <select class="default-select" v-model="tab.data.status">
                        <option :value="null" disabled>Status</option>
                        <option value="draft">Entwurf</option>
                        <option value="published">Veröffentlicht</option>
                        <option value="hidden">Versteckt</option>
                    </select>
                    <mui-input class="default-text-input" placeholder="Titel" v-model="tab.data.title"/>
                    <mui-input class="default-text-input" placeholder="Slug" v-model="tab.data.slug"/>
                </div>
            </template>

            <Inspector :tab="tab" v-if="tab.ui.inspector.panel == 'element'"/>
        </div>
    </div>

    <Picker ref="picker" />
</template>

<script setup>
    import hotkeys from 'hotkeys-js'
    import ElementTemplates from '@/Pages/Apps/Pages/ElementTemplates'
    import { Container, Draggable } from 'vue3-smooth-dnd'

    import BlockBuilderCollector from '@/Pages/Apps/Pages/Renderer/BlockBuilderCollector.vue'
    import Inspector from '@/Pages/Apps/PagesAdmin/Pages/Editor/Partials/Inspector.vue'
    import IconButton from '@/Components/Apps/Pages/IconButton.vue'
    import Picker from '@/Components/Form/MediaLibrary/Picker.vue'
    import Tabs from '@/Components/Form/Tabs.vue'
    import TextEditor from '@/Components/Form/TextEditor.vue'
    import CodeEditor from '@/Components/Form/CodeEditor.vue'
    import Popup from '@/Components/Form/Popup.vue'



    const props = defineProps({
        tab: {
            type: Object,
            required: true,
        },
    })


    
    // START: Keyboard Shortcuts
    hotkeys('ctrl+s', (event, handler) => { event.preventDefault(); console.log('SAVE') })
    hotkeys('ctrl+shift+s', (event, handler) => { event.preventDefault(); console.log('SAVE AS') })

    // Page Editor specific
    hotkeys('alt+1', (event, handler) => { event.preventDefault(); console.log('SELECT BREAKPOINT 1') })
    hotkeys('alt+2', (event, handler) => { event.preventDefault(); console.log('SELECT BREAKPOINT 2') })
    hotkeys('alt+3', (event, handler) => { event.preventDefault(); console.log('SELECT BREAKPOINT 3') })
    hotkeys('alt+4', (event, handler) => { event.preventDefault(); console.log('SELECT BREAKPOINT 4') })
    hotkeys('alt+5', (event, handler) => { event.preventDefault(); console.log('SELECT BREAKPOINT 5') })
    hotkeys('alt+6', (event, handler) => { event.preventDefault(); console.log('SELECT BREAKPOINT 6') })
    hotkeys('alt+7', (event, handler) => { event.preventDefault(); console.log('SELECT BREAKPOINT 7') })
    hotkeys('alt+8', (event, handler) => { event.preventDefault(); console.log('SELECT BREAKPOINT 8') })
    hotkeys('alt+9', (event, handler) => { event.preventDefault(); console.log('SELECT BREAKPOINT 9') })
    hotkeys('alt+0', (event, handler) => { event.preventDefault(); console.log('SELECT BREAKPOINT 10') })

    hotkeys('ctrl+c', (event, handler) => { event.preventDefault(); console.log('COPY') })
    hotkeys('ctrl+d', (event, handler) => { event.preventDefault(); console.log('DUPLICATE') })
    hotkeys('ctrl+x', (event, handler) => { event.preventDefault(); console.log('CUT') })
    hotkeys('ctrl+v', (event, handler) => { event.preventDefault(); console.log('PASTE') })

    hotkeys('ctrl+z', (event, handler) => { event.preventDefault(); console.log('UNDO') })
    hotkeys('ctrl+y', (event, handler) => { event.preventDefault(); console.log('REDO') })
    hotkeys('ctrl+shift+z', (event, handler) => { event.preventDefault(); console.log('REDO') })

    hotkeys('shift+n', (event, handler) => { event.preventDefault(); console.log('NEW ELEMENT') })
    hotkeys('delete, backspace', (event, handler) => { event.preventDefault(); console.log('DELETE') })
    // END: Keyboard Shortcuts
</script>

<style lang="sass" scoped>
    .page-editor-layout
        flex: 1
        height: calc(100% - 2.25rem)
        display: grid
        grid-template-columns: 22rem 1fr 22rem
        grid-template-rows: 4rem 1fr auto
        grid-template-areas: "tool-bar tool-bar tool-bar" "navigator viewport inspector" "navigator code-editor inspector"

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
                width: 22rem
                padding-inline: 1rem

                > button.with-label
                    --primary: var(--color-heading-on-background-dark)

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

                    > button
                        border-radius: var(--radius-s)
                        height: 100%
                        color: var(--color-text-on-background-dark)

                        &.active
                            background: var(--color-background-dark)
                            color: var(--color-heading-on-background-dark)

        .navigator
            grid-area: navigator

            .content-element.selected
                background: var(--color-background-soft)

        .inspector
            grid-area: inspector

        .viewport-wrapper
            grid-area: viewport
            display: flex
            flex-direction: column
            align-items: center
            padding: 1rem

            .viewport
                width: 100%
                max-height: 100%
                min-height: 8rem
                overflow: auto
                background: white
                border: 1px solid var(--color-background-soft)
                border-radius: var(--radius-s)
                box-shadow: var(--shadow-elevation-low)

        .sidebar
            height: 100%
            background: var(--color-background)
            box-shadow: var(--shadow-elevation-low)
            color: var(--color-heading)
            overflow-y: auto

            .group
                padding: 1rem .5rem
                display: flex
                flex-direction: column
                gap: .5rem
                border-bottom: 1px solid var(--color-border)

                &.no-padding
                    padding: 0

                &.horizontal
                    flex-direction: row
                    align-items: center
                    gap: 0

                .title
                    font-size: .8rem
                    font-weight: 600
                    letter-spacing: .05rem
                    text-transform: uppercase
                    color: var(--color-text)
                    user-select: none

                .spacer
                    flex: 1
</style>