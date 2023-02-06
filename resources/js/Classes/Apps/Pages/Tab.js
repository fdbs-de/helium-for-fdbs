import { randomInt } from '@/Utils/Number'
import Inspector from '@/Classes/Apps/Pages/Inspector'



export default class Tab
{
    constructor (type, data = {})
    {
        // Valid tab types
        this.tabTypes = ['new-tab', 'page-editor', 'component-editor']

        // Basic data
        this.id = null
        this.type = null
        this.active = false
        this.inspector = new Inspector(this)
        this.history = []
        this.elements = []
        
        // Generate tab ID and set type
        this.generateId()
        this.setType(type)
        
        // Page data
        this.title = null
        this.url = null
        this.version = null

        this.selected = {
            breakpoint: 0,
            elements: [],
        }

        this.ui = {
            newElementPanel: false,
        }

        return this
    }



    generateId ()
    {
        this.id = 'TID-'+randomInt(0, 9999999999).toString().padStart(10, '0')

        return this
    }

    setType (type)
    {
        if (!this.tabTypes.includes(type))
        {
            throw new Error('Invalid tab type')
        }

        this.type = type

        return this
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

        function flatten (element)
        {
            elements[element.elementId] = element
            element.inner.forEach(e => flatten(e))
        }

        this.elements.forEach(e => flatten(e, [null]))

        return elements
    }


    
    useAs (type, data)
    {
        this.setType(type).loadData(data)

        return this
    }
    
    loadData (data)
    {
        this.version = data.version || '0.0.1'
        this.title = data.title || ''
        this.url = data.url || null
        this.history = data.history || []
        this.elements = data.elements || []

        return this
    }



    toggleNewElementPanel ()
    {
        this.ui.newElementPanel = !this.ui.newElementPanel
    }
    


    addElement (element, selectImmediately = false)
    {
        let target = this.selected.elements.length === 1 ? this.flatElementList[this.selected.elements[0]] : null
        
        this.addElementRecursive(target, element)

        if (selectImmediately) this.setElementSelection(element)

        return this
    }

    addElementRecursive (target, element)
    {
        // Try insert to target
        if (target?.allowedInner?.includes(element.elementType))
        {
            return target.addElement(element)
        }

        // Try insert to parent
        if (target?.parent)
        {
            return this.addElementRecursive(target.parent, element)
        }

        // Insert to root
        this.elements.push(element.setParent(null))

        return element
    }



    removeElements (elementIds)
    {
        this.elements = this.elements.filter(e => !elementIds.includes(e.elementId))

        for (const element of this.elements)
        {
            this._removeElements(element, elementIds)
        }

        this.cleanElementSelection()

        return this
    }

    _removeElements (targetElement, elementIds)
    {
        targetElement.inner = targetElement.inner.filter(e => !elementIds.includes(e.elementId))

        for (const element of targetElement.inner)
        {
            this._removeElements(element, elementIds)
        }
    }



    get selectedElements ()
    {
        return this.selected.elements.map(id => this.flatElementList[id]).filter(e => e)
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

    rootElementSelection ()
    {
        let elements = this.elements

        this.clearElementSelection()

        for (const element of elements)
        {
            this.addElementSelection(element)
        }
    }

    childrenElementSelection ()
    {
        let elements = this.selectedElements

        if (elements.length <= 0) return this.rootElementSelection()

        // Clear if any element has children
        if (elements.some(e => e.inner?.length > 0)) this.clearElementSelection()
        
        for (const element of elements)
        {
            for (const child of element.inner)
            {
                this.addElementSelection(child)
            }
        }
    }

    parentElementSelection ()
    {
        let elements = this.selectedElements

        if (elements.length <= 0) return

        this.clearElementSelection()
        
        for (const element of elements)
        {
            if (!element.parent) continue

            this.addElementSelection(element.parent)
        }
    }

    cleanElementSelection ()
    {
        this.selected.elements = this.selected.elements.filter(e => this.flatElementList[e])
    }

    clearElementSelection ()
    {
        this.selected.elements = []
    }
}