import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'
import Component from '@/Pages/Apps/Pages/Sections/FormSection.vue'



export default {
    version: '1.0.0',
    name: 'Formular',
    type: 'form-section',
    description: 'Fügt ein Formular hinzu',
    previewImage: '/images/app/apps/pages/sections/form_section.svg',
    group: 'sections',
    props: [
        ...LimiterManifest.props,
        {
            fixtureType: 'forms:id',
            label: 'Form Id',
            key: 'formId',
            value: '',
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
            value: '',
        },
    ],
    component: Component,
}