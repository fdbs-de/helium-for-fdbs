<template>
    <div class="page-editor-layout">
        <div class="tool-bar">
            <div class="start">
                <mui-button class="with-label" variant="contained" icon-left="add" label="Neu"/>
                <div class="spacer"></div>
                <IconButton icon="undo" v-tooltip.bottom="'Rückgangig (Strg+Z)'"/>
                <IconButton icon="redo" v-tooltip.bottom="'Wiederherstellen (Strg+Y)'"/>
                <IconButton icon="history" v-tooltip.bottom="'Bearbeitungsverlauf'"/>
            </div>
            <div class="center">
                <div class="breakpoint-selector">
                    <!-- <IconButton
                        v-for="(breakpoint, index) in editor.breakpoints"
                        :key="breakpoint.id"
                        :icon="breakpoint.icon"
                        :class="{'active': index == editor.tab.selected.breakpoint}"
                        v-tooltip.bottom="{content: breakpoint.tooltip, html: true}"
                        @click="editor.selectBreakpoint(index)"
                    /> -->
                </div>
            </div>
            <div class="end">
                <div class="spacer"></div>
                <mui-button class="with-label" variant="contained" label="Speichern" v-tooltip.bottom="'Speichern (Strg+S)'"/>
                <IconButton icon="visibility" v-tooltip.bottom="'Vorschau'"/>
            </div>
        </div>



        <div class="navigator">
        </div>



        <div class="viewport-wrapper">
            <iframe class="viewport"></iframe>
        </div>



        <div class="inspector small-scrollbar">
            <div class="input-group" style="padding-block: 0;">
                <Tabs :tabs="[
                    { label: 'Design', value: 'design' },
                    { label: 'Styles', value: 'styles' },
                    { label: 'Page', value: 'page' },
                ]" />
            </div>

            <template v-if="true">
                <div class="input-group">
                    <select class="default-select" v-model="tab.status">
                        <option :value="null" disabled>Status</option>
                        <option value="draft">Entwurf</option>
                        <option value="published">Veröffentlicht</option>
                        <option value="hidden">Versteckt</option>
                    </select>
                    <mui-input class="default-text-input" placeholder="Titel" v-model="tab.title"/>
                    <mui-input class="default-text-input" placeholder="Slug" v-model="tab.slug"/>
                </div>
            </template>
        </div>
    </div>

    <Picker ref="picker" />
</template>

<script setup>
    import hotkeys from 'hotkeys-js'

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
        grid-template-rows: 4rem auto 1fr
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
            background: var(--color-background)
            box-shadow: var(--shadow-elevation-low)
            padding: 1rem 0

        .viewport-wrapper
            grid-area: viewport
            display: flex
            flex-direction: column
            align-items: center
            padding: 1rem

            iframe.viewport
                width: 100%
                min-height: 15rem
                background: white
                border: 0
                box-shadow: var(--shadow-elevation-low)

        .inspector
            grid-area: inspector
            height: 100%
            background: var(--color-background)
            box-shadow: var(--shadow-elevation-low)
            color: var(--color-heading)
            overflow-y: auto

            .input-group
                padding: 1rem .5rem
                display: flex
                flex-direction: column
                gap: .5rem
                border-bottom: 1px solid var(--color-border)

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

                > button.error
                    color: var(--color-error)
</style>