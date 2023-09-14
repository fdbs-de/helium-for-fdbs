<template>
    <button type="button" class="add-element-button" v-tooltip.bottom="template.description">
        <img class="w-100" :src="template.previewImage">
        <span>{{ template.name }}</span>
    </button>
</template>

<script setup>
    defineProps({
        template: {
            type: Object,
            required: true,
        },
    });
</script>

<style lang="sass" scoped>
    .add-element-button
        border: none
        border-radius: var(--radius-m)
        background: var(--color-background-soft)
        color: var(--color-text)
        display: flex
        flex-direction: column
        align-items: center
        justify-content: flex-start
        gap: .5rem
        padding: 0
        padding-bottom: .5rem
        cursor: pointer
        font-family: inherit
        font-size: .8rem
        overflow: hidden
        transition: all 100ms ease

        span
            padding-inline: .5rem
            font-weight: 500

        &:hover,
        &:focus
            outline: none
            box-shadow: 0 0 0 2px var(--color-info)
</style>