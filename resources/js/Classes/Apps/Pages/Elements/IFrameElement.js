import Element from '@/Classes/Apps/Pages/Elements/Element.js'



export default class IFrameElement extends Element
{
    constructor (options)
    {
        super('raw', 'iframe', options)

        this.elementClassName = 'iframe'

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