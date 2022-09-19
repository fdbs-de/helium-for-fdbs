<template>
    <div class="wrapper" :class="'color-'+color">
        <div class="icon" v-if="icon" aria-hidden="true">{{icon}}</div>
        <span>
            <slot>{{label}}</slot>
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
        label: String,
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
        user-select: none
        border: 1px solid currentColor

        &.color-red
            color: var(--color-red)

        &.color-green
            color: var(--color-green)

        &.color-yellow
            color: var(--color-yellow)

        &.color-blue
            color: var(--color-blue)

        &.color-gray
            color: var(--color-heading)

        .icon
            font-family: var(--font-icon)
            font-size: 1.2em
            line-height: 1
            user-select: none
</style>