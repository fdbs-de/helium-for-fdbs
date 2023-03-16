import Fixture from '@/Classes/Apps/Pages/Fixtures/Fixture.js'



export default class LayoutFixture extends Fixture
{
    constructor(label)
    {
        super()

        this.label = label
        this.type = 'layout'
        this.value = {
            'flex-direction': 'row',
            'flex-wrap': 'nowrap',
            'justify-content': 'flex-start',
            'align-items': 'flex-start',
            'gap': ['', ''],
        }

        this.availabilityHandler = null
        this.valueHandler = null

        return this
    }



    get flexWrap()
    {
        return this.value['flex-wrap']
    }

    set flexWrap(value)
    {
        this.value['flex-wrap'] = value
        this.onChange()
    }



    get xGap()
    {
        return this.value['gap'][0]
    }

    set xGap(value)
    {
        this.value['gap'][0] = value
        this.throttledOnChange()
    }



    get yGap()
    {
        return this.value['gap'][1]
    }

    set yGap(value)
    {
        this.value['gap'][1] = value
        this.throttledOnChange()
    }



    get gap()
    {
        if (!this.xGap) return null

        if (!this.yGap) return this.xGap

        if (this.xGap === this.yGap) return this.xGap

        return `${this.xGap} ${this.yGap}`
    }



    get flexDirection()
    {
        return this.value['flex-direction']
    }

    set flexDirection(value)
    {
        // Swap align-items and justify-content if the flex-direction changes
        if (value !== this.value['flex-direction'])
        {
            [this.value['align-items'], this.value['justify-content']] = [this.value['justify-content'], this.value['align-items']]
        }
        
        // Set the new flex-direction
        this.value['flex-direction'] = value

        this.onChange()
    }



    get matrix()
    {
        let xDict = {
            'flex-start': 'left',
            'center': 'center',
            'flex-end': 'right',
        }

        let yDict = {
            'flex-start': 'top',
            'center': 'center',
            'flex-end': 'bottom',
        }
        
        if (this.value['flex-direction'] === 'row')
        {
            let xAlign = xDict[this.value['justify-content']]
            let yAlign = yDict[this.value['align-items']]
            
            return `${xAlign}:${yAlign}`
        }
        else
        {
            let xAlign = yDict[this.value['justify-content']]
            let yAlign = xDict[this.value['align-items']]

            return `${yAlign}:${xAlign}`
        }
    }

    set matrix(value)
    {
        let dict = {
            'left': 'flex-start',
            'center': 'center',
            'right': 'flex-end',
            'top': 'flex-start',
            'center': 'center',
            'bottom': 'flex-end',
        }
        
        let [xAlign, yAlign] = value.split(':')

        if (this.value['flex-direction'] === 'row')
        {
            this.value['align-items'] = dict[yAlign]
            this.value['justify-content'] = dict[xAlign]
        }
        else
        {
            this.value['align-items'] = dict[xAlign]
            this.value['justify-content'] = dict[yAlign]
        }

        this.onChange()
    }



    setAvailabilityHandler(availabilityHandler)
    {
        this.availabilityHandler = availabilityHandler

        return this
    }

    setValueHandler(valueHandler)
    {
        this.valueHandler = valueHandler

        return this
    }

    update(items)
    {
        if (this.availabilityHandler) this.available = this.availabilityHandler(items)
        if (this.valueHandler) this._value = this.valueHandler(items)

        return this
    }



    serializeValue()
    {
        let obj = {}

        if (this.flexDirection) obj['flex-direction'] = this.flexDirection
        if (this.flexWrap) obj['flex-wrap'] = this.flexWrap
        if (this.value['justify-content']) obj['justify-content'] = this.value['justify-content']
        if (this.value['align-items']) obj['align-items'] = this.value['align-items']
        if (this.gap) obj['gap'] = this.gap

        return obj
    }
}