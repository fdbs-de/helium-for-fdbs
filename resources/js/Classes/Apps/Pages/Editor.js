import Tab from '@/Classes/Apps/Pages/Tab'

export default class Editor
{
    constructor(options = {})
    {
        this.breakpoints = [
            {
                id: 0,
                name: 'Desktop',
                icon: 'desktop_windows',
                width: 1920,
                height: 1080,
                orientation: 'landscape',
                default: true,
                touch: false
            },
            {
                id: 1,
                name: 'Laptop',
                icon: 'computer',
                width: 912,
                height: 1024,
                orientation: 'landscape',
                touch: false
            },
            {
                id: 2,
                name: 'Mobile (Landscape)',
                icon: 'stay_current_landscape',
                width: 740,
                height: 360,
                orientation: 'landscape',
                touch: true
            },
            {
                id: 3,
                name: 'Mobile (Portrait)',
                icon: 'stay_current_portrait',
                width: 360,
                height: 740,
                orientation: 'portrait',
                touch: true
            }
        ]
    
        this.tabs = []
        this.tab = null
        this.options = {
            openNewOnLaunch: options.openNewOnLaunch || false,
            openNewOnLastClose: options.openNewOnLastClose || false,
        }



        // Open new tab on launch
        if (this.options.openNewOnLaunch) this.openBlankTab()
    }



    // START: Getters
    get hasBlankTab()
    {
        return this.tabs.find(tab => tab.type == 'new-tab') != null
    }



    // START: Methods
    addTab(type, data = {}, selectImmediately = false)
    {
        let tab = new Tab(type, data)

        this.tabs.push(tab)

        if (selectImmediately) this.selectTab(tab.id)

        return tab
    }

    openBlankTab()
    {
        // There should only ever be one blank tab
        if (this.tabs.find(tab => tab.type == 'new-tab')) return false

        // Add new blank tab
        this.addTab('new-tab', {
            title: 'Create new or open...',
        }, true)

        return true
    }

    selectTab(id)
    {
        // Deselect current tab
        if (this.tab) this.tab.active = false

        // Find new tab
        this.tab = this.tabs.find(tab => tab.id == id) || null

        // Select new tab
        if (this.tab) this.tab.active = true
    }

    closeTab(id, selectNextBest = true)
    {
        let tabIndex = this.tabs.findIndex(tab => tab.id == id)

        if (tabIndex < 0) return false

        // Remove from tabs
        this.tabs.splice(tabIndex, 1)

        // In case the tab was selected, clear it
        if (this.tab && this.tab.id == id) this.tab = null
        
        // Fire close event
        this._onTabCloseEvent()



        // return if we don't want to select the next best tab
        if (!selectNextBest) return true

        // return if there are no more tabs
        if (this.tabs.length <= 0) return true



        // If the closed tab wasn't the first in the list, select the one before it
        if (tabIndex > 0) tabIndex-- 

        // Select the next best tab
        this.selectTab(this.tabs[tabIndex].id)

        // Return success
        return true
    }
    // END: Methods



    // START: Events
    _onTabCloseEvent()
    {
        if (this.options.openNewOnLastClose && this.tabs.length <= 0) this.openBlankTab()
    }
    // END: Events
}