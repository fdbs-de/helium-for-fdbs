<template>
    <Head title="Seiten Editor" />

    <div class="main-layout">
        <div class="tab-layout">
            <IconButton :is="Link" :href="route('admin.pages.pages')" icon="arrow_back" @click="exitFullscreen()"/>

            <button class="tab" v-for="tab in editor.tabs" :key="tab.id" :class="{'active': tab.active}" @click="editor.selectTab(tab.id)">
                <div class="icon">{{ tab.icon }}</div>
                <div class="title">
                    <span v-if="tab.title">{{ tab.title }}</span>
                    <i v-else>Unbenannt</i>
                </div>
                <button class="indicator" @click.stop="editor.closeTab(tab.id)">
                    <div class="icon">close</div>
                </button>
                <div class="corner start"></div>
                <div class="corner end"></div>
            </button>

            <IconButton icon="add" @click="editor.openBlankTab()" v-show="!editor.hasBlankTab"/>

            <div class="spacer"></div>

            <IconButton class="small" :icon="isFullscreen ? 'fullscreen_exit' : 'fullscreen'" v-tooltip="'Vollbild (Strg+Shift+Alt+F)'" @click="toggleFullscreen()"/>
            <!-- <IconButton class="small" icon="more_vert" /> -->
        </div>



        <div class="new-tab-layout" v-if="editor.tab && ['new-tab'].includes(editor.tab.type)">
            <div class="new-button-wrapper">
                <div class="limiter text-limiter">
                    <button class="new-button page" @click="editor.tab.useAs('page-editor', {})">
                        <div class="icon">add</div>
                        <span class="text">Neue Seite</span>
                        <span class="subtext">Inhaltsseiten</span>
                    </button>
                    <button class="new-button component" @click="editor.tab.useAs('component-editor', {})">
                        <div class="icon">add</div>
                        <span class="text">Neue Komponente</span>
                        <span class="subtext">Komponenten und Layouts</span>
                    </button>
                </div>
            </div>
            <div class="pages-wrapper">
                <div class="limiter text-limiter">
                </div>
            </div>
        </div>



        <div class="page-editor-layout" v-if="editor.tab && ['page-editor', 'component-editor'].includes(editor.tab.type)">
            <div class="tool-bar">
                <div class="start">
                    <mui-button class="with-label" variant="contained" icon-left="add" label="Neu" v-show="!editor.tab.ui.newElementPanel" @click="editor.tab.toggleNewElementPanel()"/>
                    <mui-button class="with-label" variant="contained" icon-left="close" label="Schließen" v-show="editor.tab.ui.newElementPanel" @click="editor.tab.toggleNewElementPanel()"/>
                    <div class="spacer"></div>
                    <IconButton icon="undo" v-tooltip.bottom="'Rückgangig (Strg+Z)'" :disabled="editor.tab.history.length <= 0" />
                    <IconButton icon="redo" v-tooltip.bottom="'Wiederherstellen (Strg+Y)'" :disabled="editor.tab.history.length <= 0" />
                    <IconButton icon="history" v-tooltip.bottom="'Bearbeitungsverlauf'" :disabled="editor.tab.history.length <= 0" />
                </div>
                <div class="center">
                    <div class="breakpoint-selector">
                        <IconButton
                            v-for="(breakpoint, index) in editor.breakpoints"
                            :key="breakpoint.id"
                            :icon="breakpoint.icon"
                            :class="{'active': index == editor.tab.selected.breakpoint}"
                            v-tooltip.bottom="{content: breakpoint.tooltip, html: true}"
                            @click="editor.selectBreakpoint(index)"
                        />
                    </div>
                </div>
                <div class="end">
                    <IconButton icon="settings" v-tooltip.bottom="'Seiten Einstellungen'"/>
                    <IconButton icon="data_object" v-tooltip.bottom="'Stylesheets'"/>
                    <IconButton icon="upload" v-tooltip.bottom="'Medien Manager'" @click="$refs.picker.open()"/>
                    <IconButton icon="visibility" v-tooltip.bottom="'Vorschau'"/>
                    <div class="spacer"></div>
                    <mui-button class="with-label" variant="contained" label="Speichern" v-tooltip.bottom="'Speichern (Strg+S)'"/>
                </div>
            </div>

            <div class="navigator" v-show="editor.tab.ui.newElementPanel">
                <div class="grid">
                    <button class="item-button" @click="addElement('layout')">
                        <div class="icon">align_horizontal_left</div>
                        Layout
                    </button>

                    <button class="item-button" @click="addElement('text')">
                        <div class="icon">title</div>
                        Text
                    </button>

                    <button class="item-button" @click="addElement('link')">
                        <div class="icon">link</div>
                        Link
                    </button>

                    <button class="item-button" @click="addElement('image')">
                        <div class="icon">landscape</div>
                        Image
                    </button>

                    <button class="item-button" @click="addElement('video')">
                        <div class="icon">movie</div>
                        Video
                    </button>

                    <button class="item-button" @click="addElement('iframe')">
                        <div class="icon">Map</div>
                        Iframe
                    </button>

                    <button class="item-button" @click="addElement('button')">
                        <div class="icon">mouse</div>
                        Button
                    </button>

                    <button class="item-button" @click="addElement('code')">
                        <div class="icon">data_object</div>
                        Code
                    </button>

                    <button class="item-button" @click="addElement('slot')">
                        <div class="icon">variables</div>
                        Content Slot
                    </button>
                </div>
            </div>

            <div class="navigator" v-show="!editor.tab.ui.newElementPanel">
                <NavigatorElement
                    v-for="element in editor.tab.elements"
                    :key="element.elementId"
                    :element="element"
                    :selection="editor.tab.selected.elements"
                    @select:set="editor.tab.setElementSelection($event)"
                    @select:toggle="editor.tab.toggleElementSelection($event)"
                />
            </div>

            <div class="viewport-wrapper">
                <iframe class="viewport" :style="`max-width: ${editor.breakpoint.width}px;`"></iframe>
            </div>

            <div class="inspector">
                <div class="input-group horizontal slim">
                    <div class="spacer"></div>
                    <IconButton icon="content_copy" />
                    <IconButton icon="disabled_visible" />
                    <IconButton icon="more_vert" />
                    <IconButton class="error" icon="delete" @click="editor.tab.removeElement(editor.tab.selected.elements[0])"/>
                </div>

                <div class="input-group">
                    <mui-input
                        class="default-text-input"
                        icon-left="label"
                        v-if="editor.tab.inspectorFixtures.name"
                        :placeholder="editor.tab.inspectorFixtures.name.name"
                        :modelValue="editor.tab.inspectorFixtures.name.value"
                        @update:modelValue="editor.tab.setElementsValue('name', $event)"
                    />
                </div>
                
                <div class="input-group" v-if="editor.tab.inspectorFixtures.wrapper || editor.tab.inspectorFixtures.id || editor.tab.inspectorFixtures.classes">
                    <select class="default-select" v-if="editor.tab.inspectorFixtures.wrapper">
                        <option :value="null" disabled>{{ editor.tab.inspectorFixtures.wrapper.name }}</option>
                        <option v-for="option in editor.tab.inspectorFixtures.wrapper.options" :value="option">{{ option }}</option>
                    </select>

                    <mui-input
                        class="default-text-input"
                        v-if="editor.tab.inspectorFixtures.id"
                        :placeholder="editor.tab.inspectorFixtures.id.name"
                        :modelValue="editor.tab.inspectorFixtures.id.value"
                        @update:modelValue="editor.tab.setElementsValue('id', $event)"
                    />

                    <mui-input
                        class="default-text-area"
                        type="textarea"
                        v-if="editor.tab.inspectorFixtures.classes"
                        :label="editor.tab.inspectorFixtures.classes.name"
                        :modelValue="editor.tab.inspectorFixtures.classes.value"
                        @update:modelValue="editor.tab.setElementsValue('classes', $event)"
                    />
                </div>

                <div class="input-group">
                    <mui-input
                        class="default-text-input"
                        v-if="editor.tab.inspectorFixtures.href"
                        :placeholder="editor.tab.inspectorFixtures.href.name"
                        :modelValue="editor.tab.inspectorFixtures.href.value"
                        @update:modelValue="editor.tab.setElementsValue('styles', $event)"
                    />

                    <select class="default-select" v-if="editor.tab.inspectorFixtures.target">
                        <option :value="null" disabled>{{ editor.tab.inspectorFixtures.target.name }}</option>
                        <option v-for="option in editor.tab.inspectorFixtures.target.options" :value="option">{{ option }}</option>
                    </select>

                    <mui-input
                        class="default-text-input"
                        v-if="editor.tab.inspectorFixtures.src"
                        :placeholder="editor.tab.inspectorFixtures.src.name"
                        :modelValue="editor.tab.inspectorFixtures.src.value"
                        @update:modelValue="editor.tab.setElementsValue('src', $event)">
                        <template #right>
                            <button type="button" class="input-button" @click="$refs.picker.open((file) => { editor.tab.inspectorFixtures.src.value = file })">folder_open</button>
                        </template>
                    </mui-input>

                    <mui-input
                        class="default-text-input"
                        v-if="editor.tab.inspectorFixtures.alt"
                        :placeholder="editor.tab.inspectorFixtures.alt.name"
                        :modelValue="editor.tab.inspectorFixtures.alt.value"
                        @update:modelValue="editor.tab.setElementsValue('alt', $event)"
                    />
                </div>

                <!-- <div class="input-group slim">
                    {{ editor.tab.inspectorFixtures }}
                </div> -->
            </div>
        </div>
    </div>

    <Picker ref="picker" />
