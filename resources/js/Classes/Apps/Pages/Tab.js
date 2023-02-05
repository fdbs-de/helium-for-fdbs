import { randomInt } from '@/Utils/Number'
import TextFixture from '@/Classes/Apps/Pages/Fixtures/TextFixture'
import SelectFixture from '@/Classes/Apps/Pages/Fixtures/SelectFixture'

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
        const length = elements.length
        
        if (length === 0) return {}
        


        const fixtures = {
            name: 0,
            id: 0,
            classes: 0,
            wrapper: 0,
            href: 0,
            target: 0,
            src: 0,
            alt: 0,
            content: 0,
        }

        for (const element of elements)
        {
            if (element.canOption('canChangeName')) fixtures['name']++
            if (element.canOption('canChangeId')) fixtures['id']++
            if (element.canOption('canChangeClasses')) fixtures['classes']++
            if (element.canOption('canChangeWrapper')) fixtures['wrapper']++
            if (element.canOption('canChangeHref')) fixtures['href']++
            if (element.canOption('canChangeTarget')) fixtures['target']++
            if (element.canOption('canChangeSrc')) fixtures['src']++
            if (element.canOption('canChangeAlt')) fixtures['alt']++
            if (element.canOption('canChangeContent')) fixtures['content']++
        }

        return {
            name: fixtures['name'] > 0          ? new TextFixture('Element Name', elements.map(e => e?.name)) : null,
            id: fixtures['id'] > 0              ? new TextFixture('CSS Id', elements.map(e => e?.id)) : null,
            classes: fixtures['classes'] > 0    ? new TextFixture('CSS Klassen', elements.map(e => e?.classes)) : null,
            wrapper: fixtures['wrapper'] === length ? new SelectFixture('Wrapper', elements.map(e => e?.wrapper)).setOptions(elements[0].options.wrapperOptions) : null,
            href: fixtures['href'] > 0          ? new TextFixture('URL', elements.map(e => e?.attributes?.href)) : null,
            target: fixtures['target'] > 0      ? new SelectFixture('Ziel', elements.map(e => e?.attributes?.target)).setOptions(elements[0].options.targetOptions) : null,
            src: fixtures['src'] > 0            ? new TextFixture('URL', elements.map(e => e?.attributes?.src)) : null,
            alt: fixtures['alt'] > 0            ? new TextFixture('Alternativ Text', elements.map(e => e?.attributes?.alt)) : null,
            content: fixtures['content'] > 0    ? new TextFixture('Inhalt', elements.map(e => e?.content)) : null,
        }
    }



    setElementsValue (key, value)
    {
        for (const element of this.selectedElements)
        {
            element[key] = value
        }
    }
}