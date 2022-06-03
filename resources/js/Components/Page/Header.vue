<template>
    <header id="header">
        <div class="limiter">
            <Link id="header-logo" href="/" title="FDBS Home"><Logo /></Link>
            <Menu />
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

        #header-logo
            height: var(--height-header)
</style>