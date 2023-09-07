import Component from '@/Pages/Apps/Pages/Sections/Footer.vue'



export default {
    version: '1.0.0',
    name: 'Footer',
    description: 'Fügt einen Footer hinzu',
    previewImage: '/images/app/apps/pages/sections/footer.svg',
    type: 'footer',
    group: 'footer',
    props: [
        {
            fixtureType: 'style:color',
            label: 'Hintergrundfarbe',
            key: 'backgroundColor',
            value: 'var(--color-background-soft)',
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