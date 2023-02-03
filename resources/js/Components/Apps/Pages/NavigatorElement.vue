<template>
    <div class="element-wrapper" :class="{'selected': selection.includes(element.elementId), 'expanded': element.editorMeta.expanded}">
        <div class="inner-info" @click="$emit('select', element)">
            <div class="icon">{{ element.editorMeta.displayIcon }}</div>
            <div class="name">{{ element.name }}</div>
            <IconButton icon="expand_more" v-if="element.inner.length > 0" @click="element.toggleExpanded()"/>
        </div>
        <div class="children" v-show="element.editorMeta.expanded">
            <NavigatorElement
                v-for="child in element.inner"
                :key="child.elementId"
                :element="child"
                :selection="selection"
                @select="$emit('select', $event)"
            />
        </div>
    </div>
</template>

<script setup>
    import Element from '@/Classes/Apps/Pages/Element.js'

    import IconButton from '@/Components/Apps/Pages/IconButton.vue'

    const props = defineProps({
        element: Element,
        selection: Array,
    })
</script>

<style lang="sass" scoped>
    .element-wrapper
        display: flex
        flex-direction: column
        cursor: pointer
        transition: background-color 100ms ease-in-out

        &.selected
            > .inner-info
                background-color: var(--color-background-soft)

        &.expanded
            > .inner-info
                > button
                    transform: rotate(180deg)

        .inner-info
            display: flex
            align-items: center
            border-radius: var(--radius-s)

            &:hover
                background-color: var(--color-background-soft)

            .icon
                display: flex
                align-items: center
                justify-content: center
                height: 2.5rem
                width: 2.5rem
                font-size: 1.25rem
                line-height: 1
                font-family: var(--font-icon)

            .name
                flex: 1
                overflow: hidden
                text-overflow: ellipsis
                white-space: nowrap
                font-size: 1rem
                font-weight: 500
                padding-inline: .25rem

        .children
            display: flex
            flex-direction: column
            padding-left: 1rem
</style>