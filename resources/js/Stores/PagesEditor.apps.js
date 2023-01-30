import { defineStore } from 'pinia'

export const usePagesEditorStore = defineStore('pages-editor', {
    state: () => ({
        breakpoints: [
            {
                id: 0,
                name: 'Desktop',
                icon: 'desktop_windows',
                width: 1920,
                height: 1080,
                orientation: 'landscape',
                default: true,
                touch: false
            },
            {
                id: 1,
                name: 'Laptop',
                icon: 'computer',
                width: 912,
                height: 1024,
                orientation: 'landscape',
                touch: false
            },
            {
                id: 2,
                name: 'Mobile (Landscape)',
                icon: 'stay_current_landscape',
                width: 740,
                height: 360,
                orientation: 'landscape',
                touch: true
            },
            {
                id: 3,
                name: 'Mobile (Portrait)',
                icon: 'stay_current_portrait',
                width: 360,
                height: 740,
                orientation: 'portrait',
                touch: true
            }
        ],
        tabs: [
            {
                id: '1',
                version: '0.0.1',
                name: 'Startseite',
                type: 'page-editor',
                url: 'https://example.com/',
                history: [],
                elements: [
                    {
                        element_id: '1',
                        element_type: 'raw',
                        element_subtype: 'div',
                        name: 'Image Card',
                        id: 'element-1',
                        classes: 'card inner',
                        styles: {
                            '0': {
                                'display': 'flex',
                                'flex-direction': 'column',
                                'justify-content': 'center',
                                'align-items': 'center',
                                'gap': '1rem',
                                'raw': 'color: #fff;',
                            },
                            '1': {
                                'display': 'flex',
                                'flex-direction': 'column',
                                'justify-content': 'center',
                                'align-items': 'center',
                                'gap': '2rem',
                                'raw': 'color: #fff;',
                            }
                        },
                        allowed_inner: ['raw', 'text', 'component'],
                        inner: [],
                    }
                ],
                selected: {
                    breakpoint: 0,
                    elements: [],
                }
            }
        ],
        tab: null,
    }),
})