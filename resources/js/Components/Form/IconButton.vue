<template>
    <component class="icon-button" aria-hidden="true" :is="is" :class="{'active': active}"><slot>{{ icon }}</slot></component>
</template>

<script setup>
    import { ref } from 'vue'

    defineProps({
        icon: String,
        is: {
            type: String,
            default: 'button',
        },
        active: {
            type: Boolean,
            default: false,
        }
    })
</script>

<style lang="sass" scoped>
    .icon-button
        display: flex
        align-items: center
        justify-content: center
        width: 2.5rem
        height: 2.5rem
        border: none
        outline: none
        padding: 0
        margin: 0
        background-color: transparent
        font-family: var(--font-icon)
        font-size: 1.25rem
        color: var(--color-text-soft)
        border-radius: var(--radius-m)
        text-decoration: none
        user-select: none
        cursor: pointer
        transition: all 100ms ease

        &:hover
            color: var(--color-text)

        &.active
            color: black
            background-color: #0000000f
</style>