import EventListener from '@/Classes/EventListener'
import { randomInt } from '@/Utils/Number'



export default class FormInput extends EventListener
{
    constructor ()
    {
        super()

        // Type register
        this.types = {
            input: ['text', 'select', 'checkbox', 'radio', 'acceptance'],
            text: ['text', 'email', 'tel', 'password', 'number', 'textarea'],
        }

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
            type: 'text',
            defaultValue: '',
            label: 'New Input',
            ariaLabel: '',
            placeholder: '',
            helpText: '',
            description: '',
            step: 1,
            options: [],
        }
        this.editorMeta = {
            expanded: false,
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
        if (!this.types.input.includes(type))
        {
            throw new Error(`Invalid input type: ${type}`)
        }
        
        this.type = type
    }

    isType(types)
    {
        if (!Array.isArray(types)) types = [types]
        
        return types.includes(this.type)
    }

    isSubtype(types)
    {
        if (!Array.isArray(types)) types = [types]

        return types.includes(this.options.type)
    }
    


    get hasFixtures()
    {
        return {
            textSubtypes: this.isType('text'),

            defaultTextValue: this.isType(['text',]),
            defaultBooleanValue: this.isType(['acceptance',]),
            label: this.isType(['text', 'select', 'checkbox', 'radio', 'acceptance',]),
            ariaLabel: this.isType(['text', 'select', 'checkbox', 'radio', 'acceptance',]),
            placeholder: this.isType(['text', 'select',]),
            helpText: this.isType(['text', 'select',]),
            description: this.isType(['acceptance',]),
            options: this.isType(['select', 'radio',]),
            step: this.isType('text') && this.isSubtype('number'),
            
            errorMessage: true,
            required: this.isType(['text', 'select', 'checkbox', 'radio', 'acceptance',]),
            min: this.isType('text') && this.isSubtype('number'),
            max: this.isType('text') && this.isSubtype('number'),
        }
    }



    get icon()
    {
        switch (this.type)
        {
            case 'text': return 'notes'
            case 'select': return 'checklist'
            case 'checkbox': return 'check_box'
            case 'radio': return 'radio_button_checked'
            case 'acceptance': return 'policy'
        }
    }



    addOption(label = '', value = '')
    {
        this.options.options.push({
            label,
            value,
            selected: false,
        })

        return this
    }

    removeOption(index)
    {
        this.options.options.splice(index, 1)

        return this
    }

    toggleDefaultOption(index)
    {
        this.options.options.forEach((option, i) => {
            option.selected = (i == index) && !option.selected
        })

        return this
    }



    toggleExpanded()
    {
        this.editorMeta.expanded = !this.editorMeta.expanded

        return this
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