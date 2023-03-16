import TextFixture from '@/Classes/Apps/Pages/Fixtures/TextFixture'
import SelectFixture from '@/Classes/Apps/Pages/Fixtures/SelectFixture'
import LayoutFixture from '@/Classes/Apps/Pages/Fixtures/LayoutFixture'
import EventListener from '@/Classes/EventListener'
import { commonValue } from '@/Utils/Object'




export default class Inspector extends EventListener
{
    constructor ()
    {
        super()

        this.panel = 'design'
        this.fixtures = {
            // General
            'name': new TextFixture('Name')
                .setAvailabilityHandler(items => items.some(i => i?.options?.canChangeName))
                .setValueHandler(items => commonValue(items.map(i => i?.name)) ?? ''),

            'id': new TextFixture('ID')
                .setAvailabilityHandler(items => items.some(i => i?.options?.canChangeId))
                .setValueHandler(items => commonValue(items.map(i => i?.id)) ?? ''),

            'classes': new TextFixture('Classes')
                .setAvailabilityHandler(items => items.some(i => i?.options?.canChangeClasses))
                .setValueHandler(items => commonValue(items.map(i => i?.classes)) ?? ''),

            'wrapper': new SelectFixture('Wrapper')
                .setAvailabilityHandler(items => items.some(i => i?.options?.canChangeWrapper))
                .setOptionsHandler(items => commonValue(items.map(i => i?.options?.wrapperOptions)) ?? [])
                .setValueHandler(items => commonValue(items.map(i => i?.wrapper)) ?? null),

            'innerContent': new TextFixture('Content')
                .setAvailabilityHandler(items => items.some(i => i?.options?.canChangeContent))
                .setValueHandler(items => commonValue(items.map(i => i?.innerContent)) ?? ''),

            // Styles
            'style_layout': new LayoutFixture('Layout')
                .setAvailabilityHandler(items => items.some(i => i?.options?.canChangeLayout)),
            
            // Attributes
            'attr_href': new TextFixture('Href')
                .setAvailabilityHandler(items => items.some(i => i?.options?.canChangeHref))
                .setValueHandler(items => commonValue(items.map(i => i?.attributes?.href)) ?? ''),

            'attr_target': new SelectFixture('Target', '_blank')
                .setAvailabilityHandler(items => items.some(i => i?.options?.canChangeTarget))
                .setOptionsHandler(items => commonValue(items.map(i => i?.options?.targetOptions)) ?? [])
                .setValueHandler(items => commonValue(items.map(i => i?.attributes?.target)) ?? null),

            'attr_rel': new TextFixture('Rel')
                .setAvailabilityHandler(items => items.some(i => i?.options?.canChangeRel))
                .setValueHandler(items => commonValue(items.map(i => i?.attributes?.rel)) ?? ''),

            'attr_alt': new TextFixture('Alt')
                .setAvailabilityHandler(items => items.some(i => i?.options?.canChangeAlt))
                .setValueHandler(items => commonValue(items.map(i => i?.attributes?.alt)) ?? ''),

            'attr_src': new TextFixture('Src')
                .setAvailabilityHandler(items => items.some(i => i?.options?.canChangeSrc))
                .setValueHandler(items => commonValue(items.map(i => i?.attributes?.src)) ?? ''),
        }



        for (let key in this.fixtures)
        {
            this.fixtures[key].addEventListener('change', () => this.dispatchEvent('change', this.serializeValues()))
        }
    }



    update(elements)
    {
        for (let key in this.fixtures)
        {
            this.fixtures[key].update(elements)
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