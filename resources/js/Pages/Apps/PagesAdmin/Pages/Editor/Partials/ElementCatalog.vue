<template>
    <FocusTrap :active="isOpen" @deactivate="close()">
        <div class="catalog-wrapper" :class="{'open': isOpen}">
            <div class="search-wrapper">
                <IodInput type="text" ref="searchbar" v-model="search" placeholder="Element Suchen" icon-left="search"/>
            </div>
            <div class="element-wrapper small-scrollbar">
                <div class="group" v-for="group in templates">
                    <span class="group-title">{{ group.name }}</span>
                    <AddElementButton v-for="template in group.items" :key="template.type" @click="tab.createElement(template, true); close()" :template="template"/>
                </div>
            </div>
        </div>
    </FocusTrap>
</template>

<script setup>
    import { ref, computed, nextTick } from 'vue'
    import { FocusTrap } from 'focus-trap-vue'
    import ElementTemplates from '@/Pages/Apps/Pages/ElementTemplates'
    import { capitalizeWords } from '@/Utils/String'

    import AddElementButton from '@/Pages/Apps/PagesAdmin/Pages/Editor/Partials/AddElementButton.vue'



    const props = defineProps({
        tab: {
            type: Object,
            required: true,
        },
    })

    const isOpen = ref(false)
    const searchbar = ref(null)
    const search = ref('')



    const templates = computed(() => {
        // Convert object to array
        let results = Object.values(ElementTemplates)

        // Return all if no search
        if (search.value)
        {
            // Filter by search
            results = results.filter(template => template.name.toLowerCase().includes(search.value.toLowerCase()))
        }
        
        // Group by property "group"
        let groups = new Map()

        groups.set('Basics', [])
        groups.set('Dynamic Content', [])
        groups.set('Advanced', [])
        groups.set('FDBS Specific', [])
        groups.set('Misc', [])

        for (let template of results)
        {
            let group = groups.has(template.group) ? template.group : 'Misc'

            groups.get(group).push(template)
        }

        return Array.from(groups).filter(group => group[1].length).map(([name, items]) => ({ name, items }))
    })



    function open() {
        isOpen.value = true
        search.value = ''

        nextTick(() => {
            searchbar.value.$refs.input.focus()
        })
    }

    function close() {
        isOpen.value = false

        nextTick(() => {
            searchbar.value.$refs.input.blur()
        })
    }

    defineExpose({
        open,
        close,
    })
</script>

<style lang="sass" scoped>
    .catalog-wrapper
        display: flex
        flex-direction: column
        position: absolute
        z-index: 1
        top: 0
        bottom: 0
        left: 0
        right: 0
        background: var(--color-background)
        pointer-events: none
        transform: translateX(-100%)
        transition: all 200ms cubic-bezier(0.65, 0.05, 0.36, 1)
        overflow: hidden

        &.open
            pointer-events: all
            transform: translateX(0)

        .search-wrapper
            padding: 1rem
            border-bottom: 1px solid var(--color-border)

            .iod-input
                height: 2.5rem

        .element-wrapper
            flex: 1
            display: flex
            flex-direction: column
            overflow: hidden
            overflow-y: auto
            scroll-behavior: smooth

        .group
            display: grid
            grid-template-columns: repeat(2, 1fr)
            gap: 1rem
            padding: 1.5rem 1rem

            .group-title
                grid-column: 1 / -1
                font-size: .8rem
                font-weight: 600
                text-transform: uppercase
                color: var(--color-text-soft)
                user-select: none
                padding-inline: .5rem
</style>