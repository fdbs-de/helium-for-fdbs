<template>
    <div class="layout">
        <div class="menu" :class="{'open': isOpen}">
            <div class="apps-bar">
                <Link class="logo" :href="route('wiki')">
                    <img src="/images/branding/icon_dashboard.svg" alt="FDBS Logo">
                </Link>

                <div class="group">
                    <Link class="app" :href="route('wiki', {category: 'all'})" v-tooltip.right="'Übersicht'" :class="{'active': is(['wiki', 'wiki.entry']) && category == 'all'}">dashboard</Link>
                </div>

                <div class="divider"></div>

                <div class="group">
                    <Link class="app"
                        v-for="item in categories"
                        :key="item.id"
                        :href="route('wiki', {category: item.id})"
                        
                        v-tooltip.right="item.name"
                        :class="{'active': is('wiki') && category == item.id}">
                        {{item.icon}}
                    </Link>
                </div>

                <div class="spacer"></div>

                <div class="group">
                    <Link class="app" :href="route('dashboard.profile')" v-tooltip.right="'Profil'">account_circle</Link>
                </div>
            </div>

            <div class="menu-bar">
                <div class="top-bar">
                    <form @submit.prevent="search()">
                        <mui-input type="search" class="searchbar" icon-left="search" placeholder="Im Wiki Suchen" v-model="searchInput"/>
                    </form>
                </div>

                <div class="menu-group">
                    <Link class="menu-item" :href="route('wiki', {category, sort: 'all'})" :class="{'active': is('wiki') && sort === 'all'}">
                        <div class="icon" aria-hidden="true">bookmarks</div>
                        <div class="text">Alle Einträge</div>
                    </Link>

                    <Link class="menu-item" :href="route('wiki', {category, sort: 'recent'})" :class="{'active': is('wiki') && sort === 'recent'}">
                        <div class="icon" aria-hidden="true">update</div>
                        <div class="text">Neueste Einträge</div>
                    </Link>
                </div>

                <div class="divider"></div>
                
                <div class="menu-scroll-container">
                    <div class="menu-group">
                        <Link class="menu-entry" v-for="item in posts" :key="item.id" :href="route('wiki.entry', [item.category.slug, item.slug])">
                            <div class="text" v-tooltip.right="item.title">{{ item.title }}</div>
                        </Link>
                    </div>
                </div>
            </div>
        </div>



        <main class="content">
            <div id="hero-section" :class="{'has-image': !!image}">
                <div class="limiter">
                    <div class="hero-card" :style="'background-image: url('+(image || '')+')'">
                        <div class="hero-card-info-wrapper">
                            <Link class="back-button" v-if="backlink" :href="backlink" v-tooltip="backlinkText">arrow_back</Link>

                            <h1>{{ title }}</h1>

                            <button class="toggle-open" :class="{'open': isOpen}" :title="isOpen ? 'Menü ausklappen' : 'Menü einklappen'" @click="isOpen = !isOpen">
                                <svg class="svg-wrapper" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path class="hamburger-path" d="M5 9C5 9 17.5 9 19 9C20.5 9 22.5 7.5 21.5 6C20.5 4.5 18 6 17 7C16 8 7 17 7 17"/>
                                    <path class="hamburger-path" d="M5 15.0054C5 15.0054 17.5 15.0054 19 15.0054C20.5 15.0054 22.5 16.5054 21.5 18.0054C20.5 19.5054 18 18.0054 17 17.0054C16 16.0054 7 7.00542 7 7.00542"/>
                                </svg>
                            </button>
                        </div>

                        <Loader class="loader" v-show="loading" />
                    </div>
                </div>
            </div>
            
            <section id="content-section">
                <div class="limiter">
                    <slot />
        
                    <div class="fab" v-if="$slots.fab">
                        <slot name="fab" />
                    </div>
                </div>
            </section>
        </main>
    </div>
</template>

<script setup>
    import { Head, Link, usePage } from '@inertiajs/inertia-vue3'
    import { ref, computed } from 'vue'
    import { can, canAny } from '@/Utils/Permissions'

    import Loader from '@/Components/Form/Loader.vue'
    import Footer from '@/Components/Page/Footer.vue'
