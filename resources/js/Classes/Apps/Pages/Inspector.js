import TextFixture from '@/Classes/Apps/Pages/Fixtures/TextFixture'
import SelectFixture from '@/Classes/Apps/Pages/Fixtures/SelectFixture'
import LayoutFixture from '@/Classes/Apps/Pages/Fixtures/LayoutFixture'
import EventListener from '@/Classes/EventListener'
import { ref } from 'vue'



export default class Inspector extends EventListener
{
    constructor ()
    {
        super()

        this.fixtures = {
            // General
            'name': new TextFixture('Name'),
            'id': new TextFixture('ID'),
            'classes': new TextFixture('Classes'),
            'wrapper': new SelectFixture('Wrapper'),
            'innerContent': new TextFixture('Content'),

            // Styles
            'style_layout': new LayoutFixture('Layout'),
            
            // Attributes
            'attr_href': new TextFixture('Href'),
            'attr_target': new SelectFixture('Target'),
            'attr_rel': new TextFixture('Rel'),
            'attr_alt': new TextFixture('Alt'),
            'attr_src': new TextFixture('Src'),
        }



        for (let key in this.fixtures)
        {
            this.fixtures[key].addEventListener('change', () => this.dispatchEvent('change', this.serializeValues()))
        }
    }



    serializeValues ()
    {
        let values = {
            attr: {},
            styles: {},
        }
        
        for (let key in this.fixtures)
        {
            if (key.startsWith('attr_'))
            {
                values.attr[key.replace('attr_', '')] = this.fixtures[key].serializeValue()
                continue
            }

            if (key.startsWith('style_'))
            {
                values.styles = {...values.styles, ...this.fixtures[key].serializeValue()}
                continue
            }

            values[key] = this.fixtures[key].serializeValue()
        }

        return values
    }
}