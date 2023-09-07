import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'
import Component from '@/Pages/Apps/Pages/Sections/HeroSection.vue'



export default {
    version: '1.0.0',
    name: 'Hero',
    description: 'Fügt einen Abschnitt mit einer Seiten-Überschrift hinzu',
    previewImage: '/images/app/apps/pages/sections/hero_section.svg',
    type: 'hero-section',
    group: 'sections',
    props: [
        ...LimiterManifest.props,
        {
            fixtureType: 'select',
            options: [
                { label: 'h1', value: 'H1', },
                { label: 'h2', value: 'H2', },
                { label: 'h3', value: 'H3', },
                { label: 'h4', value: 'H4', },
                { label: 'h5', value: 'H5', },
                { label: 'h6', value: 'H6', },
                { label: 'p', value: 'Paragraph',}
            ],
            label: 'Titel Tag',
            key: 'titleTag',
            value: 'h1',
        },
        {
            fixtureType: 'toggle:switch',
            label: 'Als "Card" darstellen',
            key: 'isCard',
            value: true,
        },
        {
            fixtureType: 'text',
            label: 'Titel',
            key: 'title',
            value: 'Hero-Section',
        },
        {
            fixtureType: 'style:unit',
            label: 'Höhe',
            key: 'height',
            value: '300px',
        },
        {
            fixtureType: 'style:padding',
            label: 'Innenabstand',
            key: 'padding',
            value: '',
        },
        {
            fixtureType: 'style:unit',
            label: 'Border Radius',
            key: 'borderRadius',
            value: '.75rem',
        },
        {
            fixtureType: 'style:color',
            label: 'Hintergrundfarbe',
            key: 'backgroundColor',
            value: 'var(--color-background-soft)',
        },
        {
            fixtureType: 'media:image',
            label: 'Bild',
            key: 'backgroundImage',
            value: '',
        },
        {
            fixtureType: 'style:color',
            label: 'Textfarbe',
            key: 'color',
            value: 'var(--color-primary)',
        },
        {
            fixtureType: 'select',
            options: [
                { label: 'Links', value: 'left', },
                { label: 'Mittig', value: 'center', },
                { label: 'Rechts', value: 'right', },
            ],
            label: 'Textausrichtung',
            key: 'textAlign',
            value: 'center',
        },
    ],
    component: Component,
}