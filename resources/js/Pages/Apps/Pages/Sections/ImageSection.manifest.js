import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'
import Component from '@/Pages/Apps/Pages/Sections/ImageSection.vue'



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
            fixtureType: 'media:image',
            label: 'Bild',
            key: 'src',
            value: '',
        },
        {
            fixtureType: 'text',
            label: 'Alternativtext',
            key: 'alt',
            value: '',
        },
        {
            fixtureType: 'style:unit',
            label: 'Höhe',
            key: 'height',
            value: '300px',
        },
        {
            fixtureType: 'select',
            options: [
                { label: 'Fill', value: 'fill', },
                { label: 'Contain', value: 'contain', },
                { label: 'Cover', value: 'cover', },
                { label: 'None', value: 'none', },
                { label: 'Scale Down', value: 'scale-down', },
            ],
            label: 'Object Fit',
            key: 'objectFit',
            value: 'contain',
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
            value: 'var(--color-background-soft)',
        },
    ],
    component: Component,
}