import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'
import Component from '@/Pages/Apps/Pages/Sections/TextSection.vue'



export default {
    version: '1.0.0',
    type: 'code-section',
    name: 'Code Section',
    description: 'Fügt einen Quellcode-Abschnitt hinzu',
    previewImage: '/images/app/apps/pages/sections/code_section.svg',
    group: 'sections',
    props: [
        ...LimiterManifest.props,
        {
            fixtureType: 'code',
            label: 'HTML Code',
            key: 'content',
            value: '',
        },
    ],
    component: Component,
}