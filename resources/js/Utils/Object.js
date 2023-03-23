export function walkObject (object, objectPath)
{
    let path = objectPath.split('.')
    let value = object

    for (let i = 0; i < path.length; i++)
    {
        value = value[path[i]]

        if (value === undefined)
        {
            return undefined
        }
    }

    return value
}



export function commonValue (array)
{
    if (array.length === 0) return undefined

    let value = array[0]

    if (array.some(v => v !== value)) return undefined

    return value
}