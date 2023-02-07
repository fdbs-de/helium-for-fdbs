export default class EventListener
{
    constructor()
    {
        this.__listeners = {}
    }



    addEventListener(eventName, handler)
    {
        // Create the event name if it doesn't exist
        if (!this.__listeners[eventName])
        {
            this.__listeners[eventName] = []
        }

        // Add the handler to the event name
        this.__listeners[eventName].push(handler)

        return this
    }

    removeEventListener(eventName, handler)
    {
        // Return if the event name doesn't exist
        if (!this.__listeners[eventName]) return this

        // Remove the handler from the event name
        this.__listeners[eventName] = this.__listeners[eventName].filter((h) => h !== handler)

        // Remove the event name if there are no more listeners
        if (this.__listeners[eventName].length === 0)
        {
            delete this.__listeners[eventName]
        }

        return this
    }

    dispatchEvent(eventName, data)
    {
        // Return if the event name doesn't exist
        if (!this.__listeners[eventName]) return this

        // Call all handlers for the event name
        for (let handler of this.__listeners[eventName])
        {
            handler(data)
        }

        return this
    }
}