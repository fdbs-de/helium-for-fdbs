import Editor from '@/Classes/Editor/Editor'
import PageTab from '@/Classes/Apps/Pages/PageTab'



export default class PageEditor extends Editor
{
    constructor()
    {
        super()

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

        

        this.setOption('openNewOnLaunch', false)
        this.setOption('openNewOnLastClose', false)
        this.setOption('selectNextBestTab', true)



        return this
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



    get hasBlankTab()
    {
        return this.tabs.find(tab => tab.type == 'new-tab') != null
    }

    openBlankTab(title = 'Open or create new...')
    {
        // There should only ever be one blank tab
        if (this.tabs.find(tab => tab.type == 'new-tab')) return false

        // Add new blank tab
        let tab = new PageTab('new-tab')

        // Set tab title
        tab.title = title

        // Add tab
        this.addTab(tab, true)

        return true
    }
}