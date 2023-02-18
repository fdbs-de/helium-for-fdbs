<template>
    <div class="tabs-wrapper">
        <button
            type="button"
            class="tab"
            :class="{ 'active': modelValue === tab.value }"
            v-for="tab in tabs"
            :key="tab.value"
            @click="$emit('update:modelValue', tab.value)"
        >
            {{ tab.label }}
        </button>
    </div>
</template>

<script setup>
    defineProps({
        modelValue: String,
        tabs: Array,
    })
</script>

<style lang="sass" scoped>
    .tabs-wrapper
        display: inline-flex
        align-items: center
        user-select: none
        position: relative
        user-select: none

        .tab
            display: flex
            align-items: center
            padding: 0 1rem
            height: 3rem
            position: relative
            border: none
            background: none
            border-radius: var(--radius-s)
            color: inherit
            font-size: 1rem
            font-family: inherit
            font-weight: 500
            cursor: pointer
            user-select: none
            overflow: hidden
            transition: border-bottom 100ms ease-in-out

            &:hover,
            &:focus
                color: var(--color-heading)

            &.active
                color: var(--color-primary)
                background: var(--color-background-soft)
</style>