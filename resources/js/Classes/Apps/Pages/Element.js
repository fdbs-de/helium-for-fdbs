import { randomInt } from '@/Utils/Number'

export default class Element
{
    constructor (type, subtype, data = {})
    {
        this.element_id = randomInt(10000000, 99999999)
        this.element_type = type
        this.element_subtype = subtype
        this.name = data.name || ''
        this.id = data.id || 'element-'+this.element_id
        this.classes = data.classes || ''
        this.styles = data.styles || {}
        this.allowed_inner = data.allowed_inner || []
        this.inner = data.inner || []

        this.expanded = false
    }



    get icon ()
    {
        return 'grid_view'
    }



    addElement (type, subtype, data = {})
    {
        let element = new Element(type, subtype, data)

        this.inner.push(element)

        return element
    }



    toggleExpanded ()
    {
        this.expanded = !this.expanded
    }
}