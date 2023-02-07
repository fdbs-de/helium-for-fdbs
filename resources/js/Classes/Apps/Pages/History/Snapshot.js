



export default class Snapshot
{
    constructor(data)
    {
        this.data = data
        this.timestamp = Date.now()
        this.saved = false
        this.current = false

        return this
    }
}