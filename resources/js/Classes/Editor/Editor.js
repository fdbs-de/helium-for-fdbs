import { applyDrag } from '@/Utils/DragAndDrop'
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
        this.setOption('openNewOnLaunch', false)
        this.setOption('openNewOnLastClose', false)

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

        if (selectImmediately) this.selectTab(tab)

        return this
    }

    get hasBlankTab()
    {
        return this.tabs.find(tab => tab.type == 'open') != null
    }

    addBlankTab(title = 'Open or create new...')
    {
        // There should only ever be one blank tab
        if (this.hasBlankTab) return false

        // Add new blank tab
        let tab = new Tab()

        // Set tab title
        tab.title = title

        // Add tab
        this.addTab(tab, true)

        return true
    }



    dropTab(dropResults)
    {
        this.tabs = applyDrag(this.tabs, dropResults)
    }



    selectTab(tab)
    {
        // Deselect current tab
        if (this.tab) this.tab.active = false

        // Find new tab
        this.tab = this.tabs.find(tab_ => tab_.localId === tab.localId) || null

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



    closeTab(tab)
    {
        let tabIndex = this.tabs.findIndex(tab_ => tab_.localId == tab.localId)

        if (tabIndex < 0) return false

        // Remove from tabs
        this.tabs.splice(tabIndex, 1)

        // In case the tab was selected, clear it
        if (this.tab && this.tab.localId == tab.localId) this.tab = null
        
        // Fire close event
        this.dispatchEvent('tab:close', { id: tab.localId })



        // return if we don't want to select the next best tab
        if (!this.options.selectNextBestTab) return true

        if (this.tabs.length <= 0)
        {
            // If there are no more tabs, open a new one
            if (this.options.openNewOnLastClose) this.addBlankTab()
            
            // And return true
            return true
        }



        // If the closed tab wasn't the first in the list, select the one before it
        if (tabIndex > 0) tabIndex-- 

        // Select the next best tab
        this.selectTab(this.tabs[tabIndex])

        // Return success
        return true
    }



    getTabParamsFromUrl(url)
    {
        const urlParams = new URLSearchParams(url.search)

        return (urlParams.get('t') || '')
        .trim()
        .split('|')
        .filter(editor => editor.length > 0 && editor.indexOf('-') > 0)
        .map(editor => {
            let editorParts = editor.split('-')

            if (editorParts.length < 2) return

            return {
                id: editorParts[1],
                type: editorParts[0]
            }
        })
    }
}