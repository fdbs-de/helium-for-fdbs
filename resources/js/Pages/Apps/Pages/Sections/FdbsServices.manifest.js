import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'
import Component from '@/Pages/Apps/Pages/Sections/FdbsServices.vue'



export default {
    version: '1.0.0',
    name: 'FDBS Services',
    description: 'FDBS spezifische Services Section',
    previewImage: '/images/app/apps/pages/sections/blank.svg',
    type: 'fdbs-services',
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