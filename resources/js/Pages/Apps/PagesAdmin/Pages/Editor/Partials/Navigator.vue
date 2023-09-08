<template>
    <Container @drop="tab.dropElement($event)" behaviour="contain" lock-axis="y">            
        <Draggable v-for="element in tab.data.content" :key="element.localId">
            <div class="content-element flex v-center" :class="{ 'selected': tab.selected.elements.includes(element.localId) }" @click.exact="tab.selectElement(element)">
                <IodIcon class="handle" icon="drag_handle"/>
                <span class="text">
                    {{ element.name }}
                </span>
                <IodIconButton type="button" icon="delete" variant="text" color-preset="error" size="small" @click.stop="tab.removeElement(element)"/>
            </div>
        </Draggable>

        <div class="group flex v-center" v-if="!tab.data.content.length">
            <small class="padding-block-4 user-select-none color-text">
                Füge ein Element hinzu
            </small>
        </div>
    </Container>
</template>

<script setup>
    import { Container, Draggable } from 'vue3-smooth-dnd'



    const props = defineProps({
        tab: {
            type: Object,
            required: true,
        },
    })
</script>

<style lang="sass" scoped>
    .group
        padding: 1rem .5rem
        display: flex
        flex-direction: column
        gap: .5rem
        border-bottom: 1px solid var(--color-border)

        &.no-padding
            padding: 0

        &.horizontal
            flex-direction: row
            align-items: center
            gap: 0

        .title
            font-size: .8rem
            font-weight: 600
            letter-spacing: .05rem
            text-transform: uppercase
            color: var(--color-text-soft)
            user-select: none

        .spacer
            flex: 1

    .content-element
        user-select: none
        position: relative
        padding: .25rem .5rem
        min-height: 3rem
        color: var(--color-text-soft)
        background: var(--color-background)
        cursor: pointer
        display: flex
        align-items: center
        gap: .5rem

        *:not(::after)
            position: relative
            z-index: 1

        &::after
            content: ''
            position: absolute
            top: 0
            bottom: 0
            left: 0
            right: 0
            bottom: 0
            background: currentColor
            opacity: 0
            user-select: none
            pointer-events: none
            transition: opacity 50ms ease

        &:hover
            color: var(--color-text)

            &::after
                opacity: .05

        &.selected
            color: var(--color-primary)
            font-weight: 500

            &::after
                opacity: .1

        .handle
            width: 2rem
            font-size: 1.25rem
            color: currentColor
            pointer-events: none

        .text
            flex: 1
            overflow: hidden
            text-overflow: ellipsis
            white-space: nowrap
</style>