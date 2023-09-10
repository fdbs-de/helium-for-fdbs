<template>
    <header id="header" :style="{ height, backgroundColor, color }">
        <div class="limiter">
            <div class="wrapper start">
                <Link id="header-logo" href="/" title="Home">
                    <img class="logo-asset" :src="settings['design.logos.color']" :alt="settings['site.name'] +' Logo'">
                </Link>
            </div>
            <div class="wrapper center">
                <Menu id="menu" :menu="menu"/>
            </div>
            <div class="wrapper end" v-if="loginLink">
                <IodButton is="a" :href="loginLink" variant="filled" size="small">Anmelden</IodButton>
            </div>
        </div>
    </header>
</template>

<script setup>
    import { ref, computed } from 'vue'
    import { Link, usePage } from '@inertiajs/inertia-vue3'
    
    import Menu from '@/Pages/Apps/Pages/Partials/Menu/Menu.vue'



    const props = defineProps({
        menuId: String,
        menu: Array,
        loginLink: String,
        height: String,
        backgroundColor: String,
        color: String,
        prefetchedData: Object,
    })



    const menu = computed(() => {
        return props.menu || props.prefetchedData?.menus?.find(menu => menu.id == props.menuId)?.content || []
    })



    const settings = computed(() => {
        return usePage()?.props?.value?.settings
    })
</script>

<style lang="sass" scoped>
    #header
        position: sticky
        top: 0
        left: 0
        z-index: 1000
        width: 100%
        height: 4rem
        background-color: #ffffffd9
        color: var(--color-text)
        backdrop-filter: blur(20px)
        border-bottom: 1px solid #ffffff99
        box-sizing: border-box

        *
            box-sizing: border-box
        
        .limiter
            display: flex
            align-items: center
            height: 100%
            max-width: 1200px

        .wrapper
            flex: 1
            height: 100%
            display: flex
            align-items: center
            justify-content: center
            flex-wrap: wrap

            &.start
                justify-content: flex-start

            &.center
                flex: none

            &.end
                justify-content: flex-end

        #header-logo
            display: flex
            height: 100%
            width: 100%
            padding-block: .25rem

            .logo-asset
                height: 100%
                width: 100%
                object-fit: contain
                object-position: center left

    @media only screen and (max-width: 1000px)
        #header
            .limiter
                gap: 1rem

                .wrapper.center
                    order: 1


    
    @media only screen and (max-width: 500px)
        #header
            .limiter
                .wrapper.logo
                    width: 100px
</style>