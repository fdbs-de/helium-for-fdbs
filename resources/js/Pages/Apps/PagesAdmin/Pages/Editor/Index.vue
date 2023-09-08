<template>
    <div class="page-editor-layout">
        <div class="tool-bar">
            <div class="start">
                <VDropdown placement="bottom-end">
                    <IodButton type="button" class="transparent" variant="contained" icon-left="add" label="Neu" v-tooltip.right="'Neues Element'" />

                    <template #popper>
                        <div class="flex padding-1 gap-1 wrap">
                            <AddElementButton v-for="elementTemplate, key in ElementTemplates" :key="key" @click="tab.createElement(elementTemplate, true)" :template="elementTemplate"/>
                        </div>
                    </template>
                </VDropdown>
                <div class="spacer"></div>
                <!-- <IodIconButton type="button" class="transparent" variant="text" icon="undo" v-tooltip.bottom="'Rückgangig (Strg+Z)'"/>
                <IodIconButton type="button" class="transparent" variant="text" icon="redo" v-tooltip.bottom="'Wiederherstellen (Strg+Y)'"/>
                <IodIconButton type="button" class="transparent" variant="text" icon="history" v-tooltip.bottom="'Bearbeitungsverlauf'"/> -->
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
                <VDropdown placement="bottom-start">
                    <IodIconButton type="button" class="transparent" variant="text" icon="settings" v-tooltip.left="'Seiteneinstellungen'" />

                    <template #popper>
                        <div class="flex vertical padding-1 gap-1 w-25">
                            <select class="default-select" v-model="tab.data.status">
                                <option :value="null" disabled>Status</option>
                                <option value="draft">Entwurf</option>
                                <option value="published">Veröffentlicht</option>
                                <option value="hidden">Versteckt</option>
                            </select>
                            <IodInput class="default-text-input" label="Titel" v-model="tab.data.title"/>
                            <IodInput class="default-text-input" label="Slug" v-model="tab.data.slug"/>
                        </div>
                    </template>
                </VDropdown>
                <IodIconButton class="transparent" variant="text" is="a" icon="open_in_new" v-tooltip.left="'Seite öffnen'" :href="route('app.pages.render.page', tab.data.slug)" target="_blank"/>
                <div class="spacer"></div>
                <IodButton type="button" class="transparent" variant="contained" label="Speichern" v-tooltip.left="'Speichern (Strg+S)'" @click="tab.save()" :loading="tab.processing.saving"/>
            </div>
        </div>



        <div class="sidebar navigator">
            <Navigator class="scroll-box small-scrollbar" :tab="tab" />
        </div>



        <Viewport class="viewport-wrapper" :tab="tab" />



        <div class="sidebar inspector">
            <div class="scroll-box small-scrollbar">
                <Inspector :tab="tab" :picker="picker" @update:element="tab.updateElement($event)"/>
                <!-- {{ tab.dataNeedingPrefetch }} -->
                <!-- {{ tab.data.content }} -->
            </div>
        </div>
    </div>

    <Picker ref="picker" />
</template>

<script setup>
    import { ref } from 'vue'
    import hotkeys from 'hotkeys-js'
    import ElementTemplates from '@/Pages/Apps/Pages/ElementTemplates'

    import Navigator from '@/Pages/Apps/PagesAdmin/Pages/Editor/Partials/Navigator.vue'
    import Inspector from '@/Pages/Apps/PagesAdmin/Pages/Editor/Partials/Inspector.vue'
    import Viewport from '@/Pages/Apps/PagesAdmin/Pages/Editor/Partials/Viewport.vue'
    import AddElementButton from '@/Pages/Apps/PagesAdmin/Pages/Editor/Partials/AddElementButton.vue'
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
    const prefetchedData = ref({})


    
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

        .navigator
            grid-area: navigator

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
                gap: 1rem
                border-bottom: 1px solid var(--color-border)

                &.no-padding
                    padding: 0

                &.no-border
                    border-bottom: none

                &.horizontal
                    flex-direction: row
                    align-items: center
                    gap: 0

                &.grid
                    display: grid
                    grid-template-columns: repeat(auto-fill, minmax(8rem, 1fr))
                    gap: 1rem
                    padding: 1rem

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
</style>