<template>
    <button class="icon-button" aria-hidden="true" :class="{'active': active}"><slot>{{ icon }}</slot></button>
</template>

<script setup>
    import { ref } from 'vue'

    defineProps({
        icon: String,
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
        width: 3rem
        height: 2.5rem
        border-radius: 0
        cursor: pointer
        transition: all 100ms ease
        border: none
        outline: none
        background-color: transparent
        font-family: var(--font-icon)
        font-size: 1.3rem
        color: var(--color-text)
        padding: 0

        &:hover
            color: var(--color-heading)

        &.active
            color: black
            background-color: #0000000f
</style>