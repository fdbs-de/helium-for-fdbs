export default class Post
{
    _item
    _statusDictionary = {
        'draft': { id: 'draft', icon: 'draft', color: 'var(--color-text)', tooltip: 'Entwurf' },
        'pending': { id: 'pending', icon: 'forum', color: 'var(--color-yellow)', tooltip: 'Zur Freigabe' },
        'published': { id: 'published', icon: 'check_circle', color: 'var(--color-green)', tooltip: 'Veröffentlicht' },
        'hidden': { id: 'hidden', icon: 'visibility_off', color: 'var(--color-red)', tooltip: 'Versteckt' },
        'unknown': { id: 'unknown', icon: 'help', color: 'var(--color-text)', tooltip: 'Unbekannt' },
    }

    constructor (item)
    {
        this._item = item || {}
    }
    
    get id ()
    {
        return this._item?.id
    }

    get name ()
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

    get image ()
    {
        return this._item?.image
    }

    get displayMetadata ()
    {
        return {
            texts: [
                (this._item?.category?.name || 'Keine Kategorie'),
            ],

            icons: [
                (this._statusDictionary[this._item?.status] || this._statusDictionary['unknown']),
            ],
        }
    }

    get displayVisual ()
    {
        return {
            id: 'default',
            icon: this._item?.icon || 'notes',
            color: this._item?.color || 'var(--color-text)',
            tooltip: 'Post'
        }

        return this._visualDictionary[this._item?.scope] || this._visualDictionary['unknown']
    }

    get displayActions ()
    {
        return [
            [
                { id: 'open', icon: 'visibility', tooltip: 'Details', color: 'var(--color-text)', action: 'open' },
                { id: 'duplicate', icon: 'content_copy', tooltip: 'Duplizieren', color: 'var(--color-text)', action: 'duplicate' },
            ],
            [
                { id: 'delete', icon: 'delete', tooltip: 'Löschen', color: 'var(--color-error)', action: 'delete' },
            ]
        ]
    }
}