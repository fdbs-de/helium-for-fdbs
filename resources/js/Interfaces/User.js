export default class User
{
    _item
    _visualDictionary = {
        'super-admin': { id: 'super-admin', icon: 'local_police', color: 'var(--color-primary)', tooltip: 'Super Admin' },
        'admin': { id: 'admin', icon: 'shield', color: 'var(--color-primary)', tooltip: 'Admin' },
        'editor': { id: 'editor', icon: 'design_services', color: '#8854d0', tooltip: 'Editor' },
        'registered': { id: 'registered', icon: 'person', color: 'var(--color-text)', tooltip: 'Registriert' },
        'unknown': { id: 'unknown', icon: 'help', color: 'var(--color-text)', tooltip: 'Unbekannt' },
    }

    constructor (item)
    {
        this._item = item || {}
    }

    
    
    get mostProminentRole ()
    {
        let roles = this._item?.roles?.map(role => role.name)
        
        if (roles.includes('Super Admin')) return 'super-admin'
        if (roles.includes('Admin')) return 'admin'
        if (roles.includes('Editor')) return 'editor'
        return 'registered'
    }


    
    get id ()
    {
        return this._item?.id || null
    }



    get name ()
    {
        return this._item?.name || 'Name unbekannt'
    }



    get image ()
    {
        return this._item?.image || null
    }



    get displayMetadata ()
    {
        return {
            texts: [
                this._item?.email || 'E-Mail unbekannt'
            ],

            icons: [
                { id: 'email', icon: 'mail', tooltip: 'Email Bestätigung', color: this._item?.email_verified_at ? 'var(--color-primary)' :'var(--color-text)'},
                { id: 'enabled', icon: 'check_circle', tooltip: 'Freigabe', color: this._item?.is_enabled ? 'var(--color-primary)' : 'var(--color-text)'},
                { id: 'customer', icon: 'shopping_cart', tooltip: 'Kunden-Profil', color: this._item?.profiles?.customer ? 'var(--color-primary)' : 'var(--color-text)'},
                { id: 'employee', icon: 'work', tooltip: 'Mitarbeiter-Profil', color: this._item?.profiles?.employee ? 'var(--color-primary)' : 'var(--color-text)' },
            ],
        }
    }



    get displayVisual ()
    {
        return {
            ...(this._visualDictionary[this.mostProminentRole] || this._visualDictionary['unknown']),
            tooltip: this._item?.roles?.map(role => role.name).join(' • ') || 'Registriert',
        }
    }



    get displayActions ()
    {
        return [
            [
                { id: 'open', icon: 'visibility', tooltip: 'Details', color: 'var(--color-text)', action: 'open' },
                // { id: 'duplicate', icon: 'content_copy', tooltip: 'Duplizieren', color: 'var(--color-text)', action: 'duplicate' },
            ],
            // [
            //     { id: 'delete', icon: 'delete', tooltip: 'Löschen', color: 'var(--color-error)', action: 'delete' },
            // ]
        ]
    }
}