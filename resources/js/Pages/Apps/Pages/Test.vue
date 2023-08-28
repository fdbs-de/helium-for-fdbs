<template>
    <Head :title="data.title" />

    <main>
        <template v-for="section in data.sections">
            <HeroSection v-if="section.type === 'hero'" :size="section.props.size" :title="section.props.title" :title-color="section.props.titleColor"/>
            <TextSection v-if="section.type === 'text'" :size="section.props.size" :content="section.props.content"/>
            <DownloadManagerSection v-if="section.type === 'download-manager'" :size="section.props.size" :media-id="section.props.mediaId"/>
        </template>
    </main>
</template>

<script setup>
    import { Head } from '@inertiajs/inertia-vue3'
    import { ref } from 'vue'

    import TextSectionManifest from '@/Pages/Apps/Pages/Sections/TextSection.manifest.js'
    import HeroSectionManifest from '@/Pages/Apps/Pages/Sections/HeroSection.manifest.js'
    import DownloadManagerSectionManifest from './Sections/DownloadManagerSection.manifest'

    

    const data = ref({
        title: 'Test Page',
        sections: [
            {
                type: 'hero',
                props: {
                    title: 'Test Page',
                    titleColor: 'white',
                    size: 'page-width',
                },
            },
            {
                type: 'text',
                props: {
                    content: '<p>This is a <b>test</b> page.</p>',
                    size: 'text-limiter',
                },
            },
            {
                type: 'download-manager',
                props: {
                    mediaId: '11266',
                    size: 'text-limiter',
                },
            },
        ]
    })



    let TextSection = TextSectionManifest.component
    let HeroSection = HeroSectionManifest.component
    let DownloadManagerSection = DownloadManagerSectionManifest.component
</script>

<style lang="sass" scoped>
</style>