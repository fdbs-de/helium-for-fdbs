import Component from '@/Pages/Apps/Pages/Partials/Limiter.vue'



export default {
    version: '1.0.0',
    name: 'Limiter',
    description: 'Page vertical limiter.',
    previewImage: null,
    group: 'partials',
    props: [
        {
            fixtureType: 'select',
            options: [
                {
                    label: 'Seitenbreite',
                    value: 'page-width',
                },
                {
                    label: 'Limiter',
                    value: 'limiter',
                },
                {
                    label: 'Text Limiter',
                    value: 'text-limiter',
                },
            ],
            label: 'Limiter Größe',
            key: 'size',
            value: 'limiter',
        },
    ],
    component: Component,
}