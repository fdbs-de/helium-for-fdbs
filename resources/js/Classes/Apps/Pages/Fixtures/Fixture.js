// import Class from ''



export default class Fixture
{
    constructor ()
    {
        this.label = ''
        this.type = null
        this.value = null
        this.available = true
    }



    _commonValue (values)
    {
        if (values.length === 0) return null
        
        if (values.every(v => v === values[0])) return values[0]

        return null
    }

    setCommonValue (values)
    {
        this.value = this._commonValue(values)

        return this
    }
}