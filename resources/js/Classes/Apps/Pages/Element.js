import { randomInt } from '@/Utils/Number'

export default class Element
{
    constructor (type, wrapper = null, data = {})
    {
        if (!['raw', 'components', 'text'].includes(type)) throw new Error('Invalid element type')

        this.elementId = randomInt(10000000, 99999999)

        this.elementType = type
        this.wrapper = wrapper || null
        this.name = data.name || ''
        this.id = data.id || 'element-'+this.elementId
        this.classes = data.classes || ''

        this.styles = {}
        this.allowedInner = []
        this.inner = []
        this.innerContent = null
        this.breadcrumbs = []

        this.options = {
            changeableWrapper: false,
            src: false,
            alt: false,
            href: false,
            target: false,
            content: false,
        }

        this.editorMeta = {
            expanded: true,
            displayIcon: 'grid_view',
            displayText: 'Blank Element',
            displayColor: 'grey',
        }
    }



    setAllowedInner (allowedInner)
    {
        this.allowedInner = allowedInner
    }

    setOption (key, value)
    {
        this.options[key] = value
    }

    setMeta (key, value)
    {
        this.editorMeta[key] = value
    }



    addElement (element)
    {
        this.inner.push(element)

        return this
    }



    toggleExpanded ()
    {
        this.editorMeta.expanded = !this.editorMeta.expanded
    }
}