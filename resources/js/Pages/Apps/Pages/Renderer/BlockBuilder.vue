<template>
    <Head :title="title" />

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