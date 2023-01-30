import { randomInt } from '@/Utils/Number'

export default class Tab
{
    constructor (type, data = {})
    {
        this.id = randomInt(10000000, 99999999)
        this.active = false

        this.version = data.version || '0.0.1'
        this.title = data.title || ''
        this.type = type
        this.url = data.url || null
        this.history = data.history || []
        this.elements = data.elements || []

        this.selected = {
            breakpoint: 0,
            elements: [],
        }
    }



    get icon ()
    {
        if (this.type == 'page-editor') return 'language'
        if (this.type == 'component-editor') return 'widgets'
        if (this.type == 'new-tab') return 'layers'
        if (this.type == 'home') return 'home'

        return 'help'
    }

    get hasUnsavedChanges ()
    {
        return this.history.length > 0
    }



    selectBreakpoint (breakpoint)
    {
        this.selected.breakpoint = breakpoint
    }

    useAs (type, data)
    {
        this.type = type
        this.loadData(data)
    }

    loadData (data)
    {
        this.version = data.version || '0.0.1'
        this.title = data.title || ''
        this.url = data.url || null
        this.history = data.history || []
        this.elements = data.elements || []
    }
}