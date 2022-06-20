<template>
    <div class="wrapper" :class="'color-'+color">
        <div class="icon" v-if="icon">{{icon}}</div>
        <span>
            <slot/>
        </span>
    </div>
</template>

<script setup>
    defineProps({
        icon: String,
        color: {
            type: String,
            default: 'red',
        },
    })
</script>

<style lang="sass" scoped>
    .wrapper
        font-size: .8rem
        padding: .05rem .4rem
        display: flex
        align-items: center
        gap: .4rem
        border-radius: .2rem
        position: relative
        user-select: none

        &.color-red
            color: var(--color-red)

        &.color-green
            color: var(--color-green)

        &.color-yellow
            color: var(--color-yellow)

        &.color-blue
            color: var(--color-blue)

        &::after
            content: ''
            position: absolute
            top: 0
            left: 0
            width: 100%
            height: 100%
            border-radius: inherit
            background-color: currentColor
            opacity: .15

        .icon
            font-family: var(--font-icon)
            font-size: 1.2em
            line-height: 1
            user-select: none
            position: relative
            z-index: 1

        > span
            position: relative
            z-index: 1
</style>