import Fixture from '@/Classes/Apps/Pages/Fixtures/Fixture.js'



export default class TextFixture extends Fixture
{
    constructor (label)
    {
        super()

        this.label = label
        this.type = 'text'
        this.value = ''

        return this
    }
}