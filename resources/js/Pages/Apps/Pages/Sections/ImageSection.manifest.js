import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'
import Component from '@/Pages/Apps/Pages/Sections/ImageSection.vue'



export default {
    version: '1.0.0',
    type: 'image-section',
    name: 'Image',
    description: 'Fügt einen Abschnitt mit einem Bild hinzu',
    previewImage: '/images/app/apps/pages/sections/image_section.svg',
    group: 'Basics',
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
            fixtureType: 'url',
            label: 'Link',
            key: 'link',
            value: '',
        },
        {
            fixtureType: 'style:unit',
            label: 'Höhe',
            key: 'height',
            value: '',
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
            value: 'cover',
        },
        {
            fixtureType: 'style:padding',
            label: 'Innenabstand',
            key: 'padding',
            value: '0rem 0rem',
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