<template>
    <Head>
        <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
        <title>{{title || 'Loginbereich'}} – FDBS Loginbereich</title>
    </Head>

    <Header :menu="menu" loginLink="/dashboard/profile"/>

    <main>
        <slot />
    </main>

    <Footer/>
</template>

<script setup>
    import { Head, Link, usePage } from '@inertiajs/inertia-vue3'
    import { computed } from 'vue'
    
    import Header from '@/Pages/Apps/Pages/Sections/Header.vue'
    import Footer from '@/Pages/Apps/Pages/Sections/Footer.vue'



    defineProps({
        title: String,
    })



    const menu = computed(() => {
        let result = []

        result.push({ href: '/dashboard/home', title: 'Übersicht' })
        if (user.value.access.employee) result.push({ href: '/dashboard/intranet/news', title: 'News' })
        if (user.value.access.customer) result.push({ href: '/dashboard/kunden/angebote', title: 'Angebote' })
        if (user.value.access.employee) result.push({ href: '/wiki', title: 'Firmenwiki' })
        if (user.value.access.employee) result.push({ href: '/dashboard/intranet/dokumente', title: 'Dokumente' })
        if (user.value.access.customer) result.push({ href: '/dashboard/kunden/spezifikationen', title: 'Spezifikationen' })
        
        return result
    })



    const user = computed(() =>{
        return usePage().props.value.auth.user
    })
</script>

<style lang="sass" scoped>
</style>