import EventListener from '@/Classes/EventListener'
import { randomInt } from '@/Utils/Number'



export default class FormAction extends EventListener
{
    constructor ()
    {
        super()

        // Valid input types
        this.actionTypes = ['send-mail', 'show-message']

        // Basic data
        this.localId = null
        
        // Generate local ID
        this.generateId()
        
        // Input specific data
        this.id = null
        this.type = 'send-mail'
        this.options = {
            mail: {
                to: '',
                cc: '',
                bcc: '',
                replyTo: '',
                replyToName: '',
                subject: '',
                message: '',
            },
            message: {
                title: '',
                message: '',
            },
        }

        return this
    }



    generateId()
    {
        this.localId = 'LID-'+randomInt(0, 9999999999).toString().padStart(10, '0')

        return this
    }



    get actionType()
    {
        return this.type
    }

    set actionType(type)
    {
        if (!this.actionTypes.includes(type))
        {
            throw new Error(`Invalid action type: ${type}`)
        }

        this.type = type
    }



    hydrate(data)
    {
        this.id = data.id
        this.type = data.type
        this.options = data.options || {}

        return this
    }

    serialize()
    {
        return {
            id: this.id,
            type: this.type,
            options: this.options,
        }
    }
}