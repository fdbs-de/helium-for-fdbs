<template>
    <Container @drop="tab.dropElement($event)" behaviour="contain" lock-axis="y">            
        <Draggable v-for="element in tab.data.content" :key="element.localId">
            <div class="content-element flex v-center" :class="{ 'selected': tab.selected.elements.includes(element.localId) }">
                <IodIcon class="handle" icon="drag_indicator"/>
                <div class="flex-1 flex vertical" @click="tab.selectElement(element)">
                    {{ element.type }}
                </div>
                <IodIconButton type="button" icon="delete" variant="text" color-preset="error" @click="tab.removeElement(element)"/>
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
        color: var(--color-text)
        transition: background 100ms ease
        cursor: pointer

        &::after
            content: ''
            position: absolute
            top: .5rem
            left: 0
            bottom: .5rem
            width: .2rem
            border-radius: 0 3px 3px 0
            background: currentColor
            opacity: 0
            user-select: none
            pointer-events: none

        &:hover
            background: var(--color-background-soft)
            
            &::after
                opacity: .5

        &.selected
            background: var(--color-background-soft)

            &::after
                opacity: 1

        .handle
            width: 2rem
            font-size: 1.25rem
            color: var(--color-text-soft)
</style>