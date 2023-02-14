import EventListener from '@/Classes/EventListener'
import { randomInt } from '@/Utils/Number'
import FormInput from '@/Classes/Apps/Forms/FormInput'



export default class FormPage extends EventListener
{
    constructor ()
    {
        super()

        // Basic data
        this.localId = null
        
        // Generate local ID
        this.generateId()
        
        // Page data
        this.id = null
        this.title = ''
        this.inputs = []

        return this
    }



    generateId()
    {
        this.localId = 'LID-'+randomInt(0, 9999999999).toString().padStart(10, '0')

        return this
    }



    addInput(input)
    {
        this.inputs.push(input)

        return this
    }

    removeInput(input)
    {
        this.inputs = this.inputs.filter(i => i.localId != input.localId)

        return this
    }



    hydrate(data)
    {
        this.id = data.id
        this.title = data.title

        this.inputs = []
        for (let input of data.inputs)
        {
            this.addInput(new FormInput().hydrate(input))
        }

        return this
    }

    serialize()
    {
        return {
            id: this.id,
            title: this.title,
            inputs: this.inputs.map(input => input.serialize()),
        }
    }
}