<template>
    <div class="list-item-layout" :class="layout">
        <slot />
    </div>
</template>

<script setup>
    import { ref } from 'vue'

    defineProps({
        layout: String,
    })
</script>

<style lang="sass" scoped>
    .list-item-layout
        &.grid
            gap: 1rem
            display: grid
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr))

        &.list
            padding: 1rem 0
            border-radius: var(--radius-m)
            background: var(--color-background)
            box-shadow: var(--shadow-elevation-low)
            display: flex
            flex-direction: column
</style>