import Component from '@/Pages/Apps/Pages/Sections/CodeSection.vue'



export default {
    version: '1.0.0',
    type: 'code-section',
    name: 'Code Section',
    description: 'Fügt einen Quellcode-Abschnitt hinzu',
    previewImage: '/images/app/apps/pages/sections/code_section.svg',
    group: 'sections',
    props: [
        {
            fixtureType: 'code',
            label: 'HTML Code',
            key: 'content',
            value: '',
        },
        {
            fixtureType: 'style:padding',
            label: 'Innenabstand',
            key: 'padding',
            value: '0rem',
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