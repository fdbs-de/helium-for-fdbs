import EventListener from '@/Classes/EventListener'
import { randomInt } from '@/Utils/Number'



export default class FormInput extends EventListener
{
    constructor ()
    {
        super()

        // Basic data
        this.localId = null
        
        // Generate local ID
        this.generateId()
        
        // Input specific data
        this.id = null
        this.type = null
        this.key = null
        this.validation = {}
        this.options = {}

        return this
    }



    generateId()
    {
        this.local = 'LID-'+randomInt(0, 9999999999).toString().padStart(10, '0')

        return this
    }



    hydrate(data)
    {
        this.type = data.type
        this.key = data.key
        this.validation = data.validation
        this.options = data.options

        return this
    }

    serialize()
    {
        return {
            type: this.type,
            key: this.key,
            validation: this.validation,
            options: this.options,
        }
    }
}