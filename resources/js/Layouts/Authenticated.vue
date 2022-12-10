<template>
    <!-- <Header :menu="menu"/> -->
    <div class="header" :class="{'collapsed': isCollapsed, 'open': isOpen}">
        <div class="logo">
            <Link class="logo-link" :href="route('home')">
                <div class="icon">
                    <img src="/images/branding/icon_white_dashboard.svg" alt="FDBS Icon">
                </div>
                <div class="text">Loginbereich</div>
            </Link>
            <!-- <button class="toggle-collaps" :title="isCollapsed ? 'Menü ausklappen' : 'Menü einklappen'" @click="isCollapsed = !isCollapsed">
                <div class="icon" :class="{'collapsed': isCollapsed}" aria-hidden="true">chevron_left</div>
            </button> -->
        </div>

        <div class="header-content">
            <div class="limiter">
                <Link class="mobile-logo" :href="route('home')">
                    <img src="/images/branding/icon_dashboard.svg" alt="FDBS Icon">
                </Link>
                <div class="path">
                    <span class="part">{{area}}</span>
                    <span class="chevron">chevron_right</span>
                    <span class="main">{{title}}</span>
                </div>
                <button class="toggle-open" :title="isOpen ? 'Menü ausklappen' : 'Menü einklappen'" @click="isOpen = !isOpen">
                    <svg class="svg-wrapper" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                        <path class="hamburger-path" d="M5 9C5 9 17.5 9 19 9C20.5 9 22.5 7.5 21.5 6C20.5 4.5 18 6 17 7C16 8 7 17 7 17"/>
                        <path class="hamburger-path" d="M5 15.0054C5 15.0054 17.5 15.0054 19 15.0054C20.5 15.0054 22.5 16.5054 21.5 18.0054C20.5 19.5054 18 18.0054 17 17.0054C16 16.0054 7 7.00542 7 7.00542"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div class="layout">
        <div class="menu" :class="{'collapsed': isCollapsed, 'open': isOpen}">
            <div class="menu-group">
                <Link class="menu-item" :href="route('dashboard')" :class="{'active': is('dashboard')}">
                    <div class="icon" aria-hidden="true">home</div>
                    <div class="text">Startseite</div>
                </Link>
                <Link class="menu-item" :href="route('dashboard.profile')" :class="{'active': is('dashboard.profile')}">
                    <div class="icon" aria-hidden="true">account_circle</div>
                    <div class="text">Profil</div>
                </Link>
            </div>

            <div class="menu-group" v-if="user.can_access_customer_panel">
                <div class="group-label">Kundenbereich</div>
                <Link class="menu-item" :href="route('dashboard.customer.specs')" :class="{'active': is('dashboard.customer.specs')}">
                    <div class="icon" aria-hidden="true">fact_check</div>
                    <div class="text">Spezifikationen</div>
                </Link>
                <Link class="menu-item" :href="route('dashboard.customer.offers')" :class="{'active': is('dashboard.customer.offers')}">
                    <div class="icon" aria-hidden="true">sell</div>
                    <div class="text">Angebote</div>
                </Link>
            </div>

            <div class="menu-group" v-if="user.can_access_employee_panel">
                <div class="group-label">Intranet</div>
                <Link class="menu-item" :href="route('dashboard.employee.overview')" :class="{'active': is('dashboard.employee.overview')}">
                    <div class="icon" aria-hidden="true">newspaper</div>
                    <div class="text">News und Termine</div>
                </Link>
                <Link class="menu-item" :href="route('dashboard.employee.documents')" :class="{'active': is('dashboard.employee.documents')}">
                    <div class="icon" aria-hidden="true">download</div>
                    <div class="text">Dokumente</div>
                </Link>
                <a class="menu-item" target="_blank" :href="route('docs', 'leitbild')">
                    <div class="icon" aria-hidden="true">explore</div>
                    <div class="text">Leitbild</div>
                </a>
                <a class="menu-item" target="_blank" :href="route('docs', 'organigramm')">
                    <div class="icon" aria-hidden="true">lan</div>
                    <div class="text">Organigramm</div>
                </a>
                <Link class="menu-item" :href="route('dashboard.employee.qm')" :class="{'active': is('dashboard.employee.qm')}">
                    <div class="icon" aria-hidden="true">workspace_premium</div>
                    <div class="text">Qualitätsmanagement</div>
                </Link>
                <a class="menu-item" target="_blank" href="https://fleischer-dienst.uweb2000.de">
                    <div class="icon" aria-hidden="true">school</div>
                    <div class="text">UWEB Schulungen</div>
                </a>
                <a class="menu-item" target="_blank" href="https://fleischer-dienst.mitarbeiterangebote.de/login">
                    <div class="icon" aria-hidden="true">percent</div>
                    <div class="text">Mitarbeiterangebote</div>
                </a>
            </div>

            <div class="menu-group" v-if="user.can_access_admin_panel">
                <div class="group-label">Adminbereich</div>
                <Link class="menu-item" :href="route('dashboard.admin.users')" :class="{'active': is('dashboard.admin.users')}">
                    <div class="icon" aria-hidden="true">verified_user</div>
                    <div class="text">Nutzer</div>
                </Link>
                <Link class="menu-item" :href="route('dashboard.admin.specs')" :class="{'active': is('dashboard.admin.specs')}">
                    <div class="icon" aria-hidden="true">fact_check</div>
                    <div class="text">Spezifikationen</div>
                </Link>
                <Link class="menu-item" :href="route('dashboard.admin.docs')" :class="{'active': is('dashboard.admin.docs')}">
                    <div class="icon" aria-hidden="true">upload</div>
                    <div class="text">Dokumente</div>
                </Link>
                <Link class="menu-item" :href="route('dashboard.admin.media')" :class="{'active': is('dashboard.admin.media')}">
                    <div class="icon" aria-hidden="true">folder_open</div>
                    <div class="text">Media</div>
                </Link>
                <Link class="menu-item" :href="route('dashboard.admin.posts')" :class="{'active': is('dashboard.admin.posts')}">
                    <div class="icon" aria-hidden="true">post_add</div>
                    <div class="text">Posts</div>
                </Link>
            </div>
        </div>

        <main class="content">
            <slot />
        </main>
    </div>

    <Footer/>
