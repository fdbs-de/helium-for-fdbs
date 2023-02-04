import Element from '@/Classes/Apps/Pages/Element.js'



export class BlankElement extends Element
{
    constructor (data)
    {
        super('raw', 'div', data)

        this.setAllowedInner(['raw', 'components', 'text'])

        this.setOption('content', ['text'])
        this.setOption('changeableWrapper', [
            'div',
            'span',
            'header',
            'footer',
            'main',
            'section',
            'article',
            'aside',
            'nav',
            'blockquote',
            'pre',
            'code',
            'address',
            'figure',
            'figcaption',
        ])

        this.setMeta('displayIcon', 'grid_view')
        this.setMeta('displayText', 'Blank Element')
    }
}



export class TextElement extends Element {
    constructor(data) {
        super('text', 'p', data)

        this.setOption('content', ['text', 'rich-text'])
        this.setOption('changeableWrapper', ['p', 'span', 'div'])

        this.setMeta('displayIcon', 'subject')
        this.setMeta('displayText', 'Text')
    }
}



export class HeadingElement extends Element {
    constructor(data) {
        super('text', 'h1', data)

        this.setOption('content', ['text', 'rich-text'])
        this.setOption('changeableWrapper', ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'])

        this.setMeta('displayIcon', 'title')
        this.setMeta('displayText', 'Heading')
    }
}



export class LinkElement extends Element
{
    constructor (data)
    {
        super('raw', 'a', data)

        this.setAllowedInner(['raw', 'components', 'text'])

        this.setOption('content', ['text'])
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

        this.setMeta('displayIcon', 'landscape')
        this.setMeta('displayText', 'Image')
    }
}



export class VideoElement extends Element
{
    constructor (data)
    {
        super('raw', 'video', data)

        this.setOption('src', '')
        this.setOption('alt', '')

        this.setMeta('displayIcon', 'movie')
        this.setMeta('displayText', 'Video')
    }
}



export class IFrameElement extends Element
{
    constructor (data)
    {
        super('raw', 'iframe', data)

        this.setOption('src', '')

        this.setMeta('displayIcon', 'map')
        this.setMeta('displayText', 'Iframe')
    }
}



export class ButtonElement extends Element
{
    constructor (data)
    {
        super('raw', 'button', data)

        this.setAllowedInner(['raw', 'components', 'text'])

        this.setOption('content', ['text'])
        this.setOption('changeableWrapper', ['button', 'a'])

        this.setMeta('displayIcon', 'radio_button_checked')
        this.setMeta('displayText', 'Button')
    }
}



export class CodeElement extends Element
{
    constructor (data)
    {
        super('raw', 'div', data)

        this.setOption('content', ['code'])

        this.setMeta('displayIcon', 'data_object')
        this.setMeta('displayText', 'Code')
    }
}



export class SlotElement extends Element
{
    constructor (data)
    {
        super('raw', 'div', data)

        this.setMeta('displayIcon', 'variables')
        this.setMeta('displayText', 'Content Slot')
    }
}