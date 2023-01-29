<template>
    <button class="icon-button">
        <slot>{{ icon }}</slot>
    </button>
</template>

<script setup>
    const props = defineProps({
        icon: String,
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

        &:disabled
            opacity: 0.7
            cursor: unset
</style>