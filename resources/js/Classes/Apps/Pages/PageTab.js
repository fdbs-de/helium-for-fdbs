import { applyDrag } from '@/Utils/DragAndDrop'
import Tab from '@/Classes/Editor/Tab'
import { useForm } from '@inertiajs/inertia-vue3'



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

        this.prefetchedData = {}
        
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
            navigator: {
                panel: 'navigator'
            },
            inspector: {
                panel: 'inspector'
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

        this.globalData = {
            colorPalettes: {
                default: [
                    [ '#ff4757', '#ff6348', '#ffa502', '#2ed573', '#1e90ff', '#3742fa', '#8e44ad', '#9b59b6', ],
                    [ '#eb3b5a', '#fa8231', '#f7b731', '#20bf6b', '#0fb9b1', '#2d98da', '#3867d6', '#8854d0', ],
                    [ '#ffffff', '#ECEFF1', '#B0BEC5', '#90A4AE', '#607D8B', '#455A64', '#263238', '#000000', ],
                ],
            },
        }

        return this
    }



    get icon ()
    {
        return 'web'
    }

    get color ()
    {
        switch (this.data.status)
        {
            case 'draft': return '#f39c12'
            case 'published': return '#2ecc71'
            case 'hidden': return '#e74c3c'
            default: return 'white'
        }
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



    createElement(elementTemplate = {}, selectAfterAdd = true)
    {
        let data = {
            localId: this.generateLocalId(),
            name: elementTemplate?.name || 'New Element',
            type: elementTemplate?.type,
            props: elementTemplate?.props || [],
            children: elementTemplate?.children || [],
        }



        this.addElement(data)
        
        if (selectAfterAdd) this.selectElement(data)
    }

    addElement(element)
    {
        this.data.content.push(element)
    }

    dropElement(dropResults)
    {
        this.data.content = applyDrag(this.data.content, dropResults)
    }

    updateElement(element)
    {
        this.data.content = this.data.content.map(item => {
            if (item.localId === element.localId) return element
            return item
        })
    }

    removeElement(element)
    {
        this.data.content = this.data.content.filter(item => item.localId !== element.localId)

        // Remove element from selected elements
        this.selected.elements = this.selected.elements.filter(item => item !== element.localId)
    }



    selectElement(element)
    {
        this.selected.elements = [element.localId]
    }



    get dataNeedingPrefetch()
    {
        // Get the values of the props that need prefetching
        let propsNeedingPrefetchFromData = this.data.content
            .map(element => element.props)
            .flat()
            .filter(prop => prop.prefetch)
            .map(prop => [prop.fixtureType, prop.value])

        // Group by key
        let propsNeedingPrefetchFromDataGrouped = propsNeedingPrefetchFromData.reduce((r, a) => {
            r[a[0]] = [...r[a[0]] || [], a[1]]
            return r
        }, {})

        return propsNeedingPrefetchFromDataGrouped
    }



    hydrate(data) {
        this.data.id = data.id
        this.data.renderer = data.renderer || 'block-builder'
        this.data.title = data.title || 'Untitled'
        this.data.slug = data.slug || ''
        this.data.status = data.status || 'draft'
        this.data.content = data.content || []
        this.data.meta = {}

        return this
    }

    serialize()
    {
        return JSON.parse(JSON.stringify({
            id: this.data.id,
            renderer: this.data.renderer,
            title: this.data.title,
            slug: this.data.slug,
            status: this.data.status,
            version: this.data.version,
            content: this.data.content,
        }))
    }

    async save()
    {
        if (this.processing.saving) return
        


        this.processing.saving = true
        
        await useForm(this.serialize()).put('/admin/pages/pages/'+this.data.id, {
            preserveScroll: true,
        })

        // Sleep for 200ms to signalize something is happening
        await new Promise(r => setTimeout(r, 200))

        this.processing.saving = false
    }
}