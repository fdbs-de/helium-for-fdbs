import Element from '@/Classes/Apps/Pages/Elements/Element.js'



export default class LayoutElement extends Element
{
    constructor(options)
    {
        super('raw', 'div', options)

        this.elementClassName = 'layout'

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