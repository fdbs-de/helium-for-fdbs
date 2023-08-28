import Component from '@/Pages/Apps/Pages/Partials/DownloadManager.vue'



export default {
    version: '1.0.0',
    name: 'Download Manager',
    description: 'A display of all downloadable files in a folder.',
    previewImage: null,
    group: 'partials',
    props: [
        {
            fixtureType: 'media:folder',
            label: 'Ordner',
            key: 'mediaId',
            value: null,
        },
    ],
    component: Component,
}