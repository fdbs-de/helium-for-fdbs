import { randomInt } from '@/Utils/Number'
import Element from '@/Classes/Apps/Pages/Element.js'

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

    get flatElementList ()
    {
        let elements = {}

        function flatten (element, breadcrumbs)
        {
            element.breadcrumbs = [...breadcrumbs]
            elements[element.elementId] = element

            element.inner.forEach(e => flatten(e, [...breadcrumbs, element.elementId]))
        }

        this.elements.forEach(e => flatten(e, [null]))

        return elements
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



    addElement (element)
    {
        // Add inner element
        if (this.selected.elements.length === 1)
        {
            let selectedElement = this.flatElementList[this.selected.elements[0]]

            if (!selectedElement) return this

            this._addElement(selectedElement, element)

            return this
        }

        // Add root element
        this.elements.push(element)

        return this
    }

    _addElement (targetElement, insertElement)
    {
        // Try to add element to target element if possible
        if (targetElement.allowedInner.includes(insertElement.elementType))
        {
            targetElement.addElement(insertElement)

            return true
        }


        
        // Find parent element id
        let parentId = targetElement.breadcrumbs[targetElement.breadcrumbs.length - 1]

        // Return if no parent element id
        if (!parentId) return false

        // Get parent element
        let parentElement = this.flatElementList[parentId]

        // Return if no parent element
        if (!parentElement) return false

        // Add insert element to parent
        return this._addElement(parentElement, insertElement)
    }



    removeElement (elementId)
    {
        this.elements = this.elements.filter(e => e.elementId !== elementId)

        for (const element of this.elements)
        {
            this._removeElement(element, elementId)
        }

        return this
    }

    _removeElement (targetElement, elementId)
    {
        targetElement.inner = targetElement.inner.filter(e => e.elementId !== elementId)

        for (const element of targetElement.inner)
        {
            this._removeElement(element, elementId)
        }
    }



    setElementSelection (element)
    {
        this.selected.elements = [element.elementId]
    }
}