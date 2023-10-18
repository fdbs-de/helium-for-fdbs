<template>
    <div class="table-pagination">
        <IodIconButton type="button" size="small" variant="text" icon="first_page" :disabled="page === 1" @click="$emit('update:modelValue', 1)" />
        <IodIconButton type="button" size="small" variant="text" icon="chevron_left" :disabled="page === 1" @click="$emit('update:modelValue', page - 1)" />
        
        <div class="range">
            <span><b>{{ startRange }} - {{ endRange }}</b> / {{ total }}</span>
        </div>
        
        <IodIconButton type="button" size="small" variant="text" icon="chevron_right" :disabled="page === pages" @click="$emit('update:modelValue', page + 1)" />
        <IodIconButton type="button" size="small" variant="text" icon="last_page" :disabled="page === pages" @click="$emit('update:modelValue', pages)" />
    </div>
</template>

<script setup>
    import { computed, defineEmits } from 'vue'

    const props = defineProps({
        modelValue: Number,
        size: Number,
        total: Number,
    })

    const emits = defineEmits([
        'update:modelValue'
    ])



    const page = computed(() => {
        let value = props.modelValue

        // Make sure the page is within the range
        if (props.modelValue < 1) value = 1
        
        // Make sure the page is within the range
        if (props.modelValue > pages.value) value = pages.value

        return value
    })

    const pages = computed(() => {
        return Math.ceil(props.total / props.size)
    })

    const startRange = computed(() => {
        return (page.value - 1) * props.size + 1
    })

    const endRange = computed(() => {
        return Math.min(((page.value - 1) * props.size + props.size), props.total)
    })
</script>

<style lang="sass" scoped>
    .table-pagination
        display: inline-flex
        align-items: center
        justify-content: center
        gap: .25rem
        padding: .25rem
        height: 2.5rem
        border-radius: var(--radius-m)
        background: var(--color-background-soft)
        overflow: hidden

        .iod-button
            --local-color-background: var(--color-text) !important

        .range
            display: flex
            align-items: center
            justify-content: center
            min-width: 10rem

            b
                font-weight: 500
                color: var(--color-text)
</style>