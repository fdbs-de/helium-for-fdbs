import Fixture from '@/Classes/Apps/Pages/Fixtures/Fixture.js'



export default class TextFixture extends Fixture
{
    constructor(label)
    {
        super()

        this.label = label
        this.type = 'text'
        this._value = ''

        this.availabilityHandler = null
        this.valueHandler = null

        return this
    }



    get value()
    {
        return this._value
    }

    set value(value)
    {
        this._value = value
        this.throttledOnChange()
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
        return this._value
    }
}