import { randomInt } from '@/Utils/Number'



/**
 * Element class
 * 
 * @param {string} type Element type: raw, components, text, rich-text, code
 * @param {string} wrapper HTML tag name (optional)
 * @param {object} options Element options (optional)
 */
export default class Element
{
    constructor (type, wrapper = null, options = null)
    {
        // Valid element types
        this.elementTypes = ['raw', 'components', 'text', 'rich-text', 'code']
        


        // Parent reference
        this.parent = null

        // Basic data
        this.elementId = null
        this.elementType = null
        this.wrapper = wrapper
        this.name = options?.name || ''

        // Generate element ID and set type
        this.generateId()
        this.setElementType(type)
        
        // Render data
        this.id = ''
        this.classes = ''
        this.allowedInner = []
        this.inner = []
        this.innerContent = null
        this.styles = {
            default: {},
        }
        this.attributes = {
            src: '',
            alt: '',
            href: '',
            target: '',
        }

        // Options
        this.options = {
            canChangeName: true,
            canChangeId: true,
            canChangeClasses: true,
            canDisableWrapper: false,
            canChangeWrapper: false,
            wrapperOptions: [],
            canChangeLayout: false,
            canChangeStyles: false,
            canChangeSrc: false,
            canChangeAlt: false,
            canChangeHref: false,
            canChangeTarget: false,
            targetOptions: ['_blank', '_self', '_parent', '_top'],
            canChangeContent: false,
        }

        // Editor metadata
        this.editorMeta = {
            expanded: true,
            displayIcon: 'grid_view',
            displayText: 'Blank Element',
            displayColor: 'grey',
        }

        return this
    }



    generateId ()
    {
        this.elementId = 'EID-'+randomInt(0, 9999999999).toString().padStart(10, '0')

        return this
    }

    setElementType (type)
    {
        if (!this.elementTypes.includes(type))
        {
            throw new Error('Invalid element type')
        }

        this.elementType = type

        return this
    }



    setParent(parent)
    {
        this.parent = parent
        
        return this
    }



    canOption(option)
    {
        return this.options.hasOwnProperty(option) && this.options[option] === true
    }



    setAllowedInner (allowedInner)
    {
        // If allowedInner is string, convert it to array
        if (typeof allowedInner === 'string') allowedInner = [allowedInner]

        // Check if allowedInner consists of valid element types
        if (!allowedInner.every(type => this.elementTypes.includes(type)))
        {
            throw new Error('Invalid element type')
        }

        this.allowedInner = allowedInner
        
        return this
    }

    setOption (key, value)
    {
        if (!this.options.hasOwnProperty(key))
        {
            throw new Error('Invalid option')
        }

        this.options[key] = value
        
        return this
    }

    setMeta (key, value)
    {
        if (!this.editorMeta.hasOwnProperty(key))
        {
            throw new Error('Invalid meta')
        }

        this.editorMeta[key] = value
        
        return this
    }



    addElement (element)
    {
        this.inner.push(element.setParent(this))

        return this
    }



    toggleExpanded ()
    {
        this.editorMeta.expanded = !this.editorMeta.expanded

        return this
    }
}