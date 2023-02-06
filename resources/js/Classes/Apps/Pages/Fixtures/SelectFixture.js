import Fixture from '@/Classes/Apps/Pages/Fixtures/Fixture.js'



export default class SelectFixture extends Fixture
{
    constructor (label)
    {
        super()

        this.label = label
        this.type = 'select'
        this.value = null
        this.options = []

        return this
    }



    setOptions (options)
    {
        this.options = options

        return this
    }
}