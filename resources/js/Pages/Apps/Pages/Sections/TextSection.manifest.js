import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'
import Component from '@/Pages/Apps/Pages/Sections/TextSection.vue'



export default {
    version: '1.0.0',
    name: 'Text Section',
    description: 'A simple text section.',
    previewImage: null,
    type: 'text-section',
    group: 'sections',
    props: [
        ...LimiterManifest.props,
        {
            fixtureType: 'richtext',
            label: 'Inhalt',
            key: 'content',
            value: '<p>Inhalt</p>',
        },
    ],
    component: Component,
}