<template>
    <Head>
        <meta charset="utf-8">

        <template v-if="settings['design.favicon']">
            <link rel="icon" :href="settings['design.favicon']" type="image/x-icon">
            <link rel="shortcut icon" :href="settings['design.favicon']" type="image/x-icon">
        </template>

        <title v-if="settings['site.name']">{{ title }} – {{ settings['site.name'] }}</title>
        <title v-else>{{ title }}</title>
        
        <meta v-if="settings['site.description']" name="description" :content="settings['site.description']">
    </Head>

    <main>
        <BlockBuilderCollector :elements="content" />
    </main>
</template>

<script setup>
    import { Head, usePage } from '@inertiajs/inertia-vue3'
    import { computed } from 'vue'

    import BlockBuilderCollector from '@/Pages/Apps/Pages/Renderer/BlockBuilderCollector.vue'



    defineProps({
        title: String,
        content: Array,
    })

    const settings = computed(() => {
        return usePage()?.props?.value?.settings
    })
</script>

<style lang="sass" scoped>
</style>