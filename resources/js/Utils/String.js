export function capitalizeWords(str)
{
    return (str ?? '').replace(/\w\S*/g, function(txt) {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()
    })
}

export function replaceUmlauts(string)
{
    const umlautMap = {
        '\u00dc': 'UE',
        '\u00c4': 'AE',
        '\u00d6': 'OE',
        '\u00fc': 'ue',
        '\u00e4': 'ae',
        '\u00f6': 'oe',
        '\u00df': 'ss',
    }

    return string
        .replace(/[\u00dc|\u00c4|\u00d6][a-z]/g, (a) => {
            const big = umlautMap[a.slice(0, 1)];
            return big.charAt(0) + big.charAt(1).toLowerCase() + a.slice(1);
        })
        .replace(new RegExp('[' + Object.keys(umlautMap).join('|') + ']', "g"),
            (a) => umlautMap[a]
        )
}

export function slugify(string)
{
    return replaceUmlauts(string.toString())
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