<template>
    <button type="button" class="add-element-button" v-tooltip.bottom="template.description">
        <img class="w-100" :src="template.previewImage">
        <b>{{ template.name }}</b>
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
        border-radius: var(--radius-m)
        border: 1px solid blue
        border-color: var(--color-border)
        background: var(--color-background)
        color: var(--color-text)
        padding: 0
        padding-bottom: .5rem
        display: flex
        flex-direction: column
        align-items: center
        justify-content: flex-start
        gap: .5rem
        cursor: pointer
        font-family: inherit
        font-size: .8rem
        overflow: hidden
        transition: all 100ms ease
        width: 10rem

        img
            border-bottom: 1px solid blue
            border-color: inherit

        &:hover
            box-shadow: var(--shadow-elevation-medium)
</style>