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
            language: '*',
            priority: 0.5,
            version: null,
            content: [],
            meta: {
                image: null,
                description: null,
            },
            parent_id: null,
            strict_permissions: false,
            require_auth: false,
            require_verification: false,
            users: [],
            roles: [],
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
            settings: {
                panel: 'general'
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

    removeElements(elements)
    {
        // Get element ids
        let elementIds = elements.map(element => element.localId)

        // Remove elements from data
        this.data.content = this.data.content.filter(item => !elementIds.includes(item.localId))

        // Remove elements from selected elements
        this.selected.elements = this.selected.elements.filter(item => !elementIds.includes(item))
    }



    selectElement(element)
    {
        this.selected.elements = [element.localId]
    }



    get selectedElements()
    {
        return this.data.content.filter(element => this.selected.elements.includes(element.localId))
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

    async prefetchData()
    {
        try
        {
            let data = await axios.get(route('app.pages.prefetch', { data: this.dataNeedingPrefetch }))
            
            this.prefetchedData = data.data
        }
        catch (error)
        {
            throw error
        }
    }



    hydrate(data) {
        this.data.id = data.id
        this.data.renderer = data.renderer || 'block-builder'
        this.data.title = data.title || 'Untitled'
        this.data.slug = data.slug || ''
        this.data.status = data.status || 'draft'
        this.data.language = data.language || '*'
        this.data.priority = data.priority || 0.5
        this.data.content = data.content || []
        this.data.meta = {
            image: data.meta?.image || null,
            description: data.meta?.description || null,
        }
        this.data.parent_id = data.parent_id || null
        this.data.strict_permissions = data.strict_permissions || false
        this.data.require_auth = data.require_auth || false
        this.data.require_verification = data.require_verification || false
        this.data.users = data.users || []
        this.data.roles = data.roles || []

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
            language: this.data.language,
            priority: this.data.priority,
            version: this.data.version,
            content: this.data.content,
            meta: this.data.meta,
            parent_id: this.data.parent_id,
            strict_permissions: this.data.strict_permissions,
            require_auth: this.data.require_auth,
            require_verification: this.data.require_verification,
            users: this.data.users,
            roles: this.data.roles,
        }))
    }

    async save()
    {
        // Check if we are already saving
        if (this.processing.saving) return
        


        this.processing.saving = true

        console.log(this.serialize())
        
        await useForm(this.serialize()).put('/admin/pages/pages/'+this.data.id, {
            preserveScroll: true,
        })

        // Sleep for 200ms to signalize something is happening
        await new Promise(r => setTimeout(r, 200))

        this.processing.saving = false
    }
}