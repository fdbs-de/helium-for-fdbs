<template>
    <div class="wrapper" :class="{'selected': isSelected}">
        <div class="preview-area">
            <div class="image-preview" v-if="item.thumbnail" v-show="enablePreview">
                <img :src="item.thumbnail" />
            </div>
            <div class="icon" :class="{'is-folder': item.mime.type == 'folder' }" v-show="!item.thumbnail || !enablePreview" :style="`color: ${item.visual.color};`">{{ item.visual.icon }}</div>
        </div>

        <div class="title-area" :title="item.path.filename">{{ item.path.filename }}</div>

        <div class="extension-wrapper" v-if="item.mime.type !== 'folder'">
            <span class="extension">{{ item.path.extension }}</span>
        </div>

        <!-- <div class="filesize-wrapper" v-if="item.mime.type !== 'folder'">
            <span class="filesize">{{ fileSize(item.size) }}</span>
        </div> -->

        <VDropdown placement="bottom-end" v-if="showActions">
            <button @click.stop>more_vert</button>
            <template #popper>
                <div class="dropdown">
                    <template v-if="item.mime.type !== 'folder'">
                        <mui-button class="dropdown-button" variant="text" label="In neuem Tab öffnen" icon-left="open_in_new" as="a" target="_blank" :href="item.path.url"/>
                        <div class="divider"></div>
                    </template>
                    
                    <mui-button class="dropdown-button" variant="text" label="Pfad kopieren" icon-left="link" @click="copyToClipboard(item.path.url)"/>
                    <mui-button class="dropdown-button" variant="text" label="Media ID kopieren" icon-left="beenhere" @click="copyToClipboard(item.id)"/>
                    <template v-if="item.mime.type !== 'folder'">
                        <mui-button class="dropdown-button" variant="text" label="Herunterladen" icon-left="download" as="a" target="_blank" :href="item.path.url" download v-close-popper/>
                    </template>
                    
                    <div class="divider"></div>

                    <mui-button class="dropdown-button" variant="text" label="Thumbnail generieren" icon-left="image" @click="$emit('thumbnail', item)" v-close-popper/>
                    <mui-button class="dropdown-button" variant="text" label="Bearbeiten" icon-left="edit_note" @click="$emit('edit', item)" v-close-popper/>
                    <mui-button class="dropdown-button" variant="text" label="Umbenennen" icon-left="edit" @click="$emit('rename', item)" v-close-popper/>
                    <mui-button class="dropdown-button" variant="text" color="error" label="Löschen" icon-left="delete" @click="$emit('delete', item)" v-close-popper/>
                </div>
            </template>
        </VDropdown>
    </div>
</template>

<script setup>
    import { fileSize } from '@/Utils/String'
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
        showActions: {
            type: Boolean,
            default: true,
        },
        selection: {
            type: Array,
            default: () => [],
        },
    })

    const isSelected = computed(() => {
        return props.selection.includes(props.item.id)
    })



    // START: Copy to Clipboard
    const copyToClipboard = (text) => {
        navigator.clipboard.writeText(text)
    }
    // END: Copy to Clipboard
</script>

<style lang="sass" scoped>
    .wrapper
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

        &:hover
            background: var(--color-background-soft)

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
            transition: transform 100ms ease-in-out

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
                aspect-ratio: 11/14
                width: 30px
                display: flex
                align-items: center
                justify-content: center
                position: relative
                border-radius: var(--radius-s)
                clip-path: polygon(0 0, calc(100% - .5rem) 0, 100% .5rem, 100% 100%, 0 100%)
                overflow: hidden

                &.is-folder
                    aspect-ratio: 14/11
                    width: auto
                    height: 35px
                    clip-path: polygon(0 0, calc(50% - .25rem) 0, 50% .25rem, calc(100% - .25rem) .25rem, 100% .5rem, 100% 100%, 0 100%)
                    border-radius: .25rem
                    padding-top: .25rem

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

        .extension-wrapper
            width: 60px

        .filesize-wrapper
            width: 60px

        .extension
            text-transform: uppercase
            font-size: .8rem

        .filesize
            font-size: .8rem


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