import { randomInt } from '@/Utils/Number'
import EventListener from '@/Classes/EventListener'



export default class Tab extends EventListener
{
    constructor (options = null)
    {
        super()

        // Basic data
        this.localId = null
        this.type = 'open'
        this.active = false
        this.title = null
        
        // Generate tab ID
        this.setLocalId(this.generateLocalId())

        return this
    }



    generateLocalId()
    {
        return 'LID-' + randomInt(0, 9999999999).toString().padStart(10, '0')
    }

    setLocalId(localId = null)
    {
        this.localId = localId

        return this
    }



    get icon ()
    {
        return 'grade'
    }



    setTitle(title)
    {
        this.title = title

        return this
    }
}