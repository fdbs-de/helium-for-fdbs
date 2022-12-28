<template>
    <div class="wrapper item" :class="{'selected': isSelected}">
        <div class="preview-area" v-tooltip="item.displayVisual.tooltip">
            <div class="image-preview" v-if="item.image" v-show="enablePreview">
                <img :src="item.image" />
            </div>
            <div class="icon" v-show="(!item.image || !enablePreview)" :style="`color: ${item.displayVisual.color};`">{{ item.displayVisual.icon }}</div>
        </div>

        <div class="title-area">
            <span v-tooltip="item.name">{{ item.name }}</span>
        </div>

        <div class="metadata-wrapper" v-for="text in item.displayMetadata.texts" :key="text" v-tooltip="text">{{ text }}</div>

        <div class="flex v-center background-soft" style="border-radius: 1rem; padding-inline: .25rem;" v-if="item.displayMetadata.icons.length > 0">
            <div class="metadata-wrapper icon" v-for="icon in item.displayMetadata.icons" :key="icon.id" :style="`color: ${icon.color};`" v-tooltip="icon.tooltip">{{ icon.icon }}</div>
        </div>

        <VDropdown placement="bottom-end">
            <button @click.stop>more_vert</button>
            <template #popper>
                <div class="dropdown">
                    <div class="group" v-for="(group, i) in item.displayActions" :key="i">
                        <mui-button
                            v-close-popper
                            class="dropdown-button"
                            variant="text"
                            v-for="action in group"
                            :key="action.id"
                            :label="action.tooltip"
                            :icon-left="action.icon"
                            :style="`--color: ${action.color};`"
                            @click="$emit(action.action, item)"
                        />
                    </div>
                </div>
            </template>
        </VDropdown>
    </div>
</template>

<script setup>
    import { computed } from 'vue'
    
    const props = defineProps({
        item: {
            type: Object,
            required: true,
        },
        enablePreview: {
            type: Boolean,
            default: false,
        },
        selection: {
            type: Array,
            default: () => [],
        },
    })

    const isSelected = computed(() => {
        return props.selection.includes(props.item.id)
    })
</script>

<style lang="sass" scoped>
    .wrapper.item
        height: 3.5rem
        width: 100%
        display: flex
        align-items: center
        gap: 1rem
        padding-right: 1rem
        background: var(--color-background)
        user-select: none
        cursor: pointer
        position: relative

        &::after
            content: ''
            box-sizing: border-box
            position: absolute
            top: 0
            left: 0
            width: 100%
            height: 100%
            border-radius: inherit
            pointer-events: none
            z-index: 1
            background: var(--color-text)
            opacity: 0

        &:hover::after
            opacity: .1

        &::before
            content: ''
            position: absolute
            top: .25rem
            left: 0
            width: 5px
            height: calc(100% - .5rem)
            background: var(--color-info)
            border-radius: 0 5px 5px 0
            pointer-events: none
            z-index: 1
            transform-origin: left
            transform: scaleX(0)
            transition: transform 200ms ease-in-out

        &.selected::before
            transform: scaleX(1)

        .preview-area
            height: 100%
            flex: none
            aspect-ratio: 1.3
            display: flex
            align-items: center
            justify-content: center
            border-radius: var(--radius-m)
            overflow: hidden

            .image-preview
                width: calc(100% - .5rem)
                height: calc(100% - .5rem)
                margin: .25rem
                border-radius: var(--radius-s)
                overflow: hidden
                display: flex
                align-items: center
                justify-content: center
                position: relative
                --height: 10%
                background-image: linear-gradient(45deg, #b4b4b4 25%, transparent 25%), linear-gradient(-45deg, #b4b4b4 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #b4b4b4 75%), linear-gradient(-45deg, transparent 75%, #b4b4b4 75%)
                background-size: calc(var(--height) / 2) calc(var(--height) / 2)
                background-position: 0 0, 0 calc(var(--height) / 4), calc(var(--height) / 4) calc(var(--height) / 4 * -1), calc(var(--height) / 4 * -1) 0px

                img
                    width: 100%
                    height: 100%
                    object-fit: cover
                    position: absolute
                    top: 0
                    left: 0
            .icon
                font-family: var(--font-icon)
                font-size: 1.25rem
                color: var(--color-primary)
                aspect-ratio: 1
                width: 30px
                display: flex
                align-items: center
                justify-content: center
                position: relative
                border-radius: var(--radius-s)
                overflow: hidden

                &::after
                    content: ''
                    position: absolute
                    top: 0
                    left: 0
                    width: 100%
                    height: 100%
                    background: currentColor
                    opacity: .2
                    pointer-events: none
        
        .title-area
            flex: 1
            overflow: hidden
            text-overflow: ellipsis
            white-space: nowrap
            padding: 0
            font-size: .9rem
            font-family: var(--font-heading)
            color: var(--color-heading)

        .metadata-wrapper
            flex: none
            font-size: .8rem
            overflow: hidden
            text-overflow: ellipsis
            white-space: nowrap

            &.icon
                width: 2rem
                aspect-ratio: 1
                display: flex
                align-items: center
                justify-content: center
                font-family: var(--font-icon)
                font-size: 1.25rem
                color: var(--color-text)
                line-height: 1


        button
            font-family: var(--font-icon)
            background: none
            border: none
            color: var(--color-text)
            font-size: 1.3rem
            height: 2.2rem
            width: 2.2rem
            display: flex
            align-items: center
            justify-content: center
            cursor: pointer
            border-radius: 50%

            &:hover
                background: #00000010
                color: var(--color-heading)

    .dropdown
        display: flex
        flex-direction: column
        gap: 0

        .group
            display: flex
            flex-direction: column
            padding-block: .5rem
            border-bottom: 1px solid var(--color-border)

            &::last-child
                border-bottom: none

            .dropdown-button
                height: 3rem !important
                border-radius: 0 !important
                justify-content: flex-start !important
                --primary: var(--color) !important
</style>