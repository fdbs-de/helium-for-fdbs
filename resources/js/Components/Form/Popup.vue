<template>
    <FocusTrap :active="isOpen" @deactivate="close(true)">
        <div class="popup-outer-wrapper" :class="[{'open': isOpen}, 'position-'+position]" :style="`--local-color-background: ${backgroundColor};`">
            <div class="popup-inner-wrapper">
                <div class="popup-content">
                    <slot></slot>
                </div>

                <div class="popup-header">
                    <h3>{{title}}</h3>
                    <button class="close" @click="close(true)">
                        <code>esc</code>
                        <div class="icon">close</div>
                    </button>
                </div>
            </div>
        </div>
    </FocusTrap>
</template>

<script>
    import { FocusTrap } from 'focus-trap-vue'

    export default {
        props: {
            title: String,
            backgroundColor: {
                type: String,
                default: 'var(--color-background)',
            },
            position: {
                type: String,
                default: 'center',
            },
        },

        data() {
            return {
                isOpen: false,
            }
        },
        
        methods: {
            open() {
                this.isOpen = true
            },
            
            close(shouldEmit = false) {
                this.isOpen = false

                if (shouldEmit) this.$emit('close')
            },
        },

        components: {
            FocusTrap,
        },
    }
</script>

<style lang="sass" scoped>
    .popup-outer-wrapper
        position: fixed
        z-index: 10000
        bottom: 0
        left: 0
        height: 100%
        width: 100%
        pointer-events: none
        overflow-y: none
        perspective: 1000px
        transition: background 300ms
        background: rgb(48 51 55 / 0%)
        // backdrop-filter: blur(0px)
        --max-width: 700px

        &.open
            overflow-y: auto
            pointer-events: all
            background: rgb(48 51 55 / 80%)
            // backdrop-filter: blur(12px)
                
            .popup-inner-wrapper
                transform: rotateX(0deg) translate(0, 0) !important
                opacity: 1 !important

        &.position-center
            .popup-inner-wrapper
                margin: 0 auto
                transform-origin: center center -200px
                transform: rotateX(-10deg)
                opacity: 0

                .popup-header
                    align-items: flex-end
                    margin-block: 6rem 1rem
                    --local-color-text: #ffffff
                    --local-color-transparent: #ffffff30

                .popup-content
                    background: var(--local-color-background)
                    border-radius: var(--radius-m)

        &.position-right
            overflow: hidden

            .popup-inner-wrapper
                height: 100%
                margin-left: auto
                overflow-y: auto
                display: flex
                flex-direction: column
                background: var(--local-color-background)
                transform: translateX(100%)

                .popup-header
                    margin: 0
                    padding: 1rem
                    --local-color-text: var(--color-heading)
                    --local-color-transparent: #00000010

                .popup-content
                    height: 100%
                    flex: 1
                    border-radius: 0
                    margin: 0

        .popup-inner-wrapper
            position: relative
            z-index: 1
            width: calc(100% - 2rem)
            max-width: var(--max-width)
            display: flex
            flex-direction: column
            transition: all 400ms cubic-bezier(0.4, 0, 0.2, 1)

            .popup-header
                display: flex
                color: var(--local-color-text)
                
                h3
                    flex: 1
                    margin: 0
                    padding-left: .2rem
                    font-size: 1.4rem
                    color: var(--local-color-text)
                    white-space: nowrap
                    text-overflow: ellipsis
                    overflow: hidden

                .close
                    flex: none
                    position: relative
                    display: flex
                    align-items: center
                    gap: 1rem
                    padding: 0
                    padding-left: 1rem
                    user-select: none
                    outline: none
                    border: none
                    background: none
                    font-size: inherit
                    text-align: inherit
                    border-radius: 2.5rem
                    cursor: pointer

                    &:focus > .icon,
                    &:hover > .icon
                        box-shadow: 0 0 0 4px var(--local-color-transparent)
                    
                    > .icon
                        display: grid
                        place-content: center
                        width: 2.5rem
                        height: 2.5rem
                        border-radius: 50%
                        background: var(--local-color-transparent)
                        color: var(--local-color-text)
                        border: 1px solid var(--local-color-transparent)
                        font-size: 1.35rem
                        line-height: 1
                        font-family: var(--font-icon)
                        transition: all 50ms
                    
                    > code
                        color: #ffffffdd
                        background: none
                        padding: 0
                        text-transform: uppercase
                        font-weight: 700
                        letter-spacing: .05rem

            .popup-content
                display: flex
                flex-direction: column
                order: 1
                margin-bottom: 6rem
</style>