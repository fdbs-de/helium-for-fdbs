import Tab from '@/Classes/Editor/Tab'
import EventListener from '@/Classes/EventListener'



export default class Editor extends EventListener
{
    constructor()
    {
        super()
    
        this.title = 'Editor'
        this.tabs = []
        this.tab = null
        this.options = {}

        this.setOption('selectNextBestTab', true)

        return this
    }



    setTitle(title)
    {
        this.title = title

        return this
    }



    setOption(key, value)
    {
        this.options[key] = value

        return this
    }



    addTab(tab, selectImmediately = false)
    {
        this.tabs.push(tab)

        if (selectImmediately) this.selectTab(tab.localId)

        return this
    }

    selectTab(id)
    {
        // Deselect current tab
        if (this.tab) this.tab.active = false

        // Find new tab
        this.tab = this.tabs.find(tab => tab.localId == id) || null

        // Select new tab
        if (this.tab) this.tab.active = true
    }

    selectTabByIndex(index)
    {
        if (index < 0 || index >= this.tabs.length) return false

        this.selectTab(this.tabs[index].localId)
    }

    selectPreviousTab()
    {
        if (!this.tab) return false

        let tabIndex = this.tabs.findIndex(tab => tab.localId == this.tab.localId)

        this.selectTabByIndex(tabIndex - 1)
    }

    selectNextTab()
    {
        if (!this.tab) return false

        let tabIndex = this.tabs.findIndex(tab => tab.localId == this.tab.localId)

        this.selectTabByIndex(tabIndex + 1)
    }

    closeTab(id)
    {
        let tabIndex = this.tabs.findIndex(tab => tab.localId == id)

        if (tabIndex < 0) return false

        // Remove from tabs
        this.tabs.splice(tabIndex, 1)

        // In case the tab was selected, clear it
        if (this.tab && this.tab.localId == id) this.tab = null
        
        // Fire close event
        this.dispatchEvent('tab:close', { id })



        // return if we don't want to select the next best tab
        if (!this.options.selectNextBestTab) return true

        // return if there are no more tabs
        if (this.tabs.length <= 0) return true



        // If the closed tab wasn't the first in the list, select the one before it
        if (tabIndex > 0) tabIndex-- 

        // Select the next best tab
        this.selectTab(this.tabs[tabIndex].localId)

        // Return success
        return true
    }
}