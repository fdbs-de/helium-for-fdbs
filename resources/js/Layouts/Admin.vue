<template>
    <button class="toggle-open" :class="{'open': isOpen}" :title="isOpen ? 'Menü ausklappen' : 'Menü einklappen'" @click="isOpen = !isOpen">
        <svg class="svg-wrapper" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
            <path class="hamburger-path" d="M5 9C5 9 17.5 9 19 9C20.5 9 22.5 7.5 21.5 6C20.5 4.5 18 6 17 7C16 8 7 17 7 17"/>
            <path class="hamburger-path" d="M5 15.0054C5 15.0054 17.5 15.0054 19 15.0054C20.5 15.0054 22.5 16.5054 21.5 18.0054C20.5 19.5054 18 18.0054 17 17.0054C16 16.0054 7 7.00542 7 7.00542"/>
        </svg>
    </button>

    <div class="layout">
        <div class="menu" :class="{'open': isOpen}">
            <div class="logo">
                <Link class="logo-link" :href="route('home')">
                    <img src="/images/branding/logo_sloganless.svg" alt="FDBS Logo">
                </Link>
            </div>

            <div class="menu-group">
                <Link class="menu-item" :href="route('dashboard.admin.users')" :class="{'active': is('dashboard')}">
                    <div class="icon" aria-hidden="true">dashboard</div>
                    <div class="text">Übersicht</div>
                </Link>
                <Link class="menu-item" :href="route('dashboard.admin.users')" :class="{'active': is('dashboard.admin.users')}">
                    <div class="icon" aria-hidden="true">groups</div>
                    <div class="text">Benutzer</div>
                </Link>
            </div>
            
            <div class="menu-group">
                <div class="group-label">Allgemein</div>
                <Link class="menu-item" :href="route('admin.categories')" :class="{'active': is('admin.categories')}">
                    <div class="icon" aria-hidden="true">category</div>
                    <div class="text">Kategorien</div>
                </Link>
                <Link class="menu-item" :href="route('admin.posts')" :class="{'active': is('admin.posts')}">
                    <div class="icon" aria-hidden="true">feed</div>
                    <div class="text">Posts</div>
                </Link>
                <!-- <Link class="menu-item" :href="route('admin.posts')" :class="{'active': is('admin.posts')}">
                    <div class="icon" aria-hidden="true">account_tree</div>
                    <div class="text">Seiten</div>
                </Link> -->
                <Link class="menu-item" :href="route('admin.media')" :class="{'active': is('admin.media')}">
                    <div class="icon" aria-hidden="true">folder_open</div>
                    <div class="text">Medien</div>
                </Link>
                <Link class="menu-item" :href="route('dashboard.admin.docs')" :class="{'active': is('dashboard.admin.docs')}">
                    <div class="icon" aria-hidden="true">folder_open</div>
                    <div class="text">Dokumente</div>
                </Link>
                <Link class="menu-item" :href="route('dashboard.admin.specs')" :class="{'active': is('dashboard.admin.specs')}">
                    <div class="icon" aria-hidden="true">cloud_done</div>
                    <div class="text">Spezifikationen</div>
                </Link>
            </div>

            <!-- <div class="menu-group">
                <div class="group-label">Apps</div>
                <Link class="menu-item" :href="route('admin.categories')" :class="{'active': is('admin.categories')}">
                    <div class="icon" aria-hidden="true">apps</div>
                    <div class="text">Apps</div>
                </Link>
            </div> -->
            
            <div class="menu-group">
                <div class="group-label">Einstellungen</div>
                <!-- <Link class="menu-item" :href="route('admin.posts')" :class="{'active': is('admin.posts')}">
                    <div class="icon" aria-hidden="true">settings</div>
                    <div class="text">Globale Einstellungen</div>
                </Link> -->
                <Link class="menu-item" :href="route('dashboard.profile')">
                    <div class="icon" aria-hidden="true">account_circle</div>
                    <div class="text">Profil</div>
                </Link>
            </div>
        </div>

        <main class="content">
            <div id="hero-section">
                <div class="limiter">
                    <div class="hero-card">
                        <h1>{{ title }}</h1>
                    </div>
                </div>
            </div>
            
            <section id="content-section">
                <div class="limiter">
                    <div class="main-card">
                        <div class="dashboard-nav-bar" v-if="$slots.head">
                            <slot name="head" />
                        </div>
                        <slot />
            
                        <div class="fab" v-if="$slots.fab">
                            <slot name="fab" />
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</template>

