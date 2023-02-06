import TextFixture from '@/Classes/Apps/Pages/Fixtures/TextFixture'
import SelectFixture from '@/Classes/Apps/Pages/Fixtures/SelectFixture'
import LayoutFixture from '@/Classes/Apps/Pages/Fixtures/LayoutFixture'



export default class Inspector
{
    constructor ()
    {
        this.fixtures = {
            'name': new TextFixture('Name'),
            'id': new TextFixture('ID'),
            'classes': new TextFixture('Classes'),
            'wrapper': new SelectFixture('Wrapper'),
            'content': new TextFixture('Content'),

            'style_layout': new LayoutFixture('Layout'),
            
            'attr_href': new TextFixture('Href'),
            'attr_target': new SelectFixture('Target'),
            'attr_rel': new TextFixture('Rel'),
            'attr_alt': new TextFixture('Alt'),
            'attr_src': new TextFixture('Src'),
        }
    }
}