</template>

<script setup>
    import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { ref, onMounted, computed } from 'vue'
    import hotkeys from 'hotkeys-js'
    import { Inertia } from '@inertiajs/inertia'
    import Editor from '@/Classes/Apps/Pages/Editor.js'
    import {
        LayoutElement,
        TextElement,
        LinkElement,
        ImageElement,
        VideoElement,
        IFrameElement,
        ButtonElement,
        CodeElement,
        SlotElement
    } from '@/Classes/Apps/Pages/BaseElements.js'

    import IconButton from '@/Components/Apps/Pages/IconButton.vue'
    import NavigatorElement from '@/Components/Apps/Pages/NavigatorElement.vue'
    import Picker from '@/Components/Form/MediaLibrary/Picker.vue'
    import TextEditor from '@/Components/Form/TextEditor.vue'
    import Popup from '@/Components/Form/Popup.vue'

    const editor = ref(new Editor({
        openNewOnLaunch: true,
        openNewOnLastClose: true
    }))



    const content = ref('')



    // START: Keyboard Shortcuts
    hotkeys('ctrl+s', (event, handler) => { event.preventDefault(); console.log('SAVE') })
    hotkeys('ctrl+shift+s', (event, handler) => { event.preventDefault(); console.log('SAVE AS') })
    hotkeys('ctrl+alt+n', (event, handler) => { event.preventDefault(); editor.value.openBlankTab() })
    hotkeys('ctrl+alt+w', (event, handler) => { event.preventDefault(); editor.value.closeTab(editor.value.tab.id) })
    hotkeys('ctrl+alt+right', (event, handler) => { event.preventDefault(); editor.value.selectNextTab() })
    hotkeys('ctrl+alt+left', (event, handler) => { event.preventDefault(); editor.value.selectPreviousTab() })
    hotkeys('ctrl+alt+shift+f, f11', (event, handler) => { event.preventDefault(); toggleFullscreen() })



    // New Tab specific
    hotkeys('ctrl+alt+p', (event, handler) => {
        event.preventDefault()
        
        if (editor.value.tab.type !== 'new-tab') return
        
        editor.value.tab.useAs('page-editor', {})
    })

    hotkeys('ctrl+alt+c', (event, handler) => {
        event.preventDefault()
        
        if (editor.value.tab.type !== 'new-tab') return
        
        editor.value.tab.useAs('component-editor', {})
    })



    // Page Editor specific
    hotkeys('alt+1', (event, handler) => { event.preventDefault(); editor.value.selectBreakpoint(0) })
    hotkeys('alt+2', (event, handler) => { event.preventDefault(); editor.value.selectBreakpoint(1) })
    hotkeys('alt+3', (event, handler) => { event.preventDefault(); editor.value.selectBreakpoint(2) })
    hotkeys('alt+4', (event, handler) => { event.preventDefault(); editor.value.selectBreakpoint(3) })
    hotkeys('alt+5', (event, handler) => { event.preventDefault(); editor.value.selectBreakpoint(4) })
    hotkeys('alt+6', (event, handler) => { event.preventDefault(); editor.value.selectBreakpoint(5) })
    hotkeys('alt+7', (event, handler) => { event.preventDefault(); editor.value.selectBreakpoint(6) })
    hotkeys('alt+8', (event, handler) => { event.preventDefault(); editor.value.selectBreakpoint(7) })
    hotkeys('alt+9', (event, handler) => { event.preventDefault(); editor.value.selectBreakpoint(8) })
    hotkeys('alt+0', (event, handler) => { event.preventDefault(); editor.value.selectBreakpoint(9) })
    hotkeys('alt+enter', (event, handler) => { event.preventDefault(); addElement('layout') })
    hotkeys('alt+t', (event, handler) => { event.preventDefault(); addElement('text') })
    hotkeys('alt+l', (event, handler) => { event.preventDefault(); addElement('link') })
    hotkeys('alt+i', (event, handler) => { event.preventDefault(); addElement('image') })
    hotkeys('alt+v', (event, handler) => { event.preventDefault(); addElement('video') })
    hotkeys('alt+b', (event, handler) => { event.preventDefault(); addElement('button') })



    hotkeys('ctrl+c', (event, handler) => { event.preventDefault(); console.log('COPY') })
    hotkeys('ctrl+d', (event, handler) => { event.preventDefault(); console.log('DUPLICATE') })
    hotkeys('ctrl+x', (event, handler) => { event.preventDefault(); console.log('CUT') })
    hotkeys('ctrl+v', (event, handler) => { event.preventDefault(); console.log('PASTE') })

    hotkeys('ctrl+z', (event, handler) => { event.preventDefault(); console.log('UNDO') })
    hotkeys('ctrl+y', (event, handler) => { event.preventDefault(); console.log('REDO') })
    hotkeys('ctrl+shift+z', (event, handler) => { event.preventDefault(); console.log('REDO') })

    hotkeys('shift+n', (event, handler) => { event.preventDefault(); editor.value.tab.toggleNewElementPanel(); })
    hotkeys('delete, backspace', (event, handler) => { event.preventDefault(); editor.value.tab.removeElement(editor.value.tab.selected.elements[0]) })
    // END: Keyboard Shortcuts



    // START: Methods
    const addElement = (name) => {
        let element = null

        switch (name)
        {
            case 'layout': element = new LayoutElement({name: 'Layout'}); break
            case 'text': element = new TextElement({name: 'Text'}); break
            case 'link': element = new LinkElement({name: 'Link'}); break
            case 'image': element = new ImageElement({name: 'Image'}); break
            case 'video': element = new VideoElement({name: 'Video'}); break
            case 'iframe': element = new IFrameElement({name: 'IFrame'}); break
            case 'button': element = new ButtonElement({name: 'Button'}); break
            case 'code': element = new CodeElement({name: 'Code'}); break
            case 'slot': element = new SlotElement({name: 'Content Slot'}); break
            default: return null;
        }

        editor.value.tab.addElement(element, true)
        editor.value.tab.ui.newElementPanel = false
    }
    // END: Methods



    // START: Fullscreen
    const isFullscreen = ref(false)
    const fullscreenAvailable = ref(false)

    onMounted(() => {
        isFullscreen.value = !!document.fullscreenElement
        fullscreenAvailable.value = document.fullscreenEnabled
    })

    window.addEventListener('fullscreenchange', () => {
        isFullscreen.value = !!document.fullscreenElement
    })

    const toggleFullscreen = () => {
        isFullscreen.value ? exitFullscreen() : enterFullscreen()
    }

    const enterFullscreen = () => {
        document.documentElement.requestFullscreen()
    }

    const exitFullscreen = () => {
        document.exitFullscreen()
    }
    // END: Fullscreen
