<template>
    <header id="header">
        <div class="limiter">
            <Link id="header-logo" :href="route('home')" title="FDBS Home"><Logo /></Link>
            <Menu id="menu" />
            <div class="spacer"></div>
            <Link class="login-button" v-if="$page.props.auth.user" :href="route('dashboard')">{{$page.props.auth.user.name || $page.props.auth.user.email}}</Link>
            <Link class="login-button" v-else :href="route('login')">Kundenbereich</Link>
        </div>
    </header>
</template>

<script setup>
    import Logo from '@/Components/Branding/Logo.vue'
    import Menu from '@/Components/Page/Menu.vue'
    import { Link } from '@inertiajs/inertia-vue3'
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
            border: none
            height: 2.5rem
            padding-inline: 1rem
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
                    margin-inline: 0 var(--su)
                    color: var(--color-primary)
                    background: transparent
                    border-radius: 0
</style>