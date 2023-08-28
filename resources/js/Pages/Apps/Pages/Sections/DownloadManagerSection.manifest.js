import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'
import DownloadManagerManifest from '@/Pages/Apps/Pages/Partials/DownloadManager.manifest.js'
import Component from '@/Pages/Apps/Pages/Sections/DownloadManagerSection.vue'



export default {
    version: '1.0.0',
    name: 'Download Section',
    description: 'A hero section.',
    previewImage: null,
    group: 'sections',
    props: [
        ...LimiterManifest.props,
        ...DownloadManagerManifest.props,
    ],
    component: Component,
}