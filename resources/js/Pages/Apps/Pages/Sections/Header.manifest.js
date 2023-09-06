import Component from '@/Pages/Apps/Pages/Sections/Header.vue'



export default {
    version: '1.0.0',
    name: 'Header',
    description: 'Fügt einen Header hinzu',
    previewImage: '/images/app/apps/pages/sections/header.svg',
    type: 'header',
    group: 'header',
    props: [
        {
            fixtureType: 'style:unit',
            label: 'Höhe',
            key: 'height',
            value: '4rem',
        },
        {
            fixtureType: 'style:color',
            label: 'Hintergrundfarbe',
            key: 'backgroundColor',
            value: '#ffffffd9',
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