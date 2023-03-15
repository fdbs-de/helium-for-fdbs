import { randomInt } from '@/Utils/Number'
import Tab from '@/Classes/Editor/Tab'
import Inspector from '@/Classes/Apps/Pages/PageInspector'
import ElementManager from '@/Classes/Apps/Pages/Elements/ElementManager'



export default class PageTab extends Tab
{
    constructor (type, options = null)
    {
        super()

        // Valid tab types
        this.tabTypes = ['new-tab', 'page-editor', 'component-editor']

        // Set tab type
        this.setType(type)
        
        // Form specific data
        this.id = null
        this.title = 'Untitled'
        this.slug = ''
        this.status = 'draft'
        this.version = null
        this.elements = []
        this.meta = {}
        this.injectedData = []

        // Set up inspector
        this.inspector = new Inspector()

        this.processing = {
            saving: false,
        }

        this.selected = {
            breakpoint: 0,
            elements: [],
        }

        this.ui = {
            newElementPanel: false,
        }

        // Add event listeners
        this.inspector.addEventListener('change', (event) => this.dispatchEvent('inspector:change', event))

        return this
    }



    get icon ()
    {
        if (this.type == 'new-tab') return 'layers'
        if (this.type == 'page-editor') return 'language'
        if (this.type == 'component-editor') return 'widgets'

        return 'help'
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



    toggleNewElementPanel ()
    {
        this.ui.newElementPanel = !this.ui.newElementPanel
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
        this.elements = this.elements.filter(element => !elementIds.includes(element.elementId))

        for (const element of this.elements)
        {
            element.removeElements(elementIds)
        }

        this.cleanElementSelection()

        return this
    }



    hydrate(data) {
        this.id = data.id
        this.title = data.title
        this.slug = data.slug
        this.status = data.status
        this.meta = {}
        this.injectedData = []

        this.elements = data.content.map(element => {
            let elementClass = new ElementManager().newElement(element.elementClassName)

            if (!elementClass) return

            return elementClass.hydrate(element)
        })

        return this
    }

    serialize()
    {
        return {
            id: this.id,
            title: this.title,
            slug: this.slug,
            status: this.status,
            version: this.version,
            content: this.elements.map(element => element.serialize()),
        }
    }
}