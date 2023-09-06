<template>
    <Head>
        <title>{{editor.tab ? editor.tab.title : 'Neu'}} – Helium CMS</title>
    </Head>

    <div class="main-layout">
        <EditorControls
            :editor="editor"
            @new-tab="editor.addBlankTab()"
            @close-tab="editor.closeTab($event)"
            @select-tab="editor.selectTab($event)"
        />

        <template v-if="editor.tab">
            <OpenBody :tab="editor.tab" v-if="editor.tab.type === 'open'" />
            <PagesBody :tab="editor.tab" v-if="editor.tab.type === 'pages'" />
        </template>
    </div>
</template>

<script setup>
    import { Head } from '@inertiajs/inertia-vue3'
    import { ref, onMounted } from 'vue'
    import hotkeys from 'hotkeys-js'

    import Editor from '@/Classes/Editor/Editor.js'
    import PageTab from '@/Classes/Apps/Pages/PageTab.js'

    import EditorControls from '@/Pages/Apps/SharedAdmin/Editor/Partials/Controls.vue'
    import OpenBody from '@/Pages/Apps/SharedAdmin/Editor/Partials/Bodies/Open.vue'
    import PagesBody from '@/Pages/Apps/PagesAdmin/Pages/Editor/Index.vue'



    const editor = ref(new Editor().setTitle('Editor').setOption('openNewOnLastClose', true))
    const availableEditors = ['pages']



    // START: Fetch Tabs
    onMounted(() => {
        // get url params
        let tabParams = editor.value.getTabParamsFromUrl(window.location)

        tabParams.filter(e => availableEditors.includes(e.type)).forEach(async item => {
            let data = await axios.get(route('admin.pages.pages.fetch', {page: item.id})).then(res => res?.data)
            // console.log(item, data)
            editor.value.addTab(new PageTab().hydrate(data?.data), true)
        })
        
    })
    // END: Fetch Tabs


    
    // START: Keyboard Shortcuts
    hotkeys('ctrl+alt+n', (event, handler) => { event.preventDefault(); editor.value.openBlankTab() })
    hotkeys('ctrl+alt+w', (event, handler) => { event.preventDefault(); editor.value.closeTab(editor.value.tab.id) })
    hotkeys('ctrl+alt+right', (event, handler) => { event.preventDefault(); editor.value.selectNextTab() })
    hotkeys('ctrl+alt+left', (event, handler) => { event.preventDefault(); editor.value.selectPreviousTab() })
    // END: Keyboard Shortcuts
</script>

<style lang="sass">
    html
        background: var(--color-background-soft)
        overflow: hidden

    body
        font-family: var(--font-interface)
        background: #393F3F

        --color-primary: #3742fa !important
        --color-primary-soft: #4c5bfa !important

        --mui-primary: #3742fa !important
        --primary: #3742fa !important

        #app
            height: 100%
            width: 100%
</style>

<style lang="sass" scoped>
    .main-layout
        display: flex
        flex-direction: column
        height: 100%
        width: 100%
        
        --color-background-dark: #393F3F
        --color-background-dark-soft: #2A2F2F
        --color-text-soft-on-background-dark: rgb(255, 255, 255, .7)
        --color-text-on-background-dark: rgb(255, 255, 255, 1)
</style>