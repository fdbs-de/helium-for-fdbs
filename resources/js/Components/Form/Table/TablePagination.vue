<template>
    <div class="table-pagination">
        <template v-if="buttons.length">
            <button class="page-button square" :disabled="page === 1" @click="$emit('update:modelValue', 1)">1</button>
            
            <div class="vertical-divider"></div>
        </template>
        
        <button class="page-button square" v-for="button in buttons" :class="{'active': button === page}" @click="$emit('update:modelValue', button)">
            {{ button }}
        </button>
        <button class="page-button" disabled v-if="!buttons.length">
            Keine Seiten
        </button>
        
        <template v-if="buttons.length">
            <div class="vertical-divider"></div>
            
            <button class="page-button square" :disabled="page === pages" @click="$emit('update:modelValue', pages)">{{pages}}</button>
        </template>
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

    /**
     * Return an array of page numbers to display
     * amount = 5
     * try to always return {amount} buttons if possible
     * try to return the current page in the middle
     */
    const buttons = computed(() => {
        let amount = 5
        let buttons = []

        if (pages.value <= amount)
        {
            for (let i = 1; i <= pages.value; i++)
            {
                buttons.push(i)
            }
        }
        else
        {
            let start = page.value - Math.floor(amount / 2)
            let end = page.value + Math.floor(amount / 2)

            if (start < 1)
            {
                start = 1
                end = amount
            }
            else if (end > pages.value)
            {
                start = pages.value - amount + 1
                end = pages.value
            }

            for (let i = start; i <= end; i++)
            {
                buttons.push(i)
            }
        }

        return buttons
    })
</script>

<style lang="sass" scoped>
    .table-pagination
        display: inline-flex
        align-items: stretch
        justify-content: center
        border-radius: var(--radius-m)
        background: var(--color-background-soft)
        overflow: hidden

        .vertical-divider
            width: 0
            border-left: 1px solid var(--color-border)

        .page-button
            display: flex
            align-items: center
            justify-content: center
            width: auto
            height: 2.5rem
            border: none
            padding: 0 1rem
            background: transparent
            color: var(--color-text)
            font-family: inherit
            font-size: inherit
            cursor: pointer
            user-select: none

            &.square
                width: 2.5rem
                padding-inline: 0

            &:hover
                color: var(--color-heading)
                background: #0000000f

            &.active
                color: var(--color-heading)
                background: #0000000f
                font-weight: 600

            &:disabled
                background: transparent
                color: var(--color-text)
                opacity: .6
                cursor: default
</style>