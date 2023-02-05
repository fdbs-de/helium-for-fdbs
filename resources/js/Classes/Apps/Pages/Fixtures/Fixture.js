

export default class Fixture
{
    constructor ()
    {
        this.name = ''
        this.type = null
        this.value = null
    }



    _commonValue (values)
    {
        if (values.length === 0) return null
        
        if (values.every(v => v === values[0])) return values[0]

        return null
    }



    setValue (value)
    {
        this.value = value

        return this
    }

    setCommonValue (values)
    {
        this.value = this._commonValue(values)

        return this
    }
}