<template>
    <Head>
        <!-- Favicon -->
        <link v-if="favicon" rel="apple-touch-icon" :href="favicon">
        <link v-if="favicon" rel="icon" :href="favicon">
        <link v-if="favicon" rel="shortcut icon" :href="favicon">
    </Head>

    <Header :menu="mainMenu.content ?? null" login-link="/login" height="4.5rem"/>
    <slot />
    <Footer />
</template>

<script setup>
    import { Head, usePage } from '@inertiajs/inertia-vue3'
    import { ref, computed } from 'vue'

    import Header from '@/Pages/Apps/Pages/Sections/Header.vue'
    import Footer from '@/Pages/Apps/Pages/Sections/Footer.vue'


    
    const settings = computed(() => {
        return usePage().props.value.settings ?? {}
    })

    const favicon = computed(() => {
        return settings.value['design.favicon'] ?? null
    })

    const menus = computed(() => {
        return usePage().props.value.menus ?? []
    })

    const mainMenu = computed(() => {
        return menus.value.main ?? {}
    })
</script>

<style lang="sass">
    body
        font-family: var(--font-text)
        background: var(--color-background)
</style>