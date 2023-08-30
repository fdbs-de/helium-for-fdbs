<template>
    <div class="group" v-if="tab">
        <template v-for="prop in inspectedElement.props">
            <mui-input :label="prop.label" v-model="prop.value" />
        </template>
    </div>
</template>

<script setup>
    import { ref, computed, watch } from 'vue'
    import ElementTemplates from '@/Pages/Apps/Pages/ElementTemplates'



    const props = defineProps({
        tab: {
            type: Object,
            required: true,
        },
    })

    const inspectedElement = ref({})
    
    watch(() => props.tab, (tab) => {
        let element = props.tab.data.content.find(element => element.localId === props.tab.selected.elements[0])

        if (!element) return
        
        let elementTemplate = ElementTemplates[element.type]

        if (!elementTemplate) return

        elementTemplate.localId = element.localId

        for (let prop of elementTemplate.props)
        {
            prop.value = element.props[prop.key]
        }
        
        inspectedElement.value = elementTemplate
    }, {
        immediate: true,
        deep: true,
    })

    watch(() => inspectedElement.value.props, (element) => {
        if (!element) return
        
        console.log(element)
    }, {
        immediate: true,
        deep: true,
    })
</script>

<style lang="sass" scoped>
    .group
        padding: 1rem .5rem
        display: flex
        flex-direction: column
        gap: .5rem
        border-bottom: 1px solid var(--color-border)

        &.no-padding
            padding: 0

        &.horizontal
            flex-direction: row
            align-items: center
            gap: 0

        .title
            font-size: .8rem
            font-weight: 600
            letter-spacing: .05rem
            text-transform: uppercase
            color: var(--color-text)
            user-select: none

        .spacer
            flex: 1
</style>