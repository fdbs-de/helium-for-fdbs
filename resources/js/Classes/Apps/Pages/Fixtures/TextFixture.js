import Fixture from '@/Classes/Apps/Pages/Fixtures/Fixture.js'



export default class TextFixture extends Fixture
{
    constructor (name, values = [])
    {
        super()

        this.name = name
        this.type = 'text'
        this.value = this._commonValue(values)

        return this
    }
}