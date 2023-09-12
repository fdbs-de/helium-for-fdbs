import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'
import Component from '@/Pages/Apps/Pages/Sections/FdbsMarken.vue'



export default {
    version: '1.0.0',
    name: 'FDBS Marken',
    description: 'FDBS spezifische Marken Section',
    previewImage: '/images/app/apps/pages/sections/hero_section.svg',
    type: 'fdbs-marken',
    group: 'fdbs',
    props: [
        ...LimiterManifest.props,
        {
            fixtureType: 'style:padding',
            label: 'Innenabstand',
            key: 'padding',
            value: '10rem 0rem',
        },
        {
            fixtureType: 'style:color',
            label: 'Hintergrundfarbe',
            key: 'backgroundColor',
            value: '',
        },
    ],
    component: Component,
}