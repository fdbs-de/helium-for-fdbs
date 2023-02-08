<template>
    <div
        class="element-wrapper"
        :class="{
            'selected': selection.includes(element.elementId),
            'expanded': element.editorMeta.expanded
        }"
    >
        <div
            class="inner-info"
            @click.exact="$emit('select:set', element)"
            @click.ctrl="$emit('select:toggle', element)"
        >
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
                @select:set="$emit('select:set', $event)"
                @select:toggle="$emit('select:toggle', $event)"
            />
        </div>
    </div>
</template>

<script setup>
    import Element from '@/Classes/Apps/Pages/Elements/Element.js'

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
        user-select: none

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

            &:hover
                background-color: var(--color-background-soft)

            .icon
                display: flex
                align-items: center
                justify-content: center
                height: 2.5rem
                width: 3rem
                font-size: 1.25rem
                line-height: 1
                color: var(--color-text)
                font-family: var(--font-icon)

            .name
                flex: 1
                overflow: hidden
                text-overflow: ellipsis
                white-space: nowrap
                font-size: .9rem
                font-weight: 500

            > button
                height: 1.5rem
                width: 1.5rem
                margin: .5rem
                border-radius: var(--radius-s)

        .children
            display: flex
            flex-direction: column
            padding-left: 1rem
</style>