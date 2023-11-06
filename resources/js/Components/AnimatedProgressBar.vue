<template>
    <div class="progress-wrapper" :style="{ color: color }">
        <div class="progress-bar" :style="{ width: percent + '%' }"></div>
    </div>
</template>

<script setup>
    import { ref, watch, onMounted, nextTick } from 'vue'



    const props = defineProps({
        number: Number,
        max: Number,
        percent: Number,
        color: String,
    })

    const percent = ref(0)

    function calculatePercent()
    {
        // NextTick is used to create a "startup" animation
        nextTick(() => {
            if (props.percent) return percent.value = props.percent
            if (props.number && props.max) return percent.value = props.number / props.max * 100
            return percent.value = 0
        })
    }

    watch(() => props.number, calculatePercent)
    watch(() => props.max, calculatePercent)
    watch(() => props.percent, calculatePercent)

    onMounted(calculatePercent)
</script>

<style lang="sass" scoped>
    .progress-wrapper
        position: relative
        height: .25rem
        width: 100%
        border-radius: 1rem
        overflow: hidden
        background-color: var(--color-background-soft)
        color: var(--color-text)
        transition: all 100ms ease-in-out

        .progress-bar
            position: absolute
            top: 0
            bottom: 0
            left: 0
            border-radius: inherit
            background-color: currentColor
            transition: width 1s cubic-bezier(0.22, 0.61, 0.36, 1)
</style>