import { Inertia } from '@inertiajs/inertia'



    defineProps({
        categories: Array,
        posts: Array,

        title: String,
        image: String,
        backlink: [String, Object, Function],
        backlinkText: String,
        loading: {
            type: Boolean,
            default: false,
        },
    })

    const isOpen = ref(false)



    // START: Parameters
    const params = new Proxy(new URLSearchParams(window.location.search), {
        get: (searchParams, prop) => searchParams.get(prop),
    })

    const category = computed(() => params.category || 'all')
    const sort = computed(() => params.sort || 'all')
    const searchParam = ref(params.search || '')
    const searchInput = ref(searchParam.value)
    // END: Parameters



    // START: Search
    const search = () => {
        Inertia.visit(route('wiki', {category: category.value, sort: sort.value, search: searchInput.value}))
    }



    const is = (routenames) => {
        if (typeof routenames === 'string') routenames = [routenames]

        return routenames.some(routename => route().current() === routename)
    }
</script>

<style lang="sass" scoped>
    .toggle-open
        display: none
        width: 3rem
        height: 2.5rem
        color: inherit
        background: transparent
        border: none
        padding: 0
        position: relative
        z-index: 2000
        cursor: pointer

        &.open
            position: fixed
            top: .75rem
            right: .75rem
            color: var(--color-heading)
            .svg-wrapper .hamburger-path
                stroke-dashoffset: -23.8

        .svg-wrapper
            height: 80%
            aspect-ratio: 1
            color: inherit
            position: absolute
            top: 50%
            left: 50%
            transform: translate(-50%, -50%)
            
            .hamburger-path
                stroke-dasharray: 14 100
                transition: all 300ms, color 100ms
                stroke: currentColor

    .layout
        display: flex
        min-height: 100vh
        align-items: flex-start
        position: relative
        font-family: var(--font-interface)
        background: var(--color-background-soft)

        .menu
            width: 22rem
            height: 100vh
            position: sticky
            top: 0
            left: 0
            box-shadow: var(--shadow-elevation-low)
            display: flex
            
            .apps-bar
                background: var(--color-background-soft)
                width: 4rem
                color: var(--color-heading)
                display: flex
                flex-direction: column

                .logo
                    flex: none
                    width: 4rem
                    height: 4rem
                    aspect-ratio: 1
                    padding: 1rem
                    display: flex
                    align-items: center
                    color: inherit
                    position: relative

                    &::after
                        content: ''
                        position: absolute
                        left: 0
                        bottom: 0
                        transform: translateY(100%)
                        width: 100%
                        height: 14px
                        background: linear-gradient(180deg, rgb(black, 0.1) 0%, rgb(black, 0) 100%)

                    img
                        height: 100%
                        object-fit: contain

                .spacer
                    flex: 1

                .divider
                    flex: none
                    width: 100%
                    border: none
                    margin: 0
                    border-bottom: 1px solid #00000033

                .group
                    flex: none
                    display: flex
                    flex-direction: column
                    gap: 3px
                    padding: 1rem .5rem

                    .app
                        height: 3rem
                        aspect-ratio: 1
                        display: flex
                        align-items: center
                        justify-content: center
                        color: inherit
                        font-size: 1.5rem
                        font-family: var(--font-icon)
                        font-weight: lighter !important
                        position: relative
                        border-radius: var(--radius-m)
                        user-select: none
                        cursor: pointer

                        &::after
                            content: ''
                            position: absolute
                            left: 0
                            bottom: 0
                            width: 100%
                            height: 100%
                            background: currentColor
                            opacity: 0
                            border-radius: inherit
                            pointer-events: none

                        &.active,
                        &:hover
                            &::after
                                opacity: .1

            .menu-bar
                flex: 1
                width: calc(100% - 4rem)
                background: var(--color-background)
                display: flex
                flex-direction: column
                gap: 1rem

                .top-bar
                    position: relative
                    padding: 0 .75rem
                    height: 4rem
                    display: flex
                    align-items: center

                    &::after
                        content: ''
                        position: absolute
                        left: 0
                        bottom: 0
                        transform: translateY(100%)
                        width: 100%
                        height: 14px
                        background: linear-gradient(180deg, rgb(black, 0.06) 0%, rgb(black, 0) 100%)

                    .searchbar
                        flex: 1
                        height: 2.5rem

                .menu-scroll-container
                    overflow-y: auto
                    flex: 1
                    display: flex
                    flex-direction: column
                    gap: 1rem
                    padding-bottom: 1rem

                    &::-webkit-scrollbar
                        width: 6px
                        height: 6px

                    &::-webkit-scrollbar-track
                        background: var(--color-background)

                    &::-webkit-scrollbar-thumb
                        background: #00000050
                        border-radius: 3px
                        background-clip: content-box
                        border: 2px solid transparent

                        &:hover
                            background: var(--color-text)
                            border: 0px solid transparent
                            border-radius: 1px

                .menu-group
                    display: flex
                    flex-direction: column
                    gap: 3px

                    .group-label
                        height: 2rem
                        line-height: 2rem
                        white-space: nowrap
                        overflow: hidden
                        text-overflow: ellipsis
                        padding: 0 1rem
                        margin-bottom: .5rem
                        border-bottom: 1px solid var(--color-border)
                        font-size: .9rem
                        font-weight: 600
                        will-change: height
                        transition: height 200ms cubic-bezier(0.22, 0.61, 0.36, 1)

                .menu-item,
                .menu-entry
                    display: flex
                    align-items: center
                    height: 3rem
                    user-select: none
                    cursor: pointer
                    position: relative
                    color: var(--color-text)

                    &::before
                        content: ''
                        position: absolute
                        top: 0
                        left: .5rem
                        width: calc(100% - 1rem)
                        height: 100%
                        border-radius: var(--radius-m)
                        background: var(--color-background)

                    &:hover::before,
                    &.active::before
                        background: var(--color-background-soft)

                    .icon
                        width: 4.5rem
                        flex: none
                        height: 100%
                        display: flex
                        align-items: center
                        justify-content: center
                        font-size: 1.5rem
                        line-height: 1
                        font-family: var(--font-icon)
                        position: relative
                        opacity: .9

                    .text
                        flex: 1
                        position: relative
                        overflow: hidden
                        text-overflow: ellipsis
                        white-space: nowrap
                        font-weight: 500
                        font-size: .9rem
                        color: var(--color-heading)
                        transition: transform 200ms cubic-bezier(0.22, 0.61, 0.36, 1)

                    .external
                        flex: none
                        font-size: 1.1rem
                        line-height: 1
                        font-family: var(--font-icon)
                        position: relative
                        opacity: .9
                        margin-inline: .5rem
                        padding-right: 1rem

                .menu-entry
                    height: 2rem

                    &::before
                        border-radius: 0
                        left: 0
                        width: 100%

                    &:hover
                        .text
                            transform: translateX(.5rem)

                    .text
                        font-size: .8rem
                        padding-inline: 1rem

        .content
            flex: 1
            font-family: var(--font-interface)

            #hero-section
                &.has-image
                    .hero-card
                        height: 300px
                        color: var(--color-background)
                        align-items: flex-start
                        box-shadow: none
                        overflow: hidden

                        .hero-card-info-wrapper
                            padding-bottom: 3rem
                            background: linear-gradient(180deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%)

                .hero-card
                    text-align: center
                    color: var(--color-heading)
                    background: var(--color-background)
                    background-position: center
                    background-repeat: no-repeat
                    background-size: cover
                    border-radius: 0 0 var(--radius-m) var(--radius-m)
                    box-shadow: var(--shadow-elevation-low)
                    height: 4rem
                    display: flex
                    align-items: center
                    position: relative

                    .hero-card-info-wrapper
                        flex: 1
                        display: flex
                        align-items: center
                        justify-content: center
                        padding: .75rem 1rem

                    .back-button
                        display: flex
                        align-items: center
                        justify-content: center
                        width: 3rem
                        height: 2.5rem
                        border-radius: 0
                        cursor: pointer
                        transition: all 100ms ease
                        border: none
                        outline: none
                        background-color: transparent
                        font-family: var(--font-icon)
                        font-size: 1.3rem
                        color: inherit
                        padding: 0

                    h1
                        font-size: 1.5rem
                        flex: 1
                        position: relative
                        overflow: hidden
                        text-overflow: ellipsis
                        white-space: nowrap
                        margin: 0
                        color: inherit

                    .loader
                        position: absolute
                        bottom: 0
                        left: var(--radius-m)
                        height: 2px
                        width: calc(100% - 2 * var(--radius-m))

            #content-section
                margin: 2rem 0

                .limiter
                    display: flex
                    flex-direction: column

                .fab
                    position: fixed
                    bottom: 3rem
                    right: 3rem
                    z-index: 1000



    @media only screen and (max-width: 900px)
        .toggle-open
            display: flex

        .layout
            .menu
                width: 100%
                position: fixed
                z-index: 1000
                top: 0
                left: 0
                height: 100%
                overflow-y: auto
                transform: translateX(-100%)
                transition: transform 200ms cubic-bezier(0.22, 0.61, 0.36, 1)

                &.open
                    transform: translateX(0)

        #hero-section
            .limiter
                padding: 0

            .hero-card
                border-radius: 0 !important

            &.has-image
                .hero-card
                    height: 200px !important
</style>