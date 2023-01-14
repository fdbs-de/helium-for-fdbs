<template>
    <Header :menu="menu"/>
    <slot />
    <Footer />
</template>

<script setup>
    import Header from '@/Components/Page/Header.vue'
    import Footer from '@/Components/Page/Footer.vue'
    import { ref } from 'vue'

    const menu = ref([])
</script>