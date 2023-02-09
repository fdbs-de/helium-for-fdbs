<template>
    <div
        :class="[
            `wrapper`,
            `shape-${shape}`,
            `variant-${variant}`,
            {
                'has-border': border,
                'uppercase': uppercase,
            },
        ]"
        :style="`color: ${color};`"
        v-tooltip="label"
    >
        <div class="icon" v-if="icon" aria-hidden="true">{{icon}}</div>
        <span class="text"><slot>{{label}}</slot></span>
    </div>
</template>

<script setup>
    defineProps({
        border: {
            type: Boolean,
            default: false,
        },
        uppercase: {
            type: Boolean,
            default: false,
        },
        color: {
            type: String,
            default: 'var(--color-heading)',
        },
        shape: {
            type: String,
            default: 'square',
        },
        variant: {
            type: String,
            default: 'filled',
        },
        icon: String,
        label: String,
    })
</script>

<style lang="sass" scoped>
    .wrapper
        font-size: .8rem
        padding: .05rem .5rem
        display: inline-flex
        align-items: center
        gap: .4rem
        user-select: none
        position: relative
        user-select: none

        &::after
            content: ''
            position: absolute
            top: 0
            left: 0
            width: 100%
            height: 100%
            border-radius: inherit
            background-color: currentColor
            opacity: 0

        &.has-border
            border: 1px solid currentColor

        &.uppercase
            .text
                text-transform: uppercase
                font-size: .9em
                font-weight: 600



        &.variant-filled
            background-color: currentColor

            .text
                color: var(--color-background)

        &.variant-contained
            &::after
                opacity: .1

            .text
                color: currentColor
                
        &.variant-text
            .text
                color: currentColor



        &.shape-square
            border-radius: .2rem

        &.shape-pill
            border-radius: 1rem
            padding-inline: .75rem



        .icon
            font-family: var(--font-icon)
            font-size: 1.25em
            line-height: 1
            position: relative
            z-index: 1

        .text
            position: relative
            z-index: 1
</style>