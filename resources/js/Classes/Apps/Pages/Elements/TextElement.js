import Element from '@/Classes/Apps/Pages/Elements/Element.js'



export default class TextElement extends Element
{
    constructor(options)
    {
        super('raw', 'p', options)

        this.elementClassName = 'text'

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