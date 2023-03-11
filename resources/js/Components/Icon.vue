<template>
    <span class="icon">
        <slot>{{ icon }}</slot>
    </span>
</template>

<script setup>
    defineProps({
        icon: String,
    })
</script>

<style lang="sass" scoped>
    .icon
        display: inline-flex
        align-items: center
        justify-content: center
        color: inherit
        font-size: 1em
        font-weight: 400 !important
        font-family: var(--font-icon)
        line-height: 1
</style>