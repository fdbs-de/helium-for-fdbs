import Fixture from '@/Classes/Apps/Pages/Fixtures/Fixture.js'



export default class SelectFixture extends Fixture
{
    constructor (name, values = [])
    {
        super()

        this.name = name
        this.type = 'select'
        this.value = this._commonValue(values)
        this.options = []

        return this
    }



    setOptions (options)
    {
        this.options = options

        return this
    }
}