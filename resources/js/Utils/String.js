export function capitalizeWords(str)
{
    return (str ?? '').replace(/\w\S*/g, function(txt) {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()
    })
}

export function slugify(string)
{
    return string
        .toString()
        .normalize('NFKD')
        .toLowerCase()
        .trim()
        .replace(/\s+/g, '-')
        .replace(/[^\w\-]+/g, '')
        .replace(/\-\-+/g, '-')
}

export function firstname(string)
{
    return string.split(' ')[0]
}

export function lastname(string)
{
    return string.split(' ').slice(-1)[0]
}

export function firstCharacters(string, length)
{
    if (string.length > length)
    {
        return string.slice(0, length) + '…'
    }

    return string
}

export function lastCharacters(string, length)
{
    if (string.length > length)
    {
        return '…' + string.slice(-length)
    }

    return string
}

export function fileSize(size)
{
    var i = size == 0 ? 0 : Math.floor(Math.log(size) / Math.log(1024));
    return (size / Math.pow(1024, i)).toFixed(1) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
}