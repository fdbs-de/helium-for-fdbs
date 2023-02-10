import Tab from '@/Classes/Editor/Tab'
import FormPage from '@/Classes/Apps/Forms/FormPage'



export default class FormTab extends Tab
{
    constructor (type, options = null)
    {
        super(options)

        // Valid tab types
        this.tabTypes = ['new-tab', 'form-editor']

        // Set tab type
        this.setType(type)

        // Form specific data
        this.id = null
        this.title = null
        this.status = 'draft'
        this.actions = []
        this.pages = []

        return this
    }



    addPage(page)
    {
        this.pages.push(page)

        return this
    }



    addAction(action)
    {
        this.actions.push(action)

        return this
    }




    get icon ()
    {
        if (this.type == 'new-tab') return 'layers'
        if (this.type == 'form-editor') return 'edit_square'

        return 'layers'
    }



    hydrate(data) {
        this.id = data.id
        this.title = data.name
        this.status = data.status

        for (let page of data.pages) {
            this.addPage(new FormPage().hydrate(page))
        }

        for (let action of data.actions) {
            // this.addAction(action)
        }

        return this
    }

    serialize()
    {
        return {
            id: this.id,
            title: this.title,
            status: this.status,
            pages: this.pages.map(page => page.serialize()),
            actions: this.actions.map(action => action.serialize()),
        }
    }
}