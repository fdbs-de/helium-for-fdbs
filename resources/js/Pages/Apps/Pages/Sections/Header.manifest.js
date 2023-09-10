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
            fixtureType: 'menus:id',
            label: 'Menü',
            key: 'menuId',
            value: '',
            prefetch: true,
        },
        {
            fixtureType: 'url',
            label: 'Login Link',
            key: 'loginLink',
            value: '',
        },
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