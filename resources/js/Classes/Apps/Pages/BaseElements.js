import Element from '@/Classes/Apps/Pages/Element.js'



export class LayoutElement extends Element
{
    constructor(options)
    {
        super('raw', 'div', options)

        this
        .setAllowedInner(['raw', 'components', 'text', 'rich-text', 'code'])
        .setOption('canChangeContent', true)
        .setOption('canChangeLayout', true)
        .setOption('canDisableWrapper', true)
        .setOption('canChangeWrapper', true)
        .setOption('wrapperOptions', [
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
        .setMeta('displayIcon', 'align_horizontal_left')
        .setMeta('displayText', 'Layout Element')
    }
}



export class TextElement extends Element
{
    constructor(options)
    {
        super('text', 'p', options)

        this
        .setAllowedInner(['text', 'rich-text'])
        .setOption('canChangeContent', true)
        .setOption('canDisableWrapper', true)
        .setOption('canChangeWrapper', true)
        .setOption('wrapperOptions', [
            'p',
            'span',
            'h1',
            'h2',
            'h3',
            'h4',
            'h5',
            'h6',
        ])
        .setMeta('displayIcon', 'title')
        .setMeta('displayText', 'Text')
    }
}



export class LinkElement extends Element
{
    constructor (options)
    {
        super('raw', 'a', options)

        this
        .setAllowedInner(['raw', 'components', 'text', 'rich-text', 'code'])
        .setOption('canChangeContent', true)
        .setOption('canChangeHref', true)
        .setOption('canChangeTarget', true)
        .setOption('canDisableWrapper', false)
        .setOption('canChangeWrapper', false)
        .setOption('wrapperOptions', [
            'a',
        ])
        .setMeta('displayIcon', 'link')
        .setMeta('displayText', 'Link')
    }
}



export class ImageElement extends Element
{
    constructor (options)
    {
        super('raw', 'img', options)

        this
        .setAllowedInner([])
        .setOption('canChangeSrc', true)
        .setOption('canChangeAlt', true)
        .setOption('canDisableWrapper', false)
        .setOption('canChangeWrapper', false)
        .setOption('wrapperOptions', [
            'img',
        ])
        .setMeta('displayIcon', 'landscape')
        .setMeta('displayText', 'Image')
    }
}



export class VideoElement extends Element
{
    constructor (options)
    {
        super('raw', 'video', options)

        this
        .setAllowedInner([])
        .setOption('canChangeSrc', true)
        .setOption('canChangeAlt', true)
        .setOption('canDisableWrapper', false)
        .setOption('canChangeWrapper', false)
        .setOption('wrapperOptions', [
            'video',
        ])
        .setMeta('displayIcon', 'movie')
        .setMeta('displayText', 'Video')
    }
}



export class IFrameElement extends Element
{
    constructor (options)
    {
        super('raw', 'iframe', options)

        this
        .setAllowedInner([])
        .setOption('canChangeSrc', true)
        .setOption('canDisableWrapper', false)
        .setOption('canChangeWrapper', false)
        .setOption('wrapperOptions', [
            'iframe',
        ])
        .setMeta('displayIcon', 'map')
        .setMeta('displayText', 'Iframe')
    }
}



export class ButtonElement extends Element
{
    constructor (options)
    {
        super('raw', 'button', options)

        this
        .setAllowedInner(['raw', 'components', 'text', 'rich-text', 'code'])
        .setOption('canChangeContent', true)
        .setOption('canChangeHref', true)
        .setOption('canChangeTarget', true)
        .setOption('canDisableWrapper', false)
        .setOption('canChangeWrapper', true)
        .setOption('wrapperOptions', [
            'button',
            'a',
        ])
        .setMeta('displayIcon', 'mouse')
        .setMeta('displayText', 'Button')
    }
}



export class CodeElement extends Element
{
    constructor (options)
    {
        super('code', 'div', options)

        this
        .setAllowedInner(['code'])
        .setOption('canChangeContent', true)
        .setOption('canDisableWrapper', true)
        .setOption('canChangeWrapper', true)
        .setOption('wrapperOptions', [
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
        .setMeta('displayIcon', 'data_object')
        .setMeta('displayText', 'Code')
    }
}



export class SlotElement extends Element
{
    constructor (options)
    {
        super('raw', 'div', options)

        this
        .setAllowedInner(['raw', 'components', 'text', 'rich-text', 'code'])
        .setOption('canChangeContent', false)
        .setOption('canDisableWrapper', true)
        .setOption('canChangeWrapper', true)
        .setOption('wrapperOptions', [
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
        .setMeta('displayIcon', 'variables')
        .setMeta('displayText', 'Content Slot')
    }
}