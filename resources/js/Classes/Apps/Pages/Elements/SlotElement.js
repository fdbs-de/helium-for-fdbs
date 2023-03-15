import Element from '@/Classes/Apps/Pages/Elements/Element.js'



export default class SlotElement extends Element
{
    constructor (options)
    {
        super('raw', 'div', options)

        this.elementClassName = 'slot'

        this
        .setAllowedInner([])
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