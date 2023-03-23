import Fixture from '@/Classes/Apps/Pages/Fixtures/Fixture.js'



export default class SelectFixture extends Fixture
{
    constructor(label, value)
    {
        super()

        this.label = label
        this.type = 'select'
        this.options = []
        this._value = value ?? null

        this.availabilityHandler = null
        this.valueHandler = null
        this.optionsHandler = null

        return this
    }



    get value()
    {
        return this._value
    }

    set value(value)
    {
        this._value = value
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

    setOptionsHandler(optionsHandler)
    {
        this.optionsHandler = optionsHandler

        return this
    }

    update(items)
    {
        if (this.availabilityHandler) this.available = this.availabilityHandler(items)
        if (this.optionsHandler) this.options = this.optionsHandler(items)
        if (this.valueHandler) this._value = this.valueHandler(items)

        return this
    }


    serializeValue()
    {
        return this._value
    }
}