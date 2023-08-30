import Tab from '@/Classes/Editor/Tab'



export default class PageTab extends Tab
{
    constructor (options = null)
    {
        super()

        // Set tab type
        this.type = 'pages'
        this.title = 'Pages'
        
        // Tab specific data
        this.data = {
            id: null,
            renderer: 'block-builder',
            title: 'Untitled',
            slug: '',
            status: 'draft',
            version: null,
            content: [],
            meta: {},
        }
        
        // Edit history
        this.history = []

        // Processing variables
        this.processing = {
            saving: false,
        }

        // Selected variables
        this.selected = {
            breakpoint: 0,
            elements: [],
        }

        // UI variables
        this.ui = {
            inspector: {
                panel: 'element'
            },
            navigator: {
                panel: 'elements'
            },
        }

        // Set available breakpoints
        this.breakpoints = [
            {
                id: 0,
                name: 'Desktop',
                tooltip: '<b>Desktop</b><br>\> 1100px',
                icon: 'monitor',
                width: null,
                height: null,
                orientation: 'landscape',
                default: true,
                touch: false,
            },
            {
                id: 1,
                name: 'Laptop',
                tooltip: '<b>Laptop</b><br>< 1100px',
                icon: 'computer',
                width: 1100,
                height: null,
                orientation: 'landscape',
                default: false,
                touch: false,
            },
            {
                id: 2,
                name: 'Tablet',
                tooltip: '<b>Tablet</b><br>< 900px',
                icon: 'tablet_android',
                width: 900,
                height: null,
                orientation: 'portrait',
                default: false,
                touch: true,
            },
            {
                id: 3,
                name: 'Mobile Landscape',
                tooltip: '<b>Mobile Landscape</b><br>< 700px',
                icon: 'stay_current_landscape',
                width: 700,
                height: null,
                orientation: 'landscape',
                default: false,
                touch: true,
            },
            {
                id: 4,
                name: 'Mobile Portrait',
                tooltip: '<b>Mobile Portrait</b><br>< 360px',
                icon: 'stay_current_portrait',
                width: 360,
                height: null,
                orientation: 'portrait',
                default: false,
                touch: true,
            }
        ]

        return this
    }



    get icon ()
    {
        return 'web'
    }



    selectBreakpoint(index)
    {
        // Check if index is in range
        if (index < 0 || index >= this.breakpoints.length) return false
        
        // Set breakpoint
        this.selected.breakpoint = index
        
        return true
    }

    get breakpoint()
    {
        return (
            this.breakpoints[this.selected.breakpoint] ||
            this.breakpoints.find(breakpoint => breakpoint.default) ||
            null
        )
    }



    createElement(elementTemplate = {}) {
        let data = {
            localId: this.generateLocalId(),
        }

        data.type = elementTemplate.type

        this.addElement(data)
    }

    addElement(element) {
        this.data.content.push(element)
    }



    hydrate(data) {
        this.data.id = data.id
        this.data.renderer = data.renderer
        this.data.title = data.title
        this.data.slug = data.slug
        this.data.status = data.status
        this.data.content = data.content
        this.data.meta = {}

        return this
    }

    serialize()
    {
        return {
            id: this.data.id,
            renderer: this.data.renderer,
            title: this.data.title,
            slug: this.data.slug,
            status: this.data.status,
            version: this.data.version,
            content: this.data.content,
        }
    }
}