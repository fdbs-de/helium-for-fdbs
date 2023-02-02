import Element from '@/Classes/Apps/Pages/Element.js'



export class BlankElement extends Element
{
    constructor (data)
    {
        super('raw', 'div', data)

        this.setAllowedInner(['raw', 'components', 'text'])

        this.setOption('changeableWrapper', ['div', 'span', 'header', 'footer', 'main', 'section', 'article', 'aside', 'nav', 'blockquote', 'pre', 'code', 'address', 'figure', 'figcaption'])

        this.setMeta('displayIcon', 'grid_view')
        this.setMeta('displayText', 'Blank Element')
    }
}



export class LinkElement extends Element
{
    constructor (data)
    {
        super('raw', 'a', data)

        this.setAllowedInner(['raw', 'components', 'text'])

        this.setOption('href', '')

        this.setMeta('displayIcon', 'link')
        this.setMeta('displayText', 'Link')
    }
}



export class ImageElement extends Element
{
    constructor (data)
    {
        super('raw', 'img', data)

        this.setOption('src', '')
        this.setOption('alt', '')

        this.setMeta('displayIcon', 'image')
        this.setMeta('displayText', 'Image')
    }
}