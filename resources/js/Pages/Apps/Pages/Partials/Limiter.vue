<template>
    <component :is="is" class="he-limiter" :class="'size-'+size">
        <slot />
    </component>
</template>

<script setup>
    defineProps({
        is: {
            type: String,
            default: 'div',
        },
        size: {
            type: String,
            default: 'limiter',
        },
    })
</script>

<style lang="sass" scoped>
    .he-limiter
        width: 100%
        max-width: 100%
        padding-inline: 1rem
        margin-inline: auto

        &.size-text-limiter
            max-width: 650px
        
        &.size-limiter
            max-width: 1200px

        &.size-page-width
            max-width: 100%
</style>