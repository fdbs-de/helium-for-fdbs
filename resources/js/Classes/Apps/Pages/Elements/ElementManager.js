import ButtonElement from '@/Classes/Apps/Pages/Elements/ButtonElement'
import CodeElement from '@/Classes/Apps/Pages/Elements/CodeElement'
import IFrameElement from '@/Classes/Apps/Pages/Elements/IFrameElement'
import ImageElement from '@/Classes/Apps/Pages/Elements/ImageElement'
import LayoutElement from '@/Classes/Apps/Pages/Elements/LayoutElement'
import LinkElement from '@/Classes/Apps/Pages/Elements/LinkElement'
import SlotElement from '@/Classes/Apps/Pages/Elements/SlotElement'
import TextElement from '@/Classes/Apps/Pages/Elements/TextElement'
import VideoElement from '@/Classes/Apps/Pages/Elements/VideoElement'



// Register all elements
const elements = {
    button: ButtonElement,
    code: CodeElement,
    iframe: IFrameElement,
    image: ImageElement,
    layout: LayoutElement,
    link: LinkElement,
    slot: SlotElement,
    text: TextElement,
    video: VideoElement,
}



export default class ElementManager
{
    newElement(elementClassName, params = [])
    {
        if (!elements.hasOwnProperty(elementClassName)) return null

        return new (elements[elementClassName])(...params)
    }
}