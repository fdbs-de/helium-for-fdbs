<template>
    <div class="group" v-if="tab && elementProps && elementProps.length > 0">
        <template v-for="prop in elementProps">
            <select v-if="prop.fixtureType === 'select'" v-model="prop.value" @change="emitUpdate()">
                <option :value="null" disabled>{{prop.label}}</option>
                <option v-for="option in prop.options" :value="option.value">{{ option.label }}</option>
            </select>

            <TextEditor v-else-if="prop.fixtureType === 'richtext'" :label="prop.label" v-model="prop.value" @update:modelValue="emitUpdate()"/>
            
            <mui-input v-else :label="prop.label" v-model="prop.value" @update:modelValue="emitUpdate()"/>
        </template>
    </div>
</template>

<script setup>
    import { ref, watch } from 'vue'
    import ElementTemplates from '@/Pages/Apps/Pages/ElementTemplates'

    import TextEditor from '@/Components/Form/TextEditor.vue'



    const emits = defineEmits([
        'update:element',
    ])

    const props = defineProps({
        tab: {
            type: Object,
            required: true,
        },
    })



    const elementProps = ref([])



    const getElementfromSelection = () => {
        return props.tab.data.content.find(element => element.localId === props.tab.selected.elements[0]) || null
    }

    const getPropsFromElement = () => {
        if (!props.tab.selected.elements.length) return []

        const element = getElementfromSelection()
        if (!element) return []

        const template = ElementTemplates[element.type]
        if (!template) return []

        return template.props.map(prop => {
            return { ...prop, value: element.props[prop.key] }
        })
    }

    const getElementFromProps = () => {
        if (!props.tab.selected.elements.length) return

        const element = getElementfromSelection()
        if (!element) return

        element.props = elementProps.value.reduce((props, prop) => {
            props[prop.key] = prop.value
            return props
        }, {})

        return element
    }



    watch(() => props.tab, () => {
        elementProps.value = getPropsFromElement()
    }, {
        immediate: true,
        deep: true,
    })

    const emitUpdate = () => {
        emits('update:element', getElementFromProps())
    }
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