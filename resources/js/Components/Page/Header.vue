<template>
    <header id="header">
        <div class="limiter">
            <div class="wrapper logo">
                <Link id="header-logo" :href="route('home')" title="FDBS Home"><Logo /></Link>
            </div>
            <div class="wrapper menu">
                <Menu id="menu" :menu="menu"/>
            </div>
            <div class="wrapper login">
                <Link class="login-button" :href="loggedIn ? route('dashboard') : route('login')" :title="displayText">{{displayText}}</Link>
            </div>
        </div>
    </header>
</template>

<script setup>
    import Logo from '@/Components/Logo.vue'
    import Menu from '@/Components/Page/Menu.vue'
    import { Link, usePage } from '@inertiajs/inertia-vue3'
    import { computed } from 'vue'



    defineProps({
        menu: Array,
    })

    const loggedIn = computed(() => {
        return !!usePage().props.value.auth.user
    })

    const displayText = computed(() => {
        return loggedIn.value ? 'Profil' : 'Anmelden'
    })
</script>

<style lang="sass" scoped>
    #header
        position: fixed
        top: 0
        left: 0
        z-index: 1000
        width: 100%
        height: var(--height-header)
        background-color: #ffffffd9
        backdrop-filter: blur(20px)
        border-bottom: 1px solid #ffffff99
        
        .limiter
            display: flex
            align-items: center

        .wrapper
            flex: 1
            display: flex
            align-items: center
            justify-content: center

            &.logo
                flex: none
                width: 140px
                justify-content: flex-start

            &.login
                flex: none
                width: 140px
                justify-content: flex-end

        #header-logo
            display: flex
            height: var(--height-header)
            padding-block: .5rem
            aspect-ratio: 2/1

        .login-button
            display: inline-flex
            align-items: center
            justify-content: center
            border: none
            height: 2.25rem
            padding-inline: 1.5rem
            border-radius: var(--radius-m)
            background: var(--color-primary)
            color: var(--color-background)
            font-family: inherit
            line-height: 1
            font-size: .8rem
            font-weight: 600
            letter-spacing: .05rem
            text-transform: uppercase
            cursor: pointer
            white-space: nowrap
            overflow: hidden
            text-overflow: ellipsis

            &:focus,
            &:hover
                background-color: var(--color-primary-soft)

    @media only screen and (max-width: 1000px)
        #header
            .limiter
                gap: 1rem

                > .wrapper.menu
                    order: 1
                    flex: none
                    padding: 0

                .wrapper.login
                    flex: 1
                    width: auto


    
    @media only screen and (max-width: 500px)
        #header
            .limiter
                .wrapper.logo
                    width: 100px
</style>