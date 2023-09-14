<template>
    <div class="tabs-wrapper tab-component" ref="container">
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

        <div class="indicator" :class="['indicator-style-'+indicatorStyle]" ref="indicator"></div>
    </div>
</template>

<script setup>
    import { ref, watch, nextTick, onMounted } from 'vue'

    const props = defineProps({
        modelValue: [String, Number],
        tabs: Array,
        indicatorStyle: {
            type: String,
            default: 'line',
        }
    })

    const container = ref(null)
    const indicator = ref(null)

    watch(() => props.modelValue, () => {
        nextTick(() => {
            updateIndicator()
        })
    }, { immediate: true })

    onMounted(() => {
        updateIndicator()
    })

    const updateIndicator = () => {
        const activeTab = container.value.querySelector('.tabs-wrapper.tab-component .tab.active')

        if (!activeTab) return

        const { width } = activeTab.getBoundingClientRect()

        // get left offset relative to parent
        let left = 0
        let current = activeTab
        
        while (current && current !== indicator.value.parentElement)
        {
            left += current.offsetLeft
            current = current.offsetParent
        }

        indicator.value.style.transform = `translateX(${left+1}px)`
        indicator.value.style.width = `${width-2}px`
    }
</script>

<style lang="sass" scoped>
    .tabs-wrapper
        display: inline-flex
        align-items: stretch
        user-select: none
        position: relative
        user-select: none
        overflow: auto
        --tab-height: 2.25rem

        &::-webkit-scrollbar
                width: 3px
                height: 3px

        &::-webkit-scrollbar-track
            background: var(--color-background)

        &::-webkit-scrollbar-thumb
            background: #00000050
            border-radius: 0
            background-clip: content-box
            border: 0

            &:hover
                background: var(--color-text-soft)
                border: 0
                border-radius: 0

        .tab
            flex: none
            display: flex
            align-items: center
            padding: 0 1rem
            height: var(--tab-height)
            position: relative
            z-index: 2
            border: none
            background: none
            border-radius: var(--radius-s)
            color: inherit
            font-size: inherit
            font-family: inherit
            font-weight: 500
            cursor: pointer
            user-select: none
            overflow: hidden
            text-overflow: ellipsis
            white-space: nowrap
            transition: border-bottom 100ms ease-in-out

            &:hover,
            &:focus
                color: var(--color-text)

            &.active
                color: var(--color-primary)

        .indicator
            position: absolute
            z-index: 1
            left: 0
            width: 1px
            transition: transform 100ms ease-in-out, width 100ms ease, background 100ms ease
            pointer-events: none

            &.indicator-style-line
                bottom: 0
                height: 2px
                border-radius: 2px 2px 0 0
                background: var(--color-primary)

            &.indicator-style-box
                bottom: 0
                top: 0
                border-radius: var(--radius-m)
                background: currentColor
                opacity: .1
</style>