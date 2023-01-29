<template>
    <Head title="Seiten Editor" />

    <div class="main-layout">
        <div class="tab-layout">
            <IconButton icon="arrow_back" />

            <button class="tab active">
                <div class="icon">language</div>
                <div class="title">Startseite</div>
                <button class="indicator" @click.stop>
                    <div class="icon">close</div>
                </button>
                <div class="corner start"></div>
                <div class="corner end"></div>
            </button>

            <button class="tab">
                <div class="icon">language</div>
                <div class="title">Datenschutz</div>
                <button class="indicator" @click.stop>
                    <div class="icon">close</div>
                </button>
                <div class="corner start"></div>
                <div class="corner end"></div>
            </button>

            <div class="spacer"></div>

            <IconButton icon="fullscreen" />
        </div>
        <div class="page-layout">
            <div class="tool-bar">
                <div class="start">
                    <mui-button class="with-label" variant="contained" icon-left="add" label="Neu"/>
                    <div class="spacer"></div>
                    <IconButton icon="undo" />
                    <IconButton icon="redo" disabled/>
                    <IconButton icon="history" />
                </div>
                <div class="center">
                    <div class="breakpoint-selector">
                        <IconButton icon="desktop_windows" class="active"/>
                        <IconButton icon="computer" />
                        <IconButton icon="stay_current_landscape" />
                        <IconButton icon="stay_current_portrait" />
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
            <div class="navigator"></div>
            <div class="viewport-wrapper"></div>
            <div class="inspector"></div>
        </div>
    </div>
</template>

<script setup>
    import { Head, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { ref, computed } from 'vue'
    import { Inertia } from '@inertiajs/inertia'

    import IconButton from '@/Components/Apps/Pages/IconButton.vue'
    import Popup from '@/Components/Form/Popup.vue'
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

        > button:not(.tab)
            border-radius: 0
            height: 100%
            width: 3.5rem

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
            border-radius: var(--radius-m) var(--radius-m) 0 0

            &.active
                z-index: 1
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

    .page-layout
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

        .viewport-wrapper
            grid-area: viewport
            padding: 1rem

        .inspector
            grid-area: inspector
            background: var(--color-background)
            box-shadow: var(--shadow-elevation-low)
</style>