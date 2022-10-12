<template>
    <div class="pagination-wrapper">
        <span>
            <b v-if="total">{{from}}</b>
            <span v-if="total"> bis </span>
            <b>{{to}}</b>
            <span> von </span>
            <b>{{total}}</b>
        </span>
        <div class="spacer"></div>
        <button class="pagination-button" @click="$emit('prev')" aria-hidden="true" title="Vorige Seite">arrow_back</button>
        <button class="pagination-button" @click="$emit('next')" aria-hidden="true" title="Nächste Seite">arrow_forward</button>
    </div>
</template>

<script setup>
    import { defineEmits } from 'vue'

    defineEmits([
        'prev',
        'next',
    ])

    defineProps({
        from: {
            type: Number,
            default: 0,
        },
        to: {
            type: Number,
            default: 0,
        },
        total: {
            type: Number,
            default: 0,
        },
    })
</script>

<style lang="sass">
    .pagination-wrapper
        display: flex
        align-items: center
        padding: .5rem 1rem .5rem 1rem
        background: var(--color-background-soft)
        border-radius: var(--radius-m)
        white-space: nowrap
        gap: .5rem

        .spacer
            flex: 1
    
        .pagination-button
            flex: none
            height: 2.5rem
            width: 2.5rem
            border-radius: 50%
            border: none
            font-family: var(--font-icon)
            user-select: none
            cursor: pointer
            background: var(--color-background)
            box-shadow: var(--shadow-elevation-low)
            font-size: 1.5rem 
            color: var(--color-heading)

            &:hover,
            &:focus
                color: var(--color-primary)
</style>