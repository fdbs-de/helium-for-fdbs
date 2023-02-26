import { useForm } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import _ from 'lodash'
import axios from 'axios'

import LocalSetting from '@/Classes/Managers/LocalSetting'
import EventListener from '@/Classes/EventListener'



export default class ItemPageManager extends EventListener
{
    constructor(options = {})
    {
        super()

        this.items = []
        this.selection = []
        this.processing = false
        this.scope = options.scope ?? null
        this.filter = {
            search: LocalSetting.get(this.scope, 'filter.search', ''),
        }
        this.sort = {
            field: LocalSetting.get(this.scope, 'sort.field', null),
            order: LocalSetting.get(this.scope, 'sort.order', 'desc'),
        }
        this.pagination = {
            page: LocalSetting.get(this.scope, 'pagination.page', 1),
            size: LocalSetting.get(this.scope, 'pagination.size', 20),
            total: 0,
        }
        this.options = {
            pageTitle: options?.pageTitle ?? 'Items',
            routes: {
                fetch: options?.routes?.fetch ?? null,
                store: options?.routes?.store ?? null,
                editor: options?.routes?.editor ?? null,
                duplicate: options?.routes?.duplicate ?? null,
                delete: options?.routes?.delete ?? null,
            },
            view: {
                layout: options?.view?.layout ?? 'list',
                showPreview: options?.view?.showPreview ?? false,
            }
        }

        return this
    }



    get tableScope()
    {
        return this.scope + '.table'
    }



    get modelFilter()
    {
        return this.filter
    }

    set modelFilter(value)
    {
        this.filter = {
            ...this.filter,
            ...value,
        }

        this.throttledFetch()

        LocalSetting.set(this.scope, 'filter.search', this.filter.search)
    }



    get modelSort()
    {
        return this.sort
    }

    set modelSort(value)
    {
        this.sort = {
            ...this.sort,
            ...value,
        }

        this.throttledFetch()

        LocalSetting.set(this.scope, 'sort.field', this.sort.field)
        LocalSetting.set(this.scope, 'sort.order', this.sort.order)
    }



    get modelPagination()
    {
        return this.pagination
    }

    set modelPagination(value)
    {
        this.pagination = {
            ...this.pagination,
            ...value,
        }

        this.throttledFetch()

        LocalSetting.set(this.scope, 'pagination.page', this.pagination.page)
        LocalSetting.set(this.scope, 'pagination.size', this.pagination.size)
    }



    async fetch()
    {
        this.processing = true

        try
        {
            let response = await axios.get(route(this.options.routes.fetch, {...this.filter, ...this.sort, ...this.pagination}))

            if (!response?.data) throw new Error('No data returned')

            this.items = response?.data?.data ?? []
            this.pagination.total = response?.data?.total ?? 0
        }
        catch (error)
        {
            console.error(error)
        }
        
        this.processing = false
    }

    throttledFetch = _.throttle(this.fetch, 300)



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
        this.selection = this.items.map(i => i.id)
    }

    deselectAll()
    {
        this.selection = []
    }



    open(id = null) {
        Inertia.visit(route(this.options.routes.editor, id))
    }



    openMultiple(ids = null, parameterName = 'ids') {
        if (!ids) ids = this.selection

        if (typeof ids !== 'object') ids = [ids].filter(id => id)

        if (!ids.length) return



        let parameters = {}

        parameters[parameterName] = ids

        

        Inertia.visit(route(this.options.routes.editor), { data: parameters })
    }



    store(data) {
        useForm(data).post(route(this.options.routes.store), {
            preserveScroll: true,
            onSuccess: () => {
                this.fetch()
                this.dispatchEvent('store', data)
            },
        })
    }



    duplicate(id) {
        useForm().post(route(this.options.routes.duplicate, id), {
            onSuccess: () => {
                this.fetch()
                this.dispatchEvent('duplicate', id)
            },
        })
    }



    delete(ids = null, message = 'Are you sure you want to delete the selected items?') {
        if (!ids) ids = this.selection

        if (typeof ids !== 'object') ids = [ids].filter(id => id)

        if (!ids.length) return

        if (!confirm(replaceVariable(message))) return

        useForm({ ids }).delete(route(this.options.routes.delete), {
            onSuccess: () => {
                this.deselectAll()
                this.fetch()
                this.dispatchEvent('delete', ids)
            },
        })



        function replaceVariable(string)
        {
            return string.replace('{{count}}', ids.length)
        }
    }
}