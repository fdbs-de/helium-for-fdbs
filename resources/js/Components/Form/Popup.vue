<template>
    <FocusTrap :active="isOpen" @deactivate="close(true)">
        <div class="popup-outer-wrapper" :class="{'open': isOpen}">
            <div class="popup-inner-wrapper">
                <div class="popup-content" :style="'background-color: '+backgroundColor">
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
                default: '#fff',
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
        overflow-y: auto
        perspective: 1000px
        transition: background 300ms
        background: rgb(48 51 55 / 0%)

        &.open
            pointer-events: all
            background: rgb(48 51 55 / 80%)
                
            .popup-inner-wrapper
                transform: rotateX(0deg)
                opacity: 1

        .popup-inner-wrapper
            position: relative
            z-index: 1
            width: calc(100% - 2rem)
            max-width: 700px
            margin: 0 auto
            display: flex
            flex-direction: column
            transform-origin: center center -200px
            transform: rotateX(-10deg)
            opacity: 0
            transition: all 400ms cubic-bezier(0.4, 0, 0.2, 1)

            .popup-header
                display: flex
                align-items: flex-end
                margin-block: 6rem 1rem
                
                h3
                    flex: 1
                    margin: 0
                    padding-left: .2rem
                    font-size: 1.4rem
                    color: #ffffff
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

                    &:focus > .icon
                        background: #ffffff30
                        border-color: #ffffff
                        color: #ffffff
                        box-shadow: 0 0 0 4px #ffffff30

                    &:hover > .icon
                        background: #ffffff30
                        border-color: #ffffff40
                        color: #ffffff
                        box-shadow: 0 0 0 4px #ffffff30
                    
                    > .icon
                        display: grid
                        place-content: center
                        width: 2.5rem
                        height: 2.5rem
                        border-radius: 50%
                        background: #ffffff20
                        color: #ffffff
                        border: 1px solid #ffffff30
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
                background: var(--color-background)
                border-radius: .5rem
                display: flex
                flex-direction: column
                order: 1
                margin-bottom: 6rem
</style>