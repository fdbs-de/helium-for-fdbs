// Class Item
// Description: Media Library Item (file or directory)

export default class Item
{
    _path
    _mime
    _size
    _url
    _media
    _origin
    _visualDictionary = {
        'generic': { icon: 'widgets', color: '#57606f' },

        'folder.generic': { icon: 'folder', color: '#2f3542' },

        'image.vector': { icon: 'polyline', color: '#e84393' },
        'image.generic': { icon: 'landscape', color: '#3498db' },

        'video.generic': { icon: 'videocam', color: '#8e44ad' },
        'audio.generic': { icon: 'music_note', color: '#F79F1F' },

        'application.pdf': { icon: 'category', color: '#F40F02' },
        
        'text.plain': { icon: 'notes', color: '#747d8c' },
        'text.css': { icon: 'css', color: '#264de4' },
        'text.generic': { icon: 'notes', color: '#747d8c' },

        'document.text': { icon: 'subject', color: '#185abd' },
        'document.spreadsheet': { icon: 'grid_on', color: '#1D6F42' },
        'document.presentation': { icon: 'slideshow', color: '#c43f1d' },
    }

    constructor (item, origin = null)
    {
        this._path   = item.path   || ''
        this._mime   = item.mime   || null
        this._size   = item.size   || 0
        this._url    = item.url    || null
        this._media  = item.media  || null
        this._origin = origin      || window.location.origin || ''

    }

    get path ()
    {
        let path = this._path.split('/')
        let filename = path[path.length - 1]
        let extension = filename.split('.').pop()
        let name = filename.substring(0, filename.length - extension.length - 1)

        return {
            path: this._path,
            filename,
            extension,
            name,
            url: new URL(this.url, this._origin).href,
        }
    }

    get mime ()
    {
        let mime = this._mime.split('/') || []

        return {
            string: mime.join('/'),
            type: mime[0] || null,
            subtype: mime[1] || null,
        }
    }

    get size ()
    {
        return this._size
    }

    get url ()
    {
        return this._url
    }

    get media ()
    {
        return this._media
    }

    get visual ()
    {
        if (this.mime.type === 'folder') return this._visualDictionary['folder.generic']
        
        if (this.mime.subtype === 'svg+xml') return this._visualDictionary['image.vector']
        if (this.mime.type === 'image') return this._visualDictionary['image.generic']

        if (this.mime.subtype === 'plain') return this._visualDictionary['text.plain']
        if (this.mime.subtype === 'css') return this._visualDictionary['text.css']
        if (this.mime.type === 'text') return this._visualDictionary['text.generic']
        
        if (this.mime.subtype === 'pdf') return this._visualDictionary['application.pdf']
        if (this.mime.subtype === 'vnd.openxmlformats-officedocument.wordprocessingml.document') return this._visualDictionary['document.text']
        if (this.mime.subtype === 'vnd.oasis.opendocument.text') return this._visualDictionary['document.text']
        if (this.mime.subtype === 'vnd.openxmlformats-officedocument.spreadsheetml.sheet') return this._visualDictionary['document.spreadsheet']
        if (this.mime.subtype === 'vnd.openxmlformats-officedocument.presentationml.presentation') return this._visualDictionary['document.presentation']
        if (this.mime.type === 'application') return this._visualDictionary['generic']

        if (this.mime.type === 'video') return this._visualDictionary['video.generic']
        if (this.mime.type === 'audio') return this._visualDictionary['audio.generic']
        return this._visualDictionary['generic']
    }
}