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

        <div class="indicator" ref="indicator"></div>
    </div>
</template>

<script setup>
    import { ref, watch, nextTick, onMounted } from 'vue'

    const props = defineProps({
        modelValue: [String, Number],
        tabs: Array,
    })

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
        const activeTab = document.querySelector('.tab.active')

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

        indicator.value.style.transform = `translateX(${left}px)`
        indicator.value.style.width = `${width}px`
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
        --tab-height: 2.5rem

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
                background: var(--color-text)
                border: 0
                border-radius: 0

        .tab
            flex: none
            display: flex
            align-items: center
            padding: 0 1rem
            height: var(--tab-height)
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
            text-overflow: ellipsis
            white-space: nowrap
            transition: border-bottom 100ms ease-in-out

            &:hover,
            &:focus
                color: var(--color-heading)

            &.active
                color: var(--color-heading)

        .indicator
            height: 2px
            width: 1px
            background: var(--color-heading)
            position: absolute
            bottom: 0
            left: 0
            transition: all 100ms ease-in-out
</style>