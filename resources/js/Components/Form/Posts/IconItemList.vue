<template>
    <div class="wrapper item" :class="{'selected': isSelected}">
        <div class="preview-area" v-tooltip="item.visual.tooltip">
            <div class="image-preview" v-if="item.image" v-show="enablePreview">
                <img :src="item.image" />
            </div>
            <div class="icon" v-show="(!item.image || !enablePreview)" :style="`color: ${item.visual.color};`">{{ item.visual.icon }}</div>
        </div>

        <div class="title-area">
            <span v-tooltip="item.title">{{ item.title }}</span>
        </div>

        <div class="metadata-wrapper" v-tooltip="item.category.name">{{ item.category.name }}</div>
        <div class="metadata-wrapper icon" :style="`color: ${item.status.color};`" v-tooltip="item.status.tooltip">{{ item.status.icon }}</div>

        <VDropdown placement="bottom-end">
            <button @click.stop>more_vert</button>
            <template #popper>
                <div class="dropdown">
                    <mui-button class="dropdown-button" variant="text" label="Details" icon-left="visibility" @click="$emit('open', item)"/>
                        <mui-button class="dropdown-button" variant="text" label="Duplizieren" icon-left="content_copy" @click="$emit('duplicate', item)"/>
                        <div class="divider"></div>
                        <mui-button class="dropdown-button" variant="text" color="error" label="Löschen" icon-left="delete" @click="$emit('delete', item)"/>
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
            background: var(--color-info)
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
            color: var(--color-text)

        .metadata-wrapper
            flex: none
            font-size: .8rem
            width: 120px
            overflow: hidden
            text-overflow: ellipsis
            white-space: nowrap

            &.icon
                width: auto
                height: 100%
                aspect-ratio: 1
                display: flex
                align-items: center
                justify-content: center
                font-family: var(--font-icon)
                font-size: 1.25rem
                color: var(--color-text-soft)
                line-height: 1


        button
            font-family: var(--font-icon)
            background: none
            border: none
            color: var(--color-text-soft)
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
                color: var(--color-text)

    .dropdown
        display: flex
        flex-direction: column
        padding-block: .5rem

        .divider
            height: 0
            margin-block: .5rem
            border-top: 1px solid var(--color-border)

    .dropdown-button
        height: 3rem !important
        border-radius: 0 !important
        justify-content: flex-start !important
        --primary: var(--color-text-soft) !important
</style>