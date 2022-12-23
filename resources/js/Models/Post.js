export default class Post
{
    _id
    _scope
    _status
    _title
    _category
    _content
    _image
    _pinned
    _visualDictionary = {
        'blog': { id: 'blog', icon: 'public', color: '#1e90ff', tooltip: 'Blog' },
        'wiki': { id: 'wiki', icon: 'travel_explore', color: '#ff6348', tooltip: 'Wiki' },
        'intranet': { id: 'intranet', icon: 'policy', color: '#8854d0', tooltip: 'Intranet' },
        'jobs': { id: 'jobs', icon: 'work', color: '#e00047', tooltip: 'Jobs' },
        'unknown': { id: 'unknown', icon: 'help', color: 'var(--color-text)', tooltip: 'Unbekannt' },
    }
    _statusDictionary = {
        'draft': { id: 'draft', icon: 'add_circle', color: 'var(--color-text)', tooltip: 'Entwurf' },
        'pending': { id: 'pending', icon: 'schedule', color: 'var(--color-warning)', tooltip: 'Zur Freigabe' },
        'published': { id: 'published', icon: 'public', color: 'var(--color-info)', tooltip: 'Veröffentlicht' },
        'hidden': { id: 'hidden', icon: 'block', color: 'var(--color-error)', tooltip: 'Versteckt' },
        'unknown': { id: 'unknown', icon: 'help', color: 'var(--color-text)', tooltip: 'Unbekannt' },
    }

    constructor (post)
    {
        this._id = post.id || null
        this._scope = post.scope || null
        this._status = post.status || null
        this._title = post.title || ''
        this._category = post.category || ''
        this._content = post.content || ''
        this._image = post.image || null
        this._pinned = post.pinned || false
    }
    
    get id ()
    {
        return this._id
    }

    get scope ()
    {
        return this._scope
    }

    get status ()
    {
        if (Object.keys(this._statusDictionary).includes(this._status)) return this._statusDictionary[this._status]
        else return this._statusDictionary['unknown']
    }

    get title ()
    {
        return this._title
    }

    get category ()
    {
        return this._category ? this._category : {id: null, name: 'Keine Kategorie'}
    }

    get content ()
    {
        return this._content
    }

    get image ()
    {
        return this._image
    }

    get pinned ()
    {
        return this._pinned
    }

    get visual ()
    {
        if (Object.keys(this._visualDictionary).includes(this._scope)) return this._visualDictionary[this._scope]
        else return this._visualDictionary['unknown']
    }
}