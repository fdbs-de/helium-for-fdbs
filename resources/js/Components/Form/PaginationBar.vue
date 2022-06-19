<template>
    <div class="pagination-wrapper">
        <span>
            <b v-if="total">{{(page - 1) * 50 + 1}}</b>
            <span v-if="total"> bis </span>
            <b>{{(page - 1) * 50 + length}}</b>
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
        length: Number,
        total: Number,
        page: Number,
    })
</script>

<style lang="sass">
    .pagination-wrapper
        display: flex
        align-items: center
        padding: .5rem .5rem .5rem 1rem
        background: var(--color-background-soft)
        border-radius: .325rem
        white-space: nowrap
        gap: .5rem
        margin: 1rem

        .spacer
            flex: 1
    
        .pagination-button
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