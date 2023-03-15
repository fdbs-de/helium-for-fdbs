import Element from '@/Classes/Apps/Pages/Elements/Element.js'



export default class ButtonElement extends Element
{
    constructor (options)
    {
        super('raw', 'button', options)

        this.elementClassName = 'button'

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