<template>
    <Header />
    <slot />
    <Footer />
</template>

<script setup>
    import Header from '@/Components/Page/Header.vue'
    import Footer from '@/Components/Page/Footer.vue'
</script>