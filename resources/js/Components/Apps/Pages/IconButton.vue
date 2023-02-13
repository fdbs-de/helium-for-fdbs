<template>
    <component :is="is" type="button" class="icon-button">
        <slot>{{ icon }}</slot>
    </component>
</template>

<script setup>
    const props = defineProps({
        icon: String,
        is: {
            type: [String, Object],
            default: 'button'
        }
    })
</script>

<style lang="sass" scoped>
    .icon-button
        display: flex
        align-items: center
        justify-content: center
        font-family: var(--font-icon)
        font-size: 1.25rem
        width: 2.5rem
        height: 2.5rem
        padding: 0
        margin: 0
        color: inherit
        border: none
        border-radius: var(--radius-m)
        background: transparent
        cursor: pointer
        user-select: none
        position: relative

        &:disabled
            opacity: 0.7
            cursor: unset

        &::after
            content: ''
            display: block
            position: absolute
            top: 0
            left: 0
            width: 100%
            height: 100%
            border-radius: inherit
            background: currentColor
            opacity: 0
            transition: opacity 100ms ease

        &:focus
            outline: none

        &:focus:not(:disabled)::after
            opacity: 0.05

        &:hover:not(:disabled)::after
            opacity: 0.1

        &.active
            background: var(--color-background-soft)
</style>