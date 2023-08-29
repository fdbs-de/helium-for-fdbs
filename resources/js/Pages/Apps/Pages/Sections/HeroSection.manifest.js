import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'
import Component from '@/Pages/Apps/Pages/Sections/HeroSection.vue'



export default {
    version: '1.0.0',
    name: 'Hero Section',
    description: 'A hero section.',
    previewImage: null,
    type: 'hero-section',
    group: 'sections',
    props: [
        ...LimiterManifest.props,
        {
            fixtureType: 'text',
            label: 'Titel',
            key: 'title',
            value: 'Hero-Section',
        },
        {
            fixtureType: 'color',
            label: 'Titel Farbe',
            key: 'titleColor',
            value: 'var(--color-primary)',
        },
        {
            fixtureType: 'image',
            label: 'Bild',
            key: 'image',
            value: '',
        },
    ],
    component: Component,
}