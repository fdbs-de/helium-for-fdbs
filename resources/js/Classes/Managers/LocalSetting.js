



export default class LocalSetting
{
    static get(scope, key, defaultValue = null)
    {
        return JSON.parse(localStorage?.getItem(scope+':'+key)) || defaultValue
    }

    static set(scope, key, value)
    {
        localStorage?.setItem(scope+':'+key, JSON.stringify(value))
    }

    static reset(scope, key)
    {
        localStorage?.removeItem(scope+':'+key)
    }

    static resetAll(scope)
    {
        for (let key in localStorage || {})
        {
            if (!key.startsWith(scope+':')) continue
            
            localStorage?.removeItem(key)
        }
    }
}