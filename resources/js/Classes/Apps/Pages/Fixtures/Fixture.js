import _ from 'lodash'



export default class Fixture
{
    constructor (inspector = null)
    {
        this.inspector = inspector
        this.label = ''
        this.type = null
        this.available = true
        this._value = null

        return this
    }



    setInspector (inspector)
    {
        this.inspector = inspector
        return this
    }



    onChange ()
    {
        this.inspector?.applyChanges()
    }

    throttledOnChange = _.throttle(this.onChange, 700)
}