</template>

<script setup>
    import Header from '@/Components/Page/Header.vue'
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

    const isCollapsed = ref(false)
    const isOpen = ref(false)



    const is = (routeName) => {
        return routeName === route().current()
    }
</script>

<style lang="sass" scoped>
    .header
        display: flex
        position: fixed
        top: 0
        left: 0
        width: 100%
        height: 4.5rem
        z-index: 1000
        font-family: var(--font-interface)

        &.collapsed
            .logo
                width: 4.5rem

        .logo
            flex: none
            height: 100%
            width: 300px
            display: flex
            align-items: center
            background: var(--color-primary)
            color: white
            user-select: none
            position: relative
            z-index: 1
            will-change: width
            transition: width 200ms cubic-bezier(0.22, 0.61, 0.36, 1)

            .logo-link
                width: 100%
                height: 100%
                display: flex
                align-items: center
                color: inherit
                overflow: hidden

                .icon
                    height: 100%
                    aspect-ratio: 1/1
                    display: flex
                    align-items: center
                    justify-content: center

                    img
                        height: 1.75rem
                        aspect-ratio: 1/1
                        object-fit: contain

                .text
                    font-family: var(--font-heading)
                    font-weight: 600

            .toggle-collaps
                cursor: pointer
                border: none
                background: rgba(0, 0, 0, 0.1)
                color: var(--color-heading)
                border-radius: 0 var(--radius-s) var(--radius-s) 0
                position: absolute
                top: 0
                left: 100%
                width: 1.75rem
                height: 4.5rem
                display: flex
                align-items: center
                justify-content: center
                transition: all 100ms

                &:hover
                    outline: none
                    background: var(--color-primary-soft)
                    color: white

                .icon
                    font-size: 1.5rem
                    font-family: var(--font-icon)
                    transition: all 100ms
                    color: inherit

                    &.collapsed
                        transform: rotate(180deg)

        .header-content
            flex: 1
            display: flex
            align-items: center
            background: #eeeeeedd
            backdrop-filter: blur(14px)
            border-bottom: 1px solid #ffffff99

            .limiter
                display: flex
                align-items: center
                gap: 1rem

            .mobile-logo
                height: 3rem
                aspect-ratio: 1
                display: none
                align-items: center
                justify-content: center

                img
                    height: 1.5rem
                    aspect-ratio: 1
                    object-fit: contain

            .path
                flex: 1
                display: flex
                align-items: center
                gap: 1rem
                user-select: none
                font-family: var(--font-heading)
                font-size: 1.2rem

                .chevron
                    font-family: var(--font-icon)

                .main
                    color: var(--color-primary)
                    font-weight: 600

            .toggle-open
                display: none
                height: 3rem
                aspect-ratio: 1
                color: inherit
                background: transparent
                border: none
                padding: 0
                position: relative
                z-index: 2
                cursor: pointer
                color: var(--color-heading)

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
        border-bottom: 1px solid rgba(0, 0, 0, 0.1)
        position: relative
        margin-top: 4.5rem
        font-family: var(--font-interface)

        .menu
            width: 300px
            background: #eeeeeedd
            backdrop-filter: blur(14px)
            border-right: 1px solid #ffffff99
            display: flex
            flex-direction: column
            gap: 2rem
            padding-block: 1rem
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

            .menu-group
                display: flex
                flex-direction: column
                color: var(--color-heading)

                .group-label
                    height: 2rem
                    line-height: 2rem
                    white-space: nowrap
                    overflow: hidden
                    text-overflow: ellipsis
                    padding: 0 1rem
                    margin-bottom: 1rem
                    border-bottom: 1px solid rgba(0, 0, 0, 0.1)
                    color: var(--color-heading)
                    letter-spacing: .5px
                    text-transform: uppercase
                    font-size: .8rem
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
                color: var(--color-heading)

                &::before
                    content: ''
                    position: absolute
                    top: 0
                    left: 0
                    width: calc(100% - .5rem)
                    height: 100%
                    border-radius: 0 3rem 3rem 0
                    background: #ffffff00

                &:hover,
                &.active
                    color: var(--color-primary)

                    &::before
                        background: #ffffff99

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

                .text
                    position: relative
                    overflow: hidden
                    text-overflow: ellipsis
                    white-space: nowrap
                    transition: all 200ms cubic-bezier(0.22, 0.61, 0.36, 1)

        .content
            flex: 1
            font-family: var(--font-interface)



    @media only screen and (max-width: 900px)
        .header
            height: 3.5rem

            .limiter
                padding: 0 .3rem

            .logo
                display: none

            .header-content
                .mobile-logo
                    display: flex

                .path
                    font-size: .9rem
                    justify-content: center
                    font-weight: 600
                    font-family: var(--font-heading)

                    .main
                        color: var(--color-heading)

                    .chevron, .part
                        display: none

                .toggle-open
                    display: flex

            &.open
                .header-content
                    .toggle-open
                        .svg-wrapper .hamburger-path
                            stroke-dashoffset: -23.8

        .layout
            margin-top: 3.5rem
            min-height: 0

            .menu
                width: 280px
                position: fixed
                z-index: 1000
                top: 3.5rem
                right: 0
                border-right: none
                border-left: 1px solid #ffffff99
                height: calc(100% -  3.5rem)
                overflow-y: auto
                transform: translateX(100%)

                &.open
                    transform: translateX(0)

                .menu-item::before
                    width: 100%
                    border-radius: 0
</style>