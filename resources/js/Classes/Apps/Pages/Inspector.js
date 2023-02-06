import TextFixture from '@/Classes/Apps/Pages/Fixtures/TextFixture'
import SelectFixture from '@/Classes/Apps/Pages/Fixtures/SelectFixture'
import LayoutFixture from '@/Classes/Apps/Pages/Fixtures/LayoutFixture'



export default class Inspector
{
    constructor (parentTab)
    {
        this.parentTab = parentTab
        this.fixtures = {
            'name': new TextFixture('Name').setInspector(this),
            'id': new TextFixture('ID').setInspector(this),
            'classes': new TextFixture('Classes').setInspector(this),
            'wrapper': new SelectFixture('Wrapper').setInspector(this),
            'content': new TextFixture('Content').setInspector(this),

            'style_layout': new LayoutFixture('Layout').setInspector(this),
            
            'attr_href': new TextFixture('Href').setInspector(this),
            'attr_target': new SelectFixture('Target').setInspector(this),
            'attr_rel': new TextFixture('Rel').setInspector(this),
            'attr_alt': new TextFixture('Alt').setInspector(this),
            'attr_src': new TextFixture('Src').setInspector(this),
        }
    }



    applyChanges ()
    {
        // console.log(this.parentTab?.selectedElements)
    }
}