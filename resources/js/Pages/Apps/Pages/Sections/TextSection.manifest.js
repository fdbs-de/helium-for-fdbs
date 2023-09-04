import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'
import Component from '@/Pages/Apps/Pages/Sections/TextSection.vue'



export default {
    version: '1.0.0',
    name: 'Richtext Section',
    description: 'Fügt einen Abschnitt mit einem Rich Text Editor hinzu',
    previewImage: '/images/app/apps/pages/sections/text_section.svg',
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
            value: '',
        },
        {
            fixtureType: 'style:color',
            label: 'Textfarbe',
            key: 'color',
            value: '',
        },
    ],
    component: Component,
}