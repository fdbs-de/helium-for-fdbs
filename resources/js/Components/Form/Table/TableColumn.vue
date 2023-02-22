<template>
    <div class="column-tags" v-if="type === 'tags'">
        <Tag v-for="tag in value" :label="tag.text" :color="tag.color" :shape="tag.shape" :variant="tag.variant" :icon="tag.icon"/>
    </div>
    <div class="column-icons" v-else-if="type === 'icons'">
        <div class="icon" v-for="icon in value" :style="`color: ${icon.color};`">{{ icon.icon }}</div>
    </div>
    <div class="column-actions" v-else-if="type === 'actions'">
        <IconButton :icon="action.icon" :style="`color: ${action.color}`" v-for="action in value" @click.stop="action.run"/>
    </div>
    <div class="column-text" v-tooltip="value" v-else>
        {{value}}
    </div>
</template>

<script setup>
    import { computed } from 'vue'

    import Tag from '@/Components/Form/Tag.vue'
    import IconButton from '@/Components/Apps/Pages/IconButton.vue'

    const props = defineProps({
        type: String,
        value: [Array, Object, String, Number, Boolean],
    })
</script>

<style lang="sass" scoped>
    .column-tags
        display: flex
        flex-wrap: wrap
        gap: .5rem
        padding-block: .25rem
        padding-inline: .75rem
        user-select: none

    .column-icons
        display: flex
        flex-wrap: wrap
        gap: .5rem
        padding-block: .25rem
        padding-inline: .75rem
        user-select: none

        .icon
            display: flex
            align-items: center
            justify-content: center
            width: 1.5rem
            height: 1.5rem
            font-family: var(--font-icon)
            font-size: 1.25rem

    .column-actions
        align-self: stretch
        display: flex
        align-items: center
        margin: .25rem .75rem
        user-select: none
        border-radius: var(--radius-m)
        background: var(--color-background-soft)
        overflow: hidden

        > button
            height: 2rem
            width: 2.5rem

    .column-text
        white-space: nowrap
        overflow: hidden
        text-overflow: ellipsis
        padding-block: .25rem
        padding-inline: .75rem
</style>