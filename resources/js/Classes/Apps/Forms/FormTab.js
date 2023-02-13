import Tab from '@/Classes/Editor/Tab'
import FormPage from '@/Classes/Apps/Forms/FormPage'
import FormAction from '@/Classes/Apps/Forms/FormAction'



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

        this.selection = {
            page: null,
            input: null,
            action: null,
        }

        return this
    }



    selectAction(action)
    {
        this.selection.action = action
        this.selection.page = null
        this.selection.input = null

        return this
    }

    selectPage(page)
    {
        this.selection.action = null
        this.selection.page = page
        this.selection.input = null

        return this
    }

    selectInput(input)
    {
        this.selection.action = null
        this.selection.page = null
        this.selection.input = this.selection.input == input ? null : input

        return this
    }



    addPage(page)
    {
        this.pages.push(page)

        return this
    }

    removePage(page)
    {
        this.pages = this.pages.filter(p => p.localId != page.localId)

        if (this.selection.page == page) this.selection.page = null

        return this
    }



    removeInput(input)
    {
        for (let page of this.pages)
        {
            page.removeInput(input)
        }

        if (this.selection.input == input) this.selection.input = null

        return this
    }



    addAction(action)
    {
        this.actions.push(action)

        return this
    }

    removeAction(action)
    {
        this.actions = this.actions.filter(a => a.localId != action.localId)

        if (this.selection.action == action) this.selection.action = null

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

        for (let page of data.pages)
        {
            this.addPage(new FormPage().hydrate(page))
        }

        for (let action of data.actions)
        {
            this.addAction(new FormAction().hydrate(action))
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