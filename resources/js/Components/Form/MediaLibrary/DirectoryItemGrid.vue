<template>
    <div class="wrapper" :class="{'selected': isSelected}">
        <div class="preview-area">
            <div class="image-preview" v-if="mime.type === 'image'" v-show="enablePreview">
                <img :src="item.url" />
            </div>
            <div class="icon" v-show="(mime.type !== 'image' || !enablePreview)" :style="`color: ${visual.color};`">{{ visual.icon }}</div>
        </div>
        <div class="title-area" :title="path.filename">
            {{path.filename}}
        </div>
        <div class="info-area">
            <div class="file-info" v-if="mime.type !== 'folder'">
                <span class="extension" :style="`color: ${visual.color};`">{{path.extension}}</span>
                <span class="filesize">{{fileSize(item.size)}}</span>
            </div>
            <div class="spacer"></div>
            <VDropdown placement="bottom-end">
                <button @click.stop>more_vert</button>
                <template #popper>
                    <div class="dropdown">
                        <template v-if="mime.type !== 'folder'">
                            <mui-button class="dropdown-button" variant="text" label="Details" icon-left="visibility"/>
                            <mui-button class="dropdown-button" variant="text" label="In neuem Tab öffnen" icon-left="open_in_new" as="a" target="_blank" :href="path.url"/>
                        </template>
                        
                        <mui-button class="dropdown-button" variant="text" label="Pfad kopieren" icon-left="link" @click="copyToClipboard(item.url)"/>
                        
                        <template v-if="mime.type !== 'folder'">
                            <mui-button class="dropdown-button" variant="text" label="Herunterladen" icon-left="download" as="a" target="_blank" :href="path.url" download/>
                        </template>

                        <mui-button class="dropdown-button" variant="text" label="Umbenennen" icon-left="edit"/>
                        <div class="divider"></div>
                        <mui-button class="dropdown-button" variant="text" color="error" label="Löschen" icon-left="delete" @click="$emit('delete', item)"/>
                    </div>
                </template>
            </VDropdown>
        </div>
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
        selection: {
            type: Array,
            default: () => [],
        },
    })

    const mime = computed(() => {
        let mime = props.item.mime.split('/')
        return {
            type: mime[0] || null,
            subtype: mime[1] || null,
        }
    })

    const visual = computed(() => {
        if (mime.value.type === 'folder') return { icon: 'folder', color: '#2f3542'}
        if (mime.value.type === 'image') return { icon: 'landscape', color: '#3498db'}
        if (mime.value.type === 'video') return { icon: 'videocam', color: '#8e44ad'}
        if (mime.value.type === 'audio') return { icon: 'music_note', color: '#27ae60'}
        if (mime.value.subtype === 'pdf') return { icon: 'notes', color: '#eb4d4b'}
        return { icon: 'widgets', color: '#57606f'}
    })

    const path = computed(() => {
        let path = props.item.path.split('/')
        let filename = path[path.length - 1]
        let extension = filename.split('.').pop()
        let name = filename.replace('.' + extension, '')

        return {
            path: props.item.path,
            filename,
            extension,
            name,
            url: new URL(props.item.url, window.location.origin).href,
        }
    })

    const isSelected = computed(() => {
        return props.selection.includes(props.item.path)
    })



    // START: Copy to Clipboard
    const copyToClipboard = (text) => {
        navigator.clipboard.writeText(text)
    }
    // END: Copy to Clipboard
</script>

<style lang="sass" scoped>
    .wrapper
        display: flex
        flex-direction: column
        align-items: center
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-m)
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
            border: 1px solid transparent
            pointer-events: none
            transition: border-width 200ms ease-in-out

        &:hover::after
            border-color: var(--color-info)

        &.selected::after
            border-width: 3px
            border-color: var(--color-info)
            background: rgb(lightblue, .1)

        .preview-area
            aspect-ratio: 1
            width: 100%
            display: flex
            align-items: center
            justify-content: center
            border-radius: var(--radius-m) var(--radius-m) 0 0
            overflow: hidden

            .image-preview
                width: calc(100% - 1rem)
                height: calc(100% - 1rem)
                margin: .5rem
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
                font-size: 3rem
                color: var(--color-primary)
                aspect-ratio: 11/14
                width: 70px
                display: flex
                align-items: center
                justify-content: center
                position: relative
                border-radius: var(--radius-m)
                clip-path: polygon(0 0, calc(100% - 1rem) 0, 100% 1rem, 100% 100%, 0 100%)
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
            overflow: hidden
            text-overflow: ellipsis
            white-space: nowrap
            width: 100%
            padding: .5rem 1rem
            text-align: center
            font-size: .9rem
            font-family: var(--font-heading)
            color: var(--color-heading)
            border-bottom: 1px solid var(--color-border)

        .info-area
            display: flex
            align-items: center
            width: 100%
            padding: .5rem .5rem .5rem 1rem

            .file-info
                display: flex
                align-items: center
                gap: .5rem

                .extension
                    position: relative
                    max-width: 3rem
                    height: 1.2rem
                    line-height: 1.2rem
                    padding: 0 .3rem
                    font-size: .7rem
                    font-family: var(--font-heading)
                    font-weight: 600
                    text-transform: uppercase
                    color: var(--color-heading)
                    overflow: hidden
                    text-overflow: ellipsis
                    white-space: nowrap
                    border-radius: var(--radius-s)

                    &::after
                        content: ''
                        position: absolute
                        top: 0
                        left: 0
                        width: 100%
                        height: 100%
                        background: currentColor
                        opacity: .2
                        border-radius: inherit

                .filesize
                    font-size: .8rem

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
        padding-block: .5rem

        .divider
            height: 0
            margin-block: .5rem
            border-top: 1px solid var(--color-border)

    .dropdown-button
        height: 3rem !important
        border-radius: 0 !important
        justify-content: flex-start !important
        --primary: var(--color-text) !important
</style>