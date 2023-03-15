import Element from '@/Classes/Apps/Pages/Elements/Element.js'



export default class ImageElement extends Element
{
    constructor (options)
    {
        super('raw', 'img', options)

        this.elementClassName = 'image'

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