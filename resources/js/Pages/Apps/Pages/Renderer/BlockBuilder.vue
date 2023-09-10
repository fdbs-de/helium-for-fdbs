<template>
    <Head>
        <!-- Charset -->
        <meta charset="utf-8">

        <template v-if="meta.favicon">
            <!-- Favicon -->
            <link rel="apple-touch-icon" :href="meta.favicon">
            <link rel="icon" :href="meta.favicon" type="image/x-icon">
            <link rel="shortcut icon" :href="meta.favicon" type="image/x-icon">
        </template>

        <!-- Title -->
        <title v-if="settings['site.name']">{{ title }} – {{ settings['site.name'] }}</title>
        <title v-else>{{ title }}</title>
        
        <!-- Description -->
        <meta v-if="meta.description" name="description" :content="meta.description">

        <!-- Open Graph: Image -->
        <meta v-if="meta.image" property="og:image" :content="meta.image">
    </Head>

    <main>
        <BlockBuilderCollector :elements="content" :prefetched-data="prefetched_data"/>
    </main>
</template>

<script setup>
    import { onMounted } from 'vue'
    import { Head } from '@inertiajs/inertia-vue3'

    import BlockBuilderCollector from '@/Pages/Apps/Pages/Renderer/BlockBuilderCollector.vue'



    const props = defineProps({
        title: String,
        slug: String,
        content: Array,
        language: String,
        meta: Object,
        settings: Object,
        prefetched_data: Object,
    })

    onMounted(() => {
        let result = ''

        result += '<style type="text/css">'
        result += props.settings['design.fonts']
        result += ':root {'
        result += props.settings['design.colors']
        result += '}'
        result += '</style>'

        document.head.insertAdjacentHTML('beforeend', result)
    })
</script>