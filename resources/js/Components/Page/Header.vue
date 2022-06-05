<template>
    <header id="header">
        <div class="limiter">
            <Link id="header-logo" href="/" title="FDBS Home"><Logo /></Link>
            <Menu id="menu" />
            <div class="spacer"></div>
            <mui-button label="Kundenbereich" icon-left="account_circle"/>
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
</style>