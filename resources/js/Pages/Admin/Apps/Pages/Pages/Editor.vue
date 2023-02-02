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

            <IconButton class="small" :icon="isFullscreen ? 'fullscreen_exit' : 'fullscreen'" @click="toggleFullscreen()"/>
            <IconButton class="small" icon="more_vert" />
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
                        <span class="text">Neues Komponent</span>
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
                    <mui-button class="with-label" variant="contained" icon-left="add" label="Neu" @click="newElementPanel = true"/>
                    <div class="spacer"></div>
                    <IconButton icon="undo" :disabled="editor.tab.history.length <= 0" />
                    <IconButton icon="redo" :disabled="editor.tab.history.length <= 0" />
                    <IconButton icon="history" :disabled="editor.tab.history.length <= 0" />
                </div>
                <div class="center">
                    <div class="breakpoint-selector">
                        <IconButton
                            v-for="breakpoint in editor.breakpoints"
                            :key="breakpoint.id"
                            :icon="breakpoint.icon"
                            :class="{'active': breakpoint.id == editor.tab.selected.breakpoint}"
                            @click="editor.tab.selectBreakpoint(breakpoint.id)"
                        />
                    </div>
                </div>
                <div class="end">
                    <IconButton icon="settings" />
                    <IconButton icon="data_object" />
                    <IconButton icon="upload" />
                    <IconButton icon="visibility" />
                    <div class="spacer"></div>
                    <mui-button class="with-label" variant="contained" label="Speichern" />
                </div>
            </div>

            <div class="navigator grid" v-if="newElementPanel">
                <mui-button variant="contained" icon-left="close" label="Schließen" @click="newElementPanel = false"/>
                <mui-button variant="contained" icon-left="add" label="Blank Element" @click="editor.tab.addElement(new BlankElement({name: 'Blank Element'}))"/>
                <mui-button variant="contained" icon-left="add" label="Link Element" @click="editor.tab.addElement(new LinkElement({name: 'Link Element'}))"/>
                <mui-button variant="contained" icon-left="add" label="Image Element" @click="editor.tab.addElement(new ImageElement({name: 'Image Element'}))"/>
            </div>

            <div class="navigator" v-else>
                <NavigatorElement
                    v-for="element in editor.tab.elements"
                    :key="element.elementId"
                    :element="element"
                    :selection="editor.tab.selected.elements"
                    @select="editor.tab.setElementSelection($event)"
                />
            </div>

            <div class="viewport-wrapper">
            </div>

            <div class="inspector">
                <div class="input-group horizontal slim">
                    <span class="title">Inspect Element</span>
                    <div class="spacer"></div>
                    <IconButton icon="content_copy" />
                    <IconButton icon="disabled_visible" />
                    <IconButton icon="more_vert" />
                    <IconButton class="error" icon="delete" />
                </div>
                <div class="input-group">
                    <mui-input placeholder="Titel" v-model="editor.tab.title"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { ref, onMounted } from 'vue'
    import { Inertia } from '@inertiajs/inertia'
    import Editor from '@/Classes/Apps/Pages/Editor.js'
    import { BlankElement, LinkElement, ImageElement} from '@/Classes/Apps/Pages/BaseElements.js'

    import IconButton from '@/Components/Apps/Pages/IconButton.vue'
    import NavigatorElement from '@/Components/Apps/Pages/NavigatorElement.vue'
    import Popup from '@/Components/Form/Popup.vue'

    const editor = ref(new Editor({
        openNewOnLaunch: true,
        openNewOnLastClose: true
    }))



    // START: UI State
    const newElementPanel = ref(false)
    // END: UI State



    // START: Fullscreen
    const isFullscreen = ref(false)
    const fullscreenAvailable = ref(false)

    onMounted(() => {
        isFullscreen.value = !!document.fullscreenElement
        fullscreenAvailable.value = document.fullscreenEnabled
    })

    window.addEventListener('fullscreenchange', () => {
        isFullscreen.value = !!document.fullscreenElement
        document.documentElement.style.overflowY = this.isFullscreen ? 'hidden' : 'scroll'
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
            padding: .5rem

        .viewport-wrapper
            grid-area: viewport
            padding: 1rem

        .inspector
            grid-area: inspector
            background: var(--color-background)
            box-shadow: var(--shadow-elevation-low)
            color: var(--color-heading)

            .input-group
                padding: 1.5rem 1rem
                display: flex
                flex-direction: column
                border-bottom: 1px solid var(--color-border)

                &.slim
                    padding: 1rem

                &.horizontal
                    flex-direction: row
                    align-items: center

                .title
                    font-size: .8rem
                    font-weight: 600
                    letter-spacing: .05rem
                    text-transform: uppercase
                    color: var(--color-text)

                .spacer
                    flex: 1

                > button.error
                    color: var(--color-error)
</style>