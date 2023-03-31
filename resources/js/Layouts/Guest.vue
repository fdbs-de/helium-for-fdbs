<template>
    <Head>
        <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    </Head>

    <Header :menu="menu"/>
    <slot />
    <Footer />
</template>

<script setup>
    import { Head, usePage } from '@inertiajs/inertia-vue3'
    import { ref, computed } from 'vue'

    import Header from '@/Components/Page/Header.vue'
    import Footer from '@/Components/Page/Footer.vue'
    import { mainMenu } from '@/menus'

    const menu = ref(mainMenu)

    const globalSettings = computed(() => {
        return usePage().props.value.settings ?? {}
    })
</script>

<style lang="sass">
    body
        font-family: var(--font-text)
        background: var(--color-background)
</style>