import Element from '@/Classes/Apps/Pages/Elements/Element.js'



export default class CodeElement extends Element
{
    constructor (options)
    {
        super('raw', 'div', options)

        this.elementClassName = 'code'

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