import _ from 'lodash'
import EventListener from '@/Classes/EventListener'



export default class Fixture extends EventListener
{
    constructor()
    {
        super()

        this.label = ''
        this.type = null
        this.available = false
        this._value = null

        return this
    }



    update()
    {
        return this
    }



    serializeValue()
    {
        return this._value
    }



    onChange()
    {
        this.dispatchEvent('change')
    }

    throttledOnChange = _.throttle(this.onChange, 500)
}