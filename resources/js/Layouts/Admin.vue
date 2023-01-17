<template>
    <Head>
        <link rel="icon" href="/images/app/branding/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/images/app/branding/favicon.ico" type="image/x-icon">
        <title>{{title || 'CMS'}} – Gastro CMS</title>
    </Head>

    <div class="layout">
        <div class="menu" :class="{'open': isOpen}">
            <div class="apps-bar">
                <Link class="logo" :href="route('admin')">
                    <img src="/images/app/branding/cms_icon_white.svg" alt="Gastro CMS Logo">
                </Link>

                <div class="group">
                    <Link class="app"
                        v-for="item in menu[0].filter(e => canAny(e.permission))"
                        :key="item.route"
                        :href="item.route"
                        :style="`color: ${item.color};`"
                        v-tooltip.right="item.label"
                        :class="{'active': is(item.activeWhen)}">
                        {{item.icon}}
                    </Link>
                </div>
                <div class="divider"></div>
                <div class="group">
                    <Link class="app"
                        v-for="item in menu[1].filter(e => canAny(e.permission))"
                        :key="item.route"
                        :href="item.route"
                        :style="`color: ${item.color};`"
                        v-tooltip.right="item.label"
                        :class="{'active': is(item.activeWhen)}">
                        {{item.icon}}
                    </Link>
                </div>
                <div class="spacer"></div>
                <div class="group">
                    <!-- <div class="app" v-tooltip.right="'Sprache'">language</div> -->
                    <Link class="app"
                        v-for="item in menu[2].filter(e => canAny(e.permission))"
                        :key="item.route"
                        :href="item.route"
                        :style="`color: ${item.color};`"
                        v-tooltip.right="item.label"
                        :class="{'active': is(item.activeWhen)}">
                        {{item.icon}}
                    </Link>
                </div>
            </div>

            <div class="menu-bar">
                <div class="website-profile">
                    <a class="redirect-tag" :href="route('home')" target="_blank">FDBS</a>
                </div>

                <div class="menu-group" v-for="group in menu.flat().filter(e => (canAny(e.permission) && e.submenu.length > 0))" :key="group.route" v-show="is(group.activeWhen)">
                    <Link class="menu-item" v-for="item in group.submenu.filter(e => canAny(e.permission))" :key="item.route" :href="item.route" :class="{'active': is(item.activeWhen)}">
                        <div class="icon" aria-hidden="true">{{item.icon}}</div>
                        <div class="text">{{item.label}}</div>
                    </Link>
                </div>
            </div>
        </div>

        <main class="content">
            <div id="hero-section">
                <div class="limiter">
                    <div class="hero-card">
                        <Link class="back-button" v-if="backlink" :href="backlink" v-tooltip="backlinkText">arrow_back</Link>
                        <h1>{{ title }}</h1>

                        <button class="toggle-open" :class="{'open': isOpen}" :title="isOpen ? 'Menü ausklappen' : 'Menü einklappen'" @click="isOpen = !isOpen">
                            <svg class="svg-wrapper" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                <path class="hamburger-path" d="M5 9C5 9 17.5 9 19 9C20.5 9 22.5 7.5 21.5 6C20.5 4.5 18 6 17 7C16 8 7 17 7 17"/>
                                <path class="hamburger-path" d="M5 15.0054C5 15.0054 17.5 15.0054 19 15.0054C20.5 15.0054 22.5 16.5054 21.5 18.0054C20.5 19.5054 18 18.0054 17 17.0054C16 16.0054 7 7.00542 7 7.00542"/>
                            </svg>
                        </button>

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



    defineProps({
        area: String,
        title: String,
        backlink: [String, Object, Function],
        backlinkText: String,
        loading: {
            type: Boolean,
            default: false,
        }
    })



    const user = computed(() =>{
        return usePage().props.value.auth.user
    })

    const isOpen = ref(false)

    const menu = ref([
        [
            {label: 'Übersicht', color: 'var(--color-background)', icon: 'dashboard', route: route('admin'), permission: [], activeWhen: ['admin', 'admin.users', 'admin.roles', 'admin.media', 'admin.docs', 'admin.specs'], submenu: [
                {label: 'Dashboard', icon: 'dashboard', route: route('admin'), permission: [], activeWhen: ['admin']},
                {label: 'Benutzer', icon: 'person', route: route('admin.users'), permission: ['system.view.users'], activeWhen: ['admin.users']},
                {label: 'Berechtigungen', icon: 'key', route: route('admin.roles'), permission: ['system.view.roles'], activeWhen: ['admin.roles']},
                {label: 'Medien', icon: 'folder_open', route: route('admin.media'), permission: ['system.view.media'], activeWhen: ['admin.media']},
                {label: 'Dokumente', icon: 'folder_open', route: route('admin.docs'), permission: ['edit docs'], activeWhen: ['admin.docs']},
                {label: 'Spezifikationen', icon: 'cloud_done', route: route('admin.specs'), permission: ['edit specs'], activeWhen: ['admin.specs']},
            ]},
        ],
        [
            {label: 'Blog', color: 'var(--color-app-blog-on-dark)', icon: 'newspaper', route: route('admin.posts'), permission: ['app.blog.access.admin.panel'], activeWhen: ['admin.posts', 'admin.categories', 'admin.posts.editor', 'admin.categories.editor'], submenu: [
                {label: 'Beiträge', icon: 'feed', route: route('admin.posts'), permission: ['view app blog'], activeWhen: ['admin.posts']},
                {label: 'Kategorien', icon: 'category', route: route('admin.categories'), permission: ['view app blog'], activeWhen: ['admin.categories']},
            ]},
            {label: 'Intranet', color: 'var(--color-app-intranet-on-dark)', icon: 'domain', route: route('admin.posts'), permission: ['app.intranet.access.admin.panel'], activeWhen: ['admin.intranet'], submenu: [
                {label: 'Beiträge', icon: 'feed', route: route('admin.posts'), permission: ['view app blog'], activeWhen: ['admin.posts']},
                {label: 'Kategorien', icon: 'category', route: route('admin.categories'), permission: ['view app blog'], activeWhen: ['admin.categories']},
            ]},
            {label: 'Jobs', color: 'var(--color-app-jobs-on-dark)', icon: 'work', route: route('admin.posts'), permission: ['app.jobs.access.admin.panel'], activeWhen: ['admin.jobs'], submenu: [
                {label: 'Stellenangebote', icon: 'feed', route: route('admin.posts'), permission: ['view app blog'], activeWhen: ['admin.posts']},
                {label: 'Kategorien', icon: 'category', route: route('admin.categories'), permission: ['view app blog'], activeWhen: ['admin.categories']},
            ]},
            {label: 'Wiki', color: 'var(--color-app-wiki-on-dark)', icon: 'local_library', route: route('admin.posts'), permission: ['app.wiki.access.admin.panel'], activeWhen: ['admin.wiki'], submenu: [
                {label: 'Einträge', icon: 'feed', route: route('admin.posts'), permission: ['view app blog'], activeWhen: ['admin.posts']},
                {label: 'Kategorien', icon: 'category', route: route('admin.categories'), permission: ['view app blog'], activeWhen: ['admin.categories']},
            ]},
            // {label: 'Seiten', color: 'var(--color-app-pages-on-dark)', icon: 'pages', route: route('admin.posts'), permission: ['app.pages.access.admin.panel'], activeWhen: ['admin.pages'], submenu: [
            //     {label: 'Seiten', icon: 'feed', route: route('admin.posts'), permission: ['view app blog'], activeWhen: ['admin.posts']},
            //     {label: 'Kategorien', icon: 'category', route: route('admin.categories'), permission: ['view app blog'], activeWhen: ['admin.categories']},
            // ]},
            // {label: 'Marketing', color: 'var(--color-app-marketing-on-dark)', icon: 'podcasts', route: route('admin.posts'), permission: ['app.marketing.access.admin.panel'], activeWhen: ['admin.marketing'], submenu: []},
        ],
        [
            {label: 'Globale Einstellungen', color: 'var(--color-background)', icon: 'settings', route: route('admin.settings'), permission: ['system.view.settings'], activeWhen: ['admin.settings'], submenu: []},
            {label: 'Profil', color: 'var(--color-background)', icon: 'account_circle', route: route('dashboard.profile'), permission: [], activeWhen: [], submenu: []},
        ],
    ])



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
        color: var(--color-heading)
        background: var(--color-background)

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
        align-items: flex-start
        position: relative
        font-family: var(--font-interface)
        background: var(--color-background-soft)

        --color-primary: #3742fa !important
        --mui-primary: #3742fa !important
        --primary: #3742fa !important

        .menu
            width: 22rem
            height: 100vh
            position: sticky
            top: 0
            left: 0
            box-shadow: var(--shadow-elevation-low)
            display: flex
            
            .apps-bar
                background: var(--color-heading)
                width: 4rem
                color: white
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
                    border-bottom: 1px solid #ffffff33

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
                background: var(--color-background)
                display: flex
                flex-direction: column
                gap: 1rem
                padding-bottom: 1rem

                .website-profile
                    position: relative
                    padding: 0 1rem
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

                    .redirect-tag
                        display: flex
                        align-items: center
                        gap: .5rem
                        height: 2rem
                        padding: 0 1rem
                        background: var(--color-background-soft)
                        color: var(--color-heading)
                        border-radius: 2rem
                        font-size: .8rem
                        font-weight: 600

                        &::after
                            content: 'open_in_new'
                            line-height: 1
                            font-size: .8rem
                            font-family: var(--font-icon)
                            opacity: .7

                        &:hover
                            color: var(--color-primary)

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
            font-family: var(--font-interface)

            #hero-section
                .hero-card
                    text-align: center
                    background: var(--color-background)
                    border-radius: 0 0 var(--radius-m) var(--radius-m)
                    box-shadow: var(--shadow-elevation-low)
                    padding: 1rem
                    height: 4rem
                    display: flex
                    align-items: center
                    justify-content: center
                    position: relative

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
                        color: var(--color-text)
                        padding: 0

                        &:hover
                            color: var(--color-heading)

                    h1
                        font-size: 1.5rem
                        flex: 1
                        position: relative

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
</style>