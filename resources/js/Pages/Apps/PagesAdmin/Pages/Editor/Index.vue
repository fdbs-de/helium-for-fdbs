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
                <IconButton is="a" icon="open_in_new" v-tooltip.bottom="'Seite öffnen'" :href="route('app.pages.render.page', tab.data.slug)" target="_blank"/>
                <mui-button class="with-label" variant="contained" label="Speichern" v-tooltip.bottom="'Speichern (Strg+S)'" @click="tab.save()" :loading="tab.processing.saving"/>
            </div>
        </div>



        <div class="sidebar navigator">
            <div class="tab-box">
                <Tabs v-model="tab.ui.navigator.panel" indicator-style="box" :tabs="[
                    { label: 'Elemente', value: 'elements' },
                    { label: 'Hinzufügen', value: 'add' },
                ]" />
            </div>

            <div class="scroll-box small-scrollbar" v-show="tab.ui.navigator.panel == 'add'">
                <div class="group">
                    <IodButton type="button" class="flex vertical" v-for="elementTemplate, key in ElementTemplates" :key="key" @click="tab.createElement(elementTemplate)">
                        <b>{{ elementTemplate.name }}</b>
                        <span>{{ elementTemplate.description }}</span>
                    </IodButton>
                </div>
            </div>

            <Container class="scroll-box small-scrollbar" v-show="tab.ui.navigator.panel == 'elements'" @drop="tab.dropElement($event)" lock-axis="y">            
                <Draggable v-for="element in tab.data.content" :key="element.localId">
                    <div class="content-element flex v-center" :class="{'selected': tab.selected.elements.includes(element.localId)}">
                        <IodIcon class="handle" icon="drag_indicator"/>
                        <div class="flex-1 flex vertical" @click="tab.selectElement(element)">
                            {{ element.type }}
                        </div>
                        <IodIconButton icon="delete" variant="text" color-preset="error" @click="tab.removeElement(element)"/>
                    </div>
                </Draggable>
            </Container>
        </div>



        <div class="viewport-wrapper">
            <div class="viewport" :style="`max-width: ${tab.breakpoint.width}px`">
                <BlockBuilderCollector :elements="tab.data.content" />
            </div>
        </div>



        <div class="sidebar inspector">
            <div class="tab-box">
                <Tabs v-model="tab.ui.inspector.panel" indicator-style="box" :tabs="[
                    { label: 'Element', value: 'element' },
                    { label: 'Seite', value: 'page' },
                ]" />
            </div>

            <div class="scroll-box small-scrollbar" v-show="tab.ui.inspector.panel == 'element'">
                <Inspector :tab="tab" @update:element="tab.updateElement($event)"/>
            </div>
            
            <div class="scroll-box small-scrollbar" v-show="tab.ui.inspector.panel == 'page'">
                <div class="group">
                    <select class="default-select" v-model="tab.data.status">
                        <option :value="null" disabled>Status</option>
                        <option value="draft">Entwurf</option>
                        <option value="published">Veröffentlicht</option>
                        <option value="hidden">Versteckt</option>
                    </select>
                    <IodInput class="default-text-input" label="Titel" v-model="tab.data.title"/>
                    <IodInput class="default-text-input" label="Slug" v-model="tab.data.slug"/>
                </div>
            </div>
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
        grid-template-columns: 25rem 1fr 25rem
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
                width: 25rem
                padding-inline: 1rem

                > button.with-label
                    --primary: var(--color-text-on-background-dark)

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
                        color: var(--color-text-soft-on-background-dark)

                        &.active
                            background: var(--color-background-dark)
                            color: var(--color-text-on-background-dark)

        .navigator
            grid-area: navigator

            .content-element
                user-select: none
                position: relative
                padding: .25rem .5rem
                color: var(--color-text)
                transition: background 100ms ease
                cursor: pointer

                &::after
                    content: ''
                    position: absolute
                    top: .5rem
                    left: 0
                    bottom: .5rem
                    width: .2rem
                    border-radius: 0 3px 3px 0
                    background: currentColor
                    opacity: 0
                    user-select: none
                    pointer-events: none

                &:hover
                    background: var(--color-background-soft)
                    
                    &::after
                        opacity: .5

                &.selected
                    background: var(--color-background-soft)

                    &::after
                        opacity: 1

                .handle
                    width: 2rem
                    font-size: 1.25rem
                    color: var(--color-text-soft)

        .inspector
            grid-area: inspector

        .sidebar
            height: 100%
            background: var(--color-background)
            box-shadow: var(--shadow-elevation-low)
            color: var(--color-text)
            display: flex
            flex-direction: column

            .tab-box
                flex: none
                padding: .5rem
                border-bottom: 1px solid var(--color-border)

                .tabs-wrapper
                    --tab-height: 2rem
                    font-size: .8rem

            .scroll-box
                flex: 1
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
                    color: var(--color-text-soft)
                    user-select: none

                .spacer
                    flex: 1

        .viewport-wrapper
            grid-area: viewport
            display: flex
            flex-direction: column
            align-items: center
            padding: 1rem

            .viewport
                width: 100%
                max-height: 80vh
                overflow: auto
                background: white
                border: 1px solid var(--color-background-soft)
                border-radius: var(--radius-s)
                box-shadow: var(--shadow-elevation-low)
</style>