import Element from '@/Classes/Apps/Pages/Elements/Element.js'



export default class LinkElement extends Element
{
    constructor (options)
    {
        super('raw', 'a', options)

        this.elementClassName = 'link'

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