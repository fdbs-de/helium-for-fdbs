<template>
    <div class="switcher">
        <button class="switcher-button" type="button" v-for="option in options" :key="option.value" @click="$emit('update:modelValue', option.value)" :class="{'active': modelValue === option.value}" v-tooltip="option.tooltip">{{option.icon}}</button>
    </div>
</template>

<script setup>
    import { computed } from 'vue'

    const props = defineProps({
        modelValue: {
            type: String,
        },
        options: {
            type: Array,
            required: true,
        },
    })
</script>

<style lang="sass" scoped>
    .switcher
        display: flex
        user-select: none
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-m)
        height: 2.5rem
        overflow: hidden
        
        .switcher-button
            display: flex
            align-items: center
            justify-content: center
            width: 3rem
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