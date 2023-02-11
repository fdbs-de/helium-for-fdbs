import EventListener from '@/Classes/EventListener'
import { randomInt } from '@/Utils/Number'



export default class FormInput extends EventListener
{
    constructor ()
    {
        super()

        // Valid input types
        this.inputTypes = ['text', 'email', 'tel', 'password', 'number', 'textarea', 'select', 'checkbox', 'radio']

        // Basic data
        this.localId = null
        
        // Generate local ID
        this.generateId()
        
        // Input specific data
        this.id = null
        this.type = 'text'
        this.key = ''
        this.validation = {
            errorMessage: '',
            required: false,
            min: null,
            max: null,
        }
        this.options = {
            label: '',
            placeholder: '',
            helpText: '',
            step: 1,
            options: [],
            ariaLabel: '',
        }

        return this
    }



    generateId()
    {
        this.localId = 'LID-'+randomInt(0, 9999999999).toString().padStart(10, '0')

        return this
    }



    get inputType()
    {
        return this.type
    }

    set inputType(type)
    {
        if (!this.inputTypes.includes(type))
        {
            throw new Error(`Invalid input type: ${type}`)
        }

        this.type = type
    }



    get icon()
    {
        switch (this.type)
        {
            case 'text': return 'input'
            case 'email': return 'email'
            case 'tel': return 'phone'
            case 'password': return 'lock'
            case 'number': return 'unfold_more'
            case 'textarea': return 'notes'
            case 'select': return 'checklist'
            case 'checkbox': return 'check_box'
            case 'radio': return 'radio_button_checked'
        }
    }



    hydrate(data)
    {
        this.id = data.id
        this.type = data.type
        this.key = data.key
        this.validation = data.validation || {}
        this.options = data.options || {}

        return this
    }

    serialize()
    {
        return {
            id: this.id,
            type: this.type,
            key: this.key,
            validation: this.validation,
            options: this.options,
        }
    }
}