<script setup>
    import Footer from '@/Components/Page/Footer.vue'
    import { Link, usePage } from '@inertiajs/inertia-vue3'
    import { ref, computed } from 'vue'
    import { can } from '@/Utils/Permissions'



    defineProps({
        area: String,
        title: String,
    })



    const user = computed(() =>{
        return usePage().props.value.auth.user
    })

    const isOpen = ref(false)



    const is = (routeName) => {
        return routeName === route().current()
    }
</script>

<style lang="sass" scoped>
    .toggle-open
        display: none
        height: 3rem
        aspect-ratio: 1
        color: inherit
        background: transparent
        border: none
        padding: 0
        position: fixed
        top: 0
        right: 0
        z-index: 2000
        cursor: pointer
        color: var(--color-heading)
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-m)

        &.open
            .svg-wrapper .hamburger-path
                stroke-dashoffset: -23.8

        .svg-wrapper
            height: 70%
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
        border-bottom: 1px solid var(--color-border)
        position: relative
        font-family: var(--font-interface)
        background: var(--color-background-soft)

        .menu
            width: 300px
            background: var(--color-background)
            box-shadow: var(--shadow-elevation-low)
            display: flex
            flex-direction: column
            gap: 2rem
            padding-bottom: 1rem
            will-change: width, gap, transform
            transition: width 200ms cubic-bezier(0.22, 0.61, 0.36, 1), gap 200ms, transform 200ms

            &.collapsed
                width: 4.5rem
                gap: 1rem

                .menu-group
                    .group-label
                        height: 0

                .menu-item::before
                    width: 100%
                    border-radius: 0

            .logo
                flex: none
                height: 4rem
                width: 100%
                display: flex
                align-items: center
                color: var(--color-heading)
                user-select: none
                position: relative
                z-index: 1
                will-change: width
                transition: width 200ms cubic-bezier(0.22, 0.61, 0.36, 1)

                &::after
                    content: ''
                    position: absolute
                    left: 0
                    bottom: 0
                    transform: translateY(100%)
                    width: 100%
                    height: 7px
                    background: linear-gradient(180deg, rgb(black, 0.06) 0%, rgb(black, 0) 100%)

                .logo-link
                    height: 100%
                    padding: .75rem
                    display: flex
                    align-items: center
                    color: inherit
                    overflow: hidden

                    img
                        height: 100%
                        object-fit: contain

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

            .menu-item
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
                    transition: all 200ms cubic-bezier(0.22, 0.61, 0.36, 1)

                .external
                    flex: none
                    font-size: 1.1rem
                    line-height: 1
                    font-family: var(--font-icon)
                    position: relative
                    opacity: .9
                    margin-inline: .5rem
                    padding-right: 1rem

        .content
            flex: 1
            padding-bottom: 1rem
            font-family: var(--font-interface)



    @media only screen and (max-width: 900px)
        .toggle-open
            display: flex

            

        .layout
            min-height: 0

            .menu
                width: 280px
                position: fixed
                z-index: 1000
                top: 0
                right: 0
                height: 100%
                overflow-y: auto
                transform: translateX(100%)

                &.open
                    transform: translateX(0)



    #hero-section
        .hero-card
            text-align: center
            background: var(--color-background)
            border-radius: 0 0 var(--radius-m) var(--radius-m)
            box-shadow: var(--shadow-elevation-low)
            padding: 1rem
            height: 5rem
            display: flex
            align-items: center
            justify-content: center

            h1
                font-size: 1.5rem

    #content-section
        margin: 2rem 0

        .main-card
            display: flex
            flex-direction: column

            .checkbox
                --mui-background: var(--color-background)

            .dashboard-nav-bar
                display: flex
                flex-wrap: wrap
                align-items: center
                gap: 1rem
                padding: 1rem
                border-radius: var(--radius-l)
                background: var(--color-background)
                box-shadow: var(--shadow-elevation-low)
                --mui-background: var(--color-background-soft)
                position: relative

                > a
                    height: 2.5rem
                    font-size: .8rem
                    letter-spacing: .05rem
                    font-weight: 600
                    text-transform: uppercase
                    color: var(--color-text)
                    border-radius: calc(var(--su) * .5)
                    padding-inline: 1rem
                    display: flex
                    align-items: center
                    cursor: pointer
                    user-select: none

                    &:hover,
                    &:focus
                        background: var(--color-background-soft)
                        color: var(--color-heading)

                    &.active
                        background: var(--color-primary)
                        color: var(--color-background)

        .fab
            position: fixed
            bottom: 3rem
            right: 3rem
            z-index: 1000

    @media only screen and (max-width: 900px)
        #content-section
            margin: 1rem 0

            .main-card
                .dashboard-nav-bar
                    flex-direction: column
                    align-items: flex-start
                    gap: 1rem
</style>