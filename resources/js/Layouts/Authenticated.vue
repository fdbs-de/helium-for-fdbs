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
                <Link class="menu-item" :href="route('dashboard')" :class="{'active': is('dashboard')}">
                    <div class="icon" aria-hidden="true">home</div>
                    <div class="text">Startseite</div>
                </Link>
                <Link class="menu-item" :href="route('dashboard.profile')" :class="{'active': is('dashboard.profile')}">
                    <div class="icon" aria-hidden="true">account_circle</div>
                    <div class="text">Profil</div>
                </Link>
                <Link class="menu-item" v-if="user.can_access_admin_panel" :href="route('dashboard.admin.users')">
                    <div class="icon" aria-hidden="true">shield</div>
                    <div class="text">Adminbereich</div>
                    <!-- <div class="external">open_in_new</div> -->
                </Link>
            </div>

            <div class="menu-group" v-if="user.can_access_customer_panel">
                <div class="group-label">Kundenbereich</div>
                <Link class="menu-item" :href="route('dashboard.customer.specs')" :class="{'active': is('dashboard.customer.specs')}">
                    <div class="icon" aria-hidden="true">cloud_done</div>
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
                <Link class="menu-item" :href="route('dashboard.employee.qm')" :class="{'active': is('dashboard.employee.qm')}">
                    <div class="icon" aria-hidden="true">workspace_premium</div>
                    <div class="text">Qualitätsmanagement</div>
                </Link>
                <a class="menu-item" v-if="user.can_access_admin_panel" target="_blank" :href="route('wiki')">
                    <div class="icon" aria-hidden="true">travel_explore</div>
                    <div class="text">Firmenwiki</div>
                    <div class="external">open_in_new</div>
                </a>
                <a class="menu-item" target="_blank" :href="route('docs', 'organigramm')">
                    <div class="icon" aria-hidden="true">lan</div>
                    <div class="text">Organigramm</div>
                    <div class="external">open_in_new</div>
                </a>
                <a class="menu-item" target="_blank" :href="route('docs', 'leitbild')">
                    <div class="icon" aria-hidden="true">explore</div>
                    <div class="text">Leitbild</div>
                    <div class="external">open_in_new</div>
                </a>
                <a class="menu-item" target="_blank" href="https://fleischer-dienst.uweb2000.de">
                    <div class="icon" aria-hidden="true">school</div>
                    <div class="text">UWEB Schulungen</div>
                    <div class="external">open_in_new</div>
                </a>
                <a class="menu-item" target="_blank" href="https://fleischer-dienst.mitarbeiterangebote.de/login">
                    <div class="icon" aria-hidden="true">percent</div>
                    <div class="text">Mitarbeiterangebote</div>
                    <div class="external">open_in_new</div>
                </a>
            </div>
        </div>

        <main class="content">
            <slot />
        </main>
    </div>

    <Footer/>
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
                box-shadow: var(--shadow-elevation-low)

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
                gap: 2px

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
            padding-block: 1rem
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
</style>