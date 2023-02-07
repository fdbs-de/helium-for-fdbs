import Snapshot from '@/Classes/Apps/Pages/History/Snapshot'
import EventListener from '@/Classes/EventListener'



export default class History extends EventListener
{
    constructor(options = {})
    {
        super()

        this.snapshots = []
        this.max = options?.maxSteps ?? 100

        return this
    }



    takeSnapshot()
    {
        let snapshot = new Snapshot()

        this.snapshots.unshift(snapshot)

        if (this.snapshots.length > this.max)
        {
            this.snapshots.pop()
        }

        return snapshot
    }
}