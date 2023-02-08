import { useForm } from '@inertiajs/inertia-vue3'
import EventListener from '@/Classes/EventListener'



export default class IndexItemManager extends EventListener
{
    constructor(options = {})
    {
        this.items = []
        this.selection = []
        this.processing = false
        this.filter = {
            search: '',
            sort: '',
            order: ['', 'asc'],
        }
        this.pagination = {
            page: 1,
            perPage: 20,
        }
        this.options = {
            routes: {
                editor: options?.routes?.editor ?? null,
                fetch: options?.routes?.fetch ?? null,
                delete: options?.routes?.delete ?? null,
            },
            view: {
                layout: options?.view?.layout ?? 'list',
                showPreview: options?.view?.showPreview ?? false,
            }
        }
    }



    async fetchItems()
    {
        this.processing = true

        try
        {
            let response = await axios.get(route(this.options.routes.fetch, {...this.filter, ...this.pagination}))
            this.items = response.data
        }
        catch (error)
        {
            console.log(error)
        }
        
        this.processing = false
    }



    toggleSelection(item)
    {
        if (this.selection.includes(item.id))
        {
            this.selection = this.selection.filter(p => p !== item.id)
        }
        else
        {
            this.selection.push(item.id)
        }
    }

    setSelection(item)
    {
        this.selection = [item.id]
    }

    addSelection(item)
    {
        if (this.selection.includes(item.id)) return

        this.selection.push(item.id)
    }

    selectAll()
    {
        this.selection = items.map(i => i.id)
    }

    deselectAll()
    {
        this.selection = []
    }
}