<template>
    <Head>
        <title>{{ title }}</title>
        
        <meta name="description" content="Test 1234">
    </Head>

    <main>
        <BlockBuilderCollector :elements="content" />
    </main>
</template>

<script setup>
    import { Head } from '@inertiajs/inertia-vue3'

    import BlockBuilderCollector from '@/Pages/Apps/Pages/Renderer/BlockBuilderCollector.vue'



    defineProps({
        title: String,
        content: Array,
    })
</script>

<style lang="sass" scoped>
</style>