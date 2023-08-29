<template>
    <Head :title="title" />

    <main>
        <template v-for="section in data.sections">
            <component :is="Sections[section.type].component" v-bind="section.props" />
        </template>
    </main>
</template>

<script setup>
    import { Head } from '@inertiajs/inertia-vue3'
    import { ref } from 'vue'

    import Sections from '@/Pages/Apps/Pages/Sections.js'



    defineProps({
        title: String,
        content: Array,
    })

    const data = ref({
        sections: [
            {
                type: 'hero-section',
                props: {
                    title: 'Test Page',
                    size: 'page-width',
                },
            },
            {
                type: 'text-section',
                props: {
                    content: '<p>This is a <b>test</b> page.</p>',
                    size: 'text-limiter',
                },
            },
            {
                type: 'download-manager-section',
                props: {
                    mediaId: '11266',
                    size: 'text-limiter',
                },
            },
        ]
    })
</script>

<style lang="sass" scoped>
</style>