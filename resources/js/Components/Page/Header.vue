<template>
    <header id="header">
        <div class="limiter">
            <Link id="header-logo" :href="route('home')" title="FDBS Home"><Logo /></Link>
            <Menu id="menu" :menu="menu"/>

            <div class="spacer"></div>

            <Link class="login-button" :href="loggedIn ? route('dashboard') : route('login')" :title="displayText"><span>{{displayText}}</span></Link>
        </div>
    </header>
</template>

<script setup>
    import Logo from '@/Components/Branding/Logo.vue'
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
        return loggedIn.value ? (usePage().props.value.auth.user.name || usePage().props.value.auth.user.email) : 'Kundenbereich'
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

        .limiter
            height: 100%
            display: flex
            align-items: center
            gap: var(--su)

            .spacer
                flex: 1

        #menu
            padding-inline: var(--su)

        #header-logo
            height: var(--height-header)
            padding-block: .5rem
            aspect-ratio: 2/1

        .login-button
            display: flex
            align-items: center
            justify-content: center
            border: none
            height: 2.25rem
            width: 145px
            padding-inline: .65rem
            border-radius: calc(var(--su) * .5)
            background: var(--color-primary)
            color: var(--color-background)
            font-family: inherit
            line-height: 1
            font-size: .8rem
            font-weight: 500
            letter-spacing: .05rem
            text-transform: uppercase
            cursor: pointer

            &:focus,
            &:hover
                background-color: var(--color-primary-soft)

            > span
                justify-self: stretch
                white-space: nowrap
                overflow: hidden
                text-overflow: ellipsis
                text-align: center

    @media only screen and (max-width: 1000px)
        #header
            #menu
                order: 3
                padding: 0

    @media only screen and (max-width: 500px)
        #header
            .limiter
                gap: 0

                .login-button
                    padding: 0
                    margin-inline: 0 calc(var(--su) * .5)
                    color: var(--color-primary)
                    background: transparent
                    border-radius: 0
                    justify-content: flex-end

                    > span
                        text-align: right
</style>