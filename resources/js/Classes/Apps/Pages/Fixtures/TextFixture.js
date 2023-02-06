import Fixture from '@/Classes/Apps/Pages/Fixtures/Fixture.js'



export default class TextFixture extends Fixture
{
    constructor (label)
    {
        super()

        this.label = label
        this.type = 'text'
        this._value = ''

        return this
    }



    get value ()
    {
        return this._value
    }

    set value (value)
    {
        this._value = value
        this.throttledOnChange()
    }
}