import Fixture from '@/Classes/Apps/Pages/Fixtures/Fixture.js'



export default class LayoutFixture extends Fixture
{
    constructor (label)
    {
        super()

        this.label = label
        this.type = 'layout'
        this.value = {
            'flex-direction': 'row',
            'flex-wrap': 'nowrap',
            'justify-content': 'flex-start',
            'align-items': 'flex-start',
            'gap': ['', ''],
        }

        return this
    }



    set flexDirection (value)
    {
        // Swap align-items and justify-content if the flex-direction changes
        if (value !== this.value['flex-direction'])
        {
            [this.value['align-items'], this.value['justify-content']] = [this.value['justify-content'], this.value['align-items']]
        }
        
        // Set the new flex-direction
        this.value['flex-direction'] = value
    }

    get flexDirection ()
    {
        return this.value['flex-direction']
    }



    get matrix ()
    {
        let xDict = {
            'flex-start': 'left',
            'center': 'center',
            'flex-end': 'right',
        }

        let yDict = {
            'flex-start': 'top',
            'center': 'center',
            'flex-end': 'bottom',
        }

        
        if (this.value['flex-direction'] === 'row')
        {
            let xAlign = xDict[this.value['justify-content']]
            let yAlign = yDict[this.value['align-items']]
            
            return `${xAlign}:${yAlign}`
        }
        else
        {
            let xAlign = yDict[this.value['justify-content']]
            let yAlign = xDict[this.value['align-items']]

            return `${yAlign}:${xAlign}`
        }

    }

    set matrix (value)
    {
        let dict = {
            'left': 'flex-start',
            'center': 'center',
            'right': 'flex-end',
            'top': 'flex-start',
            'center': 'center',
            'bottom': 'flex-end',
        }
        
        let [xAlign, yAlign] = value.split(':')

        if (this.value['flex-direction'] === 'row')
        {
            this.value['align-items'] = dict[yAlign]
            this.value['justify-content'] = dict[xAlign]
        }
        else
        {
            this.value['align-items'] = dict[xAlign]
            this.value['justify-content'] = dict[yAlign]
        }
    }
}