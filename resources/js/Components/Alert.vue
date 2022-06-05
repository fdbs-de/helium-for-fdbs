<template>
    <div class="alert-wrapper" :class="[type__, {'has-icon': icon}]">
        <div class="content">
            <div class="icon" v-if="icon" aria-hidden="true">{{icon}}</div>
            <h3 class="title" v-if="title">{{title}}</h3>
            <div class="slot">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            title: {
                type: String,
                default: '',
            },

            icon: {
                type: String,
                default: '',
            },

            type: {
                type: String,
                default: 'default',
            },
        },

        computed: {
            type__() {
                return ['default', 'info', 'error', 'warning', 'success', 'primary'].includes(this.type) ? this.type : 'default'
            },
        },
    }
</script>

<style lang="sass" scoped>
    .alert-wrapper
        padding: 5px 20px
        border-radius: 10px
        position: relative
        color: var(--color-text)

        &.info
            color: var(--color-info)

        &.error
            color: var(--color-error)

        &.warning
            color: var(--color-warning)

        &.success
            color: var(--color-success)

        &.primary
            color: var(--color-primary)

        &.has-icon
            padding-top: 1.75rem
            margin-top: 1.75rem

        &::before
            content: ''
            position: absolute
            top: 0
            left: 0
            width: 100%
            height: 100%
            background: currentColor
            opacity: .1
            z-index: -1
            border-radius: inherit

        .content
            display: contents

            .icon
                display: grid
                width: 3.5rem
                height: 3.5rem
                background: white
                color: inherit
                border-radius: .5rem
                place-content: center
                font-size: 1.9rem
                font-family: var(--font-icon)
                position: absolute
                left: 20px
                top: 0
                transform: translateY(-50%)
                box-shadow: var(--shadow-elevation-medium)
                user-select: none
                pointer-events: none

            h1, h2, h3, h4, h5, h6
                color: inherit

            .slot
                display: contents
                color: var(--color-text)
</style>