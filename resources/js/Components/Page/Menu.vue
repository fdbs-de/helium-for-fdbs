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
    import { ref } from 'vue'

    const menu = ref(null)

    menu.value = [
        { label: 'Home', href: route('home'), icon: null, children: []},
        { label: 'Philosophie', href: route('philosophie'), icon: null, children: []},
        {
            label: 'Produkte & Services',
            href: route('produkte-und-services'),
            icon: null,
            children: [
                { label: 'Foodservice', href: route('foodservice'), icon: null, children: []},
                { label: 'Unsere Marken', href: route('unsere-marken'), icon: null, children: []},
                { label: 'Fachberatung Käse & Salate', href: route('fachberatung-kaese-und-salate'), icon: null, children: []},
                { label: 'Marketing & Kommunikation', href: route('marketing-und-kommunikation'), icon: null, children: []},
                { label: 'Technischer Kundendienst', href: route('technischer-kundendienst'), icon: null, children: []},
                { label: 'Seminare', href: route('seminare'), icon: null, children: []},
            ],
        },
        { label: 'Karriere', href: route('karriere'), icon: null, children: []},
        { label: 'Kontakt', href: route('kontakt'), icon: null, children: []},
    ]
</script>

<style lang="sass">
    .wrapper
        nav
            display: flex
            gap: var(--su)

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

                            &:hover
                                background: var(--color-background-soft)

                    &:hover > ul
                        opacity: 1
                        pointer-events: all
                        transform: translate(-50%, 0)

</style>