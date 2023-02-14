import { randomInt } from '@/Utils/Number'
import EventListener from '@/Classes/EventListener'



export default class Tab extends EventListener
{
    constructor (options = null)
    {
        super()

        // Valid tab types
        this.tabTypes = ['tab']

        // Basic data
        this.localId = null
        this.type = 'tab'
        this.active = false
        this.history = []
        
        // Generate tab ID
        this.generateId()
        
        // Page data
        this.title = null

        return this
    }



    generateId()
    {
        this.localId = 'LID-'+randomInt(0, 9999999999).toString().padStart(10, '0')

        return this
    }

    setType(type)
    {
        if (!this.tabTypes.includes(type))
        {
            throw new Error('Invalid tab type')
        }

        this.type = type

        return this
    }



    get icon ()
    {
        return 'layers'
    }
}