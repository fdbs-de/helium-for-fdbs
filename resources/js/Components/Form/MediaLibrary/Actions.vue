<template>
    <div class="actions">
        <span>
            <b>{{ selection.length }} {{ selection.length === 1 ? 'Element' : 'Elemente' }}</b> ausgewählt
        </span>
        <div class="flex v-center border-left">
            <button class="icon-button" v-tooltip="'Alles abwählen'" @click="$emit('deselect')">deselect</button>
            <button class="icon-button error" v-tooltip="'Auswahl löschen'" @click="$emit('delete')">delete</button>
        </div>
    </div>
</template>

<script setup>
    import { computed } from 'vue'

    const props = defineProps({
        selection: {
            type: Array,
            default: () => [],
        },
    })
</script>

<style lang="sass" scoped>
    .actions
        display: flex
        align-items: center
        user-select: none
        border-radius: var(--radius-m)
        background: var(--color-background-soft)
        font-size: .9rem
        overflow: hidden

        > span
            padding-inline: 1rem

        .icon-button
            display: flex
            align-items: center
            justify-content: center
            width: 3rem
            height: 2.5rem
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
                background-color: #0000000f

            &.error
                color: var(--color-error)
</style>