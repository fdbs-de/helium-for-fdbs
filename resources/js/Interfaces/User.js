export default class Post
{
    _item
    _visualDictionary = {
        'blog': { id: 'blog', icon: 'public', color: '#1e90ff', tooltip: 'Blog' },
        'wiki': { id: 'wiki', icon: 'travel_explore', color: '#ff6348', tooltip: 'Wiki' },
        'intranet': { id: 'intranet', icon: 'policy', color: '#8854d0', tooltip: 'Intranet' },
        'jobs': { id: 'jobs', icon: 'work', color: '#e00047', tooltip: 'Jobs' },
        'unknown': { id: 'unknown', icon: 'help', color: 'var(--color-text)', tooltip: 'Unbekannt' },
    }

    constructor (item)
    {
        this._item = item || {}
    }


    
    get id ()
    {
        return this._item?.id || null
    }

    get name ()
    {
        return this._item?.display_name || this._item?.email || 'Name unbekannt'
    }

    get info ()
    {
        return [
            this._item?.email || 'E-Mail unbekannt'
        ]
    }

    get visual ()
    {
        return {
            id: null,
            icon: 'person',
            color: 'var(--color-text)',
            tooltip: this._item?.name || 'Unbekannt',
            image: null,
        }
    }
}