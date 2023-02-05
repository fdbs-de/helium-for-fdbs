import { randomInt } from '@/Utils/Number'
import Element from '@/Classes/Apps/Pages/Element.js'

export default class Tab
{
    tabTypes = ['new-tab', 'page-editor', 'component-editor']

    constructor (type, data = {})
    {
        if (!this.tabTypes.includes(type)) throw new Error('Invalid tab type')

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

        this.ui = {
            newElementPanel: false,
        }
    }



    get icon ()
    {
        if (this.type == 'new-tab') return 'layers'
        if (this.type == 'page-editor') return 'language'
        if (this.type == 'component-editor') return 'widgets'

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



    get selectedElements ()
    {
        return this.selected.elements.map(id => this.flatElementList[id]).filter(e => e)
    }


    
    useAs (type, data)
    {
        if (!this.tabTypes.includes(type)) throw new Error('Invalid tab type')

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



    toggleNewElementPanel ()
    {
        this.ui.newElementPanel = !this.ui.newElementPanel
    }
    


    addElement (element, selectImmediately = false)
    {
        // Add inner element
        if (this.selected.elements.length === 1)
        {
            let selectedElement = this.flatElementList[this.selected.elements[0]]

            if (!selectedElement) return this

            this._addElement(selectedElement, element)
        }
        else
        {
            // Add root element
            this.elements.push(element)
        }

        if (selectImmediately) this.setElementSelection(element)

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

        this.cleanElementSelection()

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

    addElementSelection (element)
    {
        if (this.selected.elements.includes(element.elementId)) return

        this.selected.elements.push(element.elementId)
    }

    toggleElementSelection (element)
    {
        if (this.selected.elements.includes(element.elementId))
        {
            this.selected.elements = this.selected.elements.filter(e => e !== element.elementId)
        }
        else
        {
            this.selected.elements.push(element.elementId)
        }
    }

    cleanElementSelection ()
    {
        this.selected.elements = this.selected.elements.filter(e => this.flatElementList[e])
    }



    get inspectorFixtures ()
    {
        let elements = this.selectedElements
        let fixtures = {}

        if (elements.length === 0) return fixtures

        if (elements.some(e => e.hasOwnProperty('name')))
        {
            fixtures['elementName'] = {
                type: 'text',
                label: 'Element name',
                value: this.getCommonElementValue(elements.map(e => e.name)),
            }
        }

        if (elements.some(e => e.hasOwnProperty('id')))
        {
            fixtures['cssId'] = {
                type: 'text',
                label: 'CSS ID',
                value: this.getCommonElementValue(elements.map(e => e.id)),
            }
        }

        if (elements.some(e => e.hasOwnProperty('classes')))
        {
            fixtures['cssClasses'] = {
                type: 'text',
                label: 'CSS classes',
                value: this.getCommonElementValue(elements.map(e => e.classes)),
            }
        }

        if (elements.every(e => e.options?.hasOwnProperty('changeableWrapper') && e.options.changeableWrapper !== false) && this.isCommonElementValue(elements.map(e => e.wrapper)))
        {
            fixtures['wrapper'] = {
                type: 'select',
                label: 'Wrapper',
                value: this.getCommonElementValue(elements.map(e => e.wrapper), null),
                options: elements[0].options.changeableWrapper,
            }
        }

        return fixtures
    }

    isCommonElementValue (values)
    {
        return values.every(v => v === values[0])
    }

    getCommonElementValue (values, fallbackValue = '–')
    {
        if (values.every(v => v === values[0])) return values[0]

        return fallbackValue
    }



    setElementsValue (key, value)
    {
        for (const element of this.selectedElements)
        {
            element[key] = value
        }
    }
}