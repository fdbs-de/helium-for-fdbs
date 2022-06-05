<template>
    <div class="wrapper">
        <nav>
            <MenuBuilder :items="menu" />
        </nav>
    </div>
</template>

<script setup>
    import { Link } from '@inertiajs/inertia-vue3'
    import MenuBuilder from '@/Components/Page/Menu/MenuBuilder.vue'
    import { mainmenu } from '@/menus'
    import { ref } from 'vue'

    const menu = ref(null)

    menu.value = mainmenu
</script>

<style lang="sass">
    .wrapper
        nav
            display: flex
            gap: calc(var(--su) * 2)

            > ul
                display: contents
                list-style: none

                > li
                    display: flex
                    align-items: center
                    position: relative

                    > a
                        font-weight: 500
                        color: var(--color-text)

                        &:hover,
                        &:focus
                            color: var(--color-heading)

                        &.active
                            color: var(--color-primary)

                    > ul
                        position: absolute
                        top: 100%
                        left: 50%
                        min-width: 260px
                        display: flex
                        flex-direction: column
                        padding: var(--su) 0
                        border-radius: calc(var(--su) * .5)
                        background: var(--color-background)
                        list-style: none
                        box-shadow: var(--shadow-elevation-low)
                        transition: all 150ms ease-out
                        opacity: 0
                        pointer-events: none
                        transform: translate(-50%, -10px)

                        > li > a
                            display: flex
                            align-items: center
                            padding: 0 var(--su)
                            height: 3rem
                            border-bottom: 1px solid var(--color-border)
                            color: var(--color-text)

                            &:hover,
                            &:focus
                                color: var(--color-heading)
                                background: var(--color-background-soft)

                            &.active
                                color: var(--color-primary)

                    &:hover > ul
                        opacity: 1
                        pointer-events: all
                        transform: translate(-50%, 0)

</style>