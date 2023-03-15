import Element from '@/Classes/Apps/Pages/Elements/Element.js'



export default class VideoElement extends Element
{
    constructor (options)
    {
        super('raw', 'video', options)

        this.elementClassName = 'video'

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