import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'
import DownloadManagerManifest from '@/Pages/Apps/Pages/Partials/DownloadManager.manifest.js'
import Component from '@/Pages/Apps/Pages/Sections/DownloadManagerSection.vue'



export default {
    version: '1.0.0',
    name: 'Download Section',
    description: 'Fügt einen Abschnitt mit einem Download-Ordner-Ansicht hinzu',
    previewImage: '/images/app/apps/pages/sections/download_manager_section.svg',
    type: 'download-manager-section',
    group: 'sections',
    props: [
        ...LimiterManifest.props,
        ...DownloadManagerManifest.props,
        {
            fixtureType: 'style:padding',
            label: 'Innenabstand',
            key: 'padding',
            value: '4rem 0rem',
        },
        {
            fixtureType: 'style:color',
            label: 'Hintergrundfarbe',
            key: 'backgroundColor',
            value: 'var(--color-background-soft)',
        },
    ],
    component: Component,
}