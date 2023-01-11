export default class PostCategory
{
    _item
    _statusDictionary = {
        'draft': { id: 'draft', icon: 'draft', color: 'var(--color-text)', tooltip: 'Entwurf' },
        'pending': { id: 'pending', icon: 'forum', color: 'var(--color-yellow)', tooltip: 'Zur Freigabe' },
        'published': { id: 'published', icon: 'public', color: 'var(--color-green)', tooltip: 'Veröffentlicht' },
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
        return this._item?.name
    }

    get slug ()
    {
        return this._item?.slug
    }

    get scope ()
    {
        return this._item?.scope
    }

    get color ()
    {
        return this._item?.color
    }

    get icon ()
    {
        return this._item?.icon
    }

    get status ()
    {
        return this._item?.status
    }

    get description ()
    {
        return this._item?.description
    }

    get image ()
    {
        return this._item?.image
    }

    get displayMetadata ()
    {
        return {
            texts: [
                `${this._item?.posts_count} Verwendungen`,
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
            icon: this._item?.icon || 'category',
            color: this._item?.color || 'var(--color-text)',
            tooltip: 'Kategorie'
        }
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