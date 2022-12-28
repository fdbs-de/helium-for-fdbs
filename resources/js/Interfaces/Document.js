export default class Post
{
    _item
    _visualDictionary = {
        'default': { id: 'default', icon: 'landscape', color: 'var(--color-text)', tooltip: 'Dokument' },
        'unknown': { id: 'unknown', icon: 'help', color: 'var(--color-text)', tooltip: 'Unbekannt' },
    }
    _statusDictionary = {
        'customers': { id: 'draft', icon: 'shopping_cart', color: 'var(--color-primary)', tooltip: 'Nur Kunden' },
        'employees': { id: 'pending', icon: 'work', color: 'var(--color-primary)', tooltip: 'Nur Mitarbeiter' },
        'public': { id: 'public', icon: 'public', color: 'var(--color-green)', tooltip: 'Öffentlich' },
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

    get category ()
    {
        return this._item?.category
    }

    get group ()
    {
        return this._item?.group
    }

    get primary_tag ()
    {
        return this._item?.primary_tag
    }

    get tags ()
    {
        return this._item?.tags
    }

    get has_cover ()
    {
        return this._item?.has_cover
    }

    get cover_alt ()
    {
        return this._item?.cover_alt
    }

    get cover_size ()
    {
        return this._item?.cover_size
    }

    get image ()
    {
        return this._item?.has_cover ? route('docs.cover', this._item?.slug) : null
    }



    get displayMetadata ()
    {
        return {
            texts: [
                (this._item?.category || 'Keine Kategorie'),
            ],

            icons: [
                (this._statusDictionary[this._item?.group] || this._statusDictionary['public']),
            ],
        }
    }

    get displayVisual ()
    {
        return this._visualDictionary['default'] || this._visualDictionary['unknown']
    }

    get displayActions ()
    {
        return [
            [
                { id: 'open', icon: 'visibility', tooltip: 'Details', color: 'var(--color-text)', action: 'open' },
                // { id: 'download', icon: 'download', tooltip: 'herunterladen', color: 'var(--color-text)', action: 'download' },
                // { id: 'duplicate', icon: 'content_copy', tooltip: 'Duplizieren', color: 'var(--color-text)', action: 'duplicate' },
            ],
            // [
            //     { id: 'delete', icon: 'delete', tooltip: 'Löschen', color: 'var(--color-error)', action: 'delete' },
            // ]
        ]
    }
}