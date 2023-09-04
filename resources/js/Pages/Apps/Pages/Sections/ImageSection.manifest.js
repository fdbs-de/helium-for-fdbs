import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'
import Component from '@/Pages/Apps/Pages/Sections/TextSection.vue'



export default {
    version: '1.0.0',
    type: 'image-section',
    name: 'Image Section',
    description: 'Fügt einen Abschnitt mit einem Bild hinzu',
    previewImage: '/images/app/apps/pages/sections/image_section.svg',
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