</script>

<style lang="sass">
    html
        background: var(--color-background-soft)
        overflow: hidden

        #app
            height: 100%
            width: 100%
</style>

<style lang="sass" scoped>
.main-layout
    display: flex
    flex-direction: column
    height: 100%
    width: 100%
    
    --color-background-dark: #393F3F
    --color-background-dark-soft: #2A2F2F
    --color-text-on-background-dark: rgb(255, 255, 255, .7)
    --color-heading-on-background-dark: rgb(255, 255, 255, 1)

    .tab-layout
        width: 100%
        height: 2.25rem
        display: flex
        background: var(--color-background-dark-soft)
        color: var(--color-heading-on-background-dark)
        padding-right: .5rem

        > button:not(.tab),
        > a:not(.tab)
            border-radius: var(--radius-s)
            height: 100%
            width: 3.5rem

        > button.small
            width: auto
            aspect-ratio: 1

        .tab
            flex: 1
            max-width: 20rem
            display: flex
            align-items: center
            height: 100%
            padding: 0
            margin: 0
            font-family: inherit
            font-size: inherit
            text-align: left
            position: relative
            color: var(--color-text-on-background-dark)
            background: transparent
            border: none
            border-radius: var(--radius-m)
            user-select: none

            &:hover
                background: #ffffff10
                .indicator
                    .icon
                        transform: scale(1) !important
                        opacity: 1 !important

            &.active
                z-index: 1
                border-radius: var(--radius-m) var(--radius-m) 0 0
                color: var(--color-heading-on-background-dark)
                background: var(--color-background-dark)

                .corner
                    display: block

            .corner
                display: none
                height: var(--radius-m)
                width: var(--radius-m)
                position: absolute
                bottom: 0
                overflow: hidden
                pointer-events: none

                &.start
                    left: 0
                    transform: translateX(-100%)
                &.end
                    right: 0
                    transform: translateX(100%)

                &.start::after
                    border-bottom-right-radius: 100%

                &.end::after
                    border-bottom-left-radius: 100%
                
                &::after
                    content: ''
                    height: 100%
                    width: 100%
                    position: absolute
                    top: 0
                    left: 0
                    box-shadow: 0 0 0 500px var(--color-background-dark)

            > .icon
                font-family: var(--font-icon)
                font-size: 1.25rem
                width: 3.5rem
                display: flex
                align-items: center
                justify-content: center
                color: var(--color-text-on-background-dark)

            > .title
                flex: 1
                font-size: .9rem
                letter-spacing: .05rem
                white-space: nowrap
                overflow: hidden
                text-overflow: ellipsis

            .indicator
                display: flex
                padding: 0
                margin: 0
                font-family: inherit
                font-size: inherit
                color: inherit
                background: transparent
                border: none

                .icon
                    font-family: var(--font-icon)
                    font-size: 1rem
                    height: 2.25rem
                    width: 2.25rem
                    border-radius: 50%
                    display: flex
                    align-items: center
                    justify-content: center
                    transition: all 80ms ease-in-out
                    transform: scale(0)
                    opacity: 0

    .new-tab-layout
        flex: 1
        background: var(--color-background-dark-soft)
        display: flex
        flex-direction: column

        .new-button-wrapper
            width: 100%
            padding-block: 8rem 4rem
            background: var(--color-background-dark)
            user-select: none

            .limiter
                display: flex
                gap: 2rem

            .new-button
                flex: 1
                aspect-ratio: 16/9
                border-radius: var(--radius-l)
                display: flex
                flex-direction: column
                align-items: center
                justify-content: center
                color: var(--color-background)
                gap: .25rem
                margin: 0
                padding: 0
                border: none
                cursor: pointer
                transition: all 80ms ease-in-out

                &:hover
                    box-shadow: var(--shadow-elevation-high)

                &.page
                    background: var(--color-app-pages-on-dark)

                &.component
                    background: #ff6348

                .icon
                    font-family: var(--font-icon)
                    font-size: 2.5rem
                    opacity: .7
                    line-height: 1
                    margin-bottom: 1rem

                .text
                    font-size: 1.1rem
                    font-weight: 600
                    font-family: var(--font-heading)

                .subtext
                    font-weight: 400
                    font-family: var(--font-text)
                    opacity: .8

    .page-editor-layout
        flex: 1
        display: grid
        grid-template-columns: 22rem 1fr 22rem
        grid-template-rows: 4rem 1fr
        grid-template-areas: "tool-bar tool-bar tool-bar" "navigator viewport inspector"

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

            .grid
                display: grid
                grid-template-columns: 1fr 1fr
                gap: .5rem
                padding: 0 1rem

                .item-button
                    margin: 0
                    padding: 1rem 0
                    border: 1px solid var(--color-background-soft)
                    background: var(--color-background)
                    display: flex
                    flex-direction: column
                    gap: .5rem
                    align-items: center
                    justify-content: center
                    cursor: pointer
                    transition: all 80ms ease-in-out
                    font-family: var(--font-heading)
                    font-size: .8rem
                    border-radius: var(--radius-m)
                    color: inherit
                    user-select: none

                    &:hover
                        background: var(--color-background-soft)

                    .icon
                        font-size: 1.75rem
                        font-family: var(--font-icon)
                        opacity: .7

        .viewport-wrapper
            grid-area: viewport
            display: flex
            flex-direction: column
            align-items: center
            padding: 1rem

            iframe.viewport
                width: 100%
                min-height: 20rem
                background: white
                border: 0
                box-shadow: var(--shadow-elevation-low)

        .inspector
            grid-area: inspector
            background: var(--color-background)
            box-shadow: var(--shadow-elevation-low)
            color: var(--color-heading)
            overflow-y: auto

            .input-group
                padding: 1rem
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

                .default-text-input
                    height: 2.5rem

                .default-select
                    height: 2.5rem

                .default-text-area
                    --base-height: 7.5rem
</style>