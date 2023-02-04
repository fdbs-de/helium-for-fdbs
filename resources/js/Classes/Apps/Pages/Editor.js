import Tab from '@/Classes/Apps/Pages/Tab'

export default class Editor
{
    constructor(options = {})
    {
        this.breakpoints = [
            {
                id: 0,
                name: 'Desktop',
                tooltip: '<b>Desktop</b><br>\> 1100px',
                icon: 'monitor',
                width: null,
                height: null,
                orientation: 'landscape',
                default: true,
                touch: false,
            },
            {
                id: 1,
                name: 'Laptop',
                tooltip: '<b>Laptop</b><br>< 1100px',
                icon: 'computer',
                width: 1100,
                height: null,
                orientation: 'landscape',
                default: false,
                touch: false,
            },
            {
                id: 2,
                name: 'Tablet',
                tooltip: '<b>Tablet</b><br>< 900px',
                icon: 'tablet_android',
                width: 900,
                height: null,
                orientation: 'portrait',
                default: false,
                touch: true,
            },
            {
                id: 3,
                name: 'Mobile Landscape',
                tooltip: '<b>Mobile Landscape</b><br>< 700px',
                icon: 'stay_current_landscape',
                width: 700,
                height: null,
                orientation: 'landscape',
                default: false,
                touch: true,
            },
            {
                id: 4,
                name: 'Mobile Portrait',
                tooltip: '<b>Mobile Portrait</b><br>< 360px',
                icon: 'stay_current_portrait',
                width: 360,
                height: null,
                orientation: 'portrait',
                default: false,
                touch: true,
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



    get hasBlankTab()
    {
        return this.tabs.find(tab => tab.type == 'new-tab') != null
    }



    selectBreakpoint(index)
    {
        // Check if index is in range
        if (index < 0 || index >= this.breakpoints.length) return false

        // Check if a tab is selected
        if (!this.tab) return false 
        
        // Set breakpoint
        this.tab.selected.breakpoint = index
        
        return true
    }

    get breakpoint()
    {
        return (
            this.breakpoints[this.tab.selected.breakpoint] ||
            this.breakpoints.find(breakpoint => breakpoint.default) ||
            null
        )
    }



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

    selectTabByIndex(index)
    {
        if (index < 0 || index >= this.tabs.length) return false

        this.selectTab(this.tabs[index].id)
    }

    selectPreviousTab()
    {
        if (!this.tab) return false

        let tabIndex = this.tabs.findIndex(tab => tab.id == this.tab.id)

        this.selectTabByIndex(tabIndex - 1)
    }

    selectNextTab()
    {
        if (!this.tab) return false

        let tabIndex = this.tabs.findIndex(tab => tab.id == this.tab.id)

        this.selectTabByIndex(tabIndex + 1)
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



    // START: Events
    _onTabCloseEvent()
    {
        if (this.options.openNewOnLastClose && this.tabs.length <= 0) this.openBlankTab()
    }
    // END: Events
}