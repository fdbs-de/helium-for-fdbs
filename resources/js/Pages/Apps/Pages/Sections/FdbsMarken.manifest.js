import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'
import Component from '@/Pages/Apps/Pages/Sections/FdbsMarken.vue'



export default {
    version: '1.0.0',
    name: 'FDBS Marken',
    description: 'FDBS spezifische Marken Section',
    previewImage: '/images/app/apps/pages/sections/blank.svg',
    type: 'fdbs-marken',
    group: 'FDBS Specific',
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