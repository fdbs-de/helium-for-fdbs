<template>
    <div class="menu-wrapper">
        <nav class="desktop-menu">
            <ul>
                <MenuItem v-for="(item, i) in menu" :key="i" :href="item.href" :title="item.title" :children="item.children || []" />
            </ul>
        </nav>
    
        <button class="mobile-menu-toggle" type="button" title="Open navigation" @click="isOpen = true">menu</button>
    
        <Teleport to="body">
            <div class="mobile-menu" :class="{'is-open': isOpen}">
                <div class="background" @click="isOpen = false"></div>
                <nav class="menu">
                    <div class="flex v-center">
                        <div class="spacer"></div>
                        <button class="mobile-menu-toggle" type="button" title="Close navigation" @click="isOpen = false">close</button>
                    </div>
                    <div class="menu-scroller">
                        <ul>
                            <MenuItem v-for="(item, i) in menu" :key="i" :href="item.href" :title="item.title" :children="item.children || []" />
                        </ul>
                    </div>
                </nav>
            </div>
        </Teleport>
    </div>
</template>

<script setup>
    import { ref, watch } from 'vue'
    import { Inertia } from '@inertiajs/inertia'
    
    import MenuItem from '@/Pages/Apps/Pages/Partials/Menu/MenuItem.vue'



    defineProps({
        menu: Array,
    })

    Inertia.on('start', (event) => {
        document.documentElement.style.overflow = 'initial'
    })



    const isOpen = ref(false)

    watch(isOpen, () => {
        document.documentElement.style.overflow = isOpen.value ? 'hidden' : 'initial'
    })
</script>

<style lang="sass">
    .mobile-menu-toggle
        height: 2.5rem
        width: 2.5rem
        border-radius: 3rem
        font-size: 1.3rem
        font-family: var(--font-icon)
        color: var(--color-on-primary)
        background: var(--color-primary)
        border: none
        padding: 0
        display: none
        cursor: pointer
        transition: all 100ms ease-out

        &:focus,
        &:hover
            background: var(--color-background-soft)
            color: var(--color-primary)

    .mobile-menu
        position: fixed
        top: 0
        bottom: 0
        left: 0
        right: 0
        z-index: 1000
        pointer-events: none
        display: none
        overflow: hidden

        &.is-open
            pointer-events: all

            .background
                opacity: 1

            .menu
                transform: translateX(0)

        .background
            position: absolute
            top: 0
            left: 0
            width: 100%
            height: 100%
            background-color: rgba(0, 0, 0, .8)
            opacity: 0
            transition: opacity 300ms ease-in-out

        .menu
            position: absolute
            top: 0
            right: 0
            height: 100%
            width: calc(100% - 3rem)
            max-width: 400px
            display: flex
            flex-direction: column
            background: var(--color-background)
            transform: translateX(100%)
            transition: transform 300ms ease-in-out

            .flex
                height: calc(var(--height-header) + 2px)
                padding-inline: 1rem
                border-bottom: 2px solid rgba(0,0,0,.1)

            .menu-scroller
                overflow-y: auto
                overflow-x: hidden
                flex: 1
                padding-block: 1rem 100px

                ul
                    display: flex
                    flex-direction: column
                    list-style: none
                    padding: 0
                    margin: 0

                    li
                        > a
                            padding: .5rem 1.5rem
                            display: flex
                            color: var(--color-text-soft)

                            &:hover,
                            &:focus
                                background: var(--color-background-soft)
                                color: var(--color-text)

                        &.active > a
                            color: var(--color-primary) !important

                    li > ul
                        padding-left: 1.5rem

    .desktop-menu
        display: flex
        gap: 2rem

        > ul
            display: contents
            list-style: none

            > li
                display: flex
                align-items: center
                position: relative
                color: var(--color-text)

                &.has-dropdown::after
                    content: "arrow_drop_down"
                    position: absolute
                    top: 100%
                    left: 50%
                    font-size: 1.5rem
                    transform: translate(-50%, -50%)
                    font-family: var(--font-icon)
                    user-select: none
                    pointer-events: none

                &:hover,
                &:focus
                    color: var(--color-primary)

                &:hover
                    > ul
                        opacity: 1
                        pointer-events: all
                        transform: translate(-50%, 0)

                > a:focus
                    ~ ul
                        opacity: 1
                        pointer-events: all
                        transform: translate(-50%, 0)

                &.active
                    color: var(--color-primary)

                > a
                    font-weight: 500
                    color: inherit
                    text-align: center

                ul
                    position: absolute
                    top: 100%
                    left: 50%
                    z-index: 1
                    min-width: 260px
                    display: flex
                    flex-direction: column
                    padding: 1rem 0
                    border-radius: var(--radius-m)
                    border: 1px solid var(--color-background-soft)
                    background: var(--color-background)
                    list-style: none
                    box-shadow: var(--shadow-elevation-low)
                    transition: all 150ms ease-out
                    opacity: 0
                    pointer-events: none
                    transform: translate(-50%, -10px)

                    > li
                        width: 100%
                        color: var(--color-text-soft)
                        position: relative

                        &.has-dropdown::after
                            content: "arrow_right"
                            position: absolute
                            top: 50%
                            right: 5px
                            font-size: 1.5rem
                            transform: translate(0, -50%)
                            font-family: var(--font-icon)
                            user-select: none
                            pointer-events: none

                        > a
                            display: flex
                            align-items: center
                            padding: 0 1rem
                            height: 3rem
                            color: inherit

                        &:hover,
                        &:focus
                            color: var(--color-text)

                            > a
                                background: var(--color-background-soft)

                            > ul
                                opacity: 1
                                pointer-events: all
                                transform: translate(0, 0)

                        &.active
                            color: var(--color-primary)

                        > ul
                            top: calc(-1rem - 1px)
                            left: 100%
                            transform: translate(0, -10px)
    

    @media only screen and (max-width: 1000px)
        .mobile-menu
            display: block

        .mobile-menu-toggle
            display: block

        .desktop-menu
            display: none
</style>