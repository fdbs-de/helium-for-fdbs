export default class Post
{
    _item

    constructor (item)
    {
        this._item = item || {}
    }
    
    get id ()
    {
        return this._item?.id
    }

    get title ()
    {
        return this._item?.title
    }

    get slug ()
    {
        return this._item?.slug
    }

    get scope ()
    {
        return this._item?.scope
    }

    get tags ()
    {
        return this._item?.tags
    }

    get image ()
    {
        return this._item?.image
    }

    get category ()
    {
        return {
            id: this._item?.category?.id || 0,
            name: this._item?.category?.name || 'Keine Kategorie',
            slug: this._item?.category?.slug || '-',
            icon: this._item?.category?.icon || 'category',
            color: this._item?.category?.color || 'gray',
        }
    }
}