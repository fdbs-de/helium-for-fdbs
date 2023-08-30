<template>
    <button class="tab" :key="tab.localId" :class="{'active': tab.active}" @click="emits('select-tab', tab)">
        <div class="icon">{{ tab.icon }}</div>
        <div class="title">
            <span v-if="tab.title">{{ tab.title }}</span>
            <i v-else>Unbenannt</i>
        </div>
        <button class="indicator" @click.stop="emits('close-tab', tab)">
            <div class="icon">close</div>
        </button>
        <div class="corner start"></div>
        <div class="corner end"></div>
    </button>
</template>

<script setup>
    const emits = defineEmits([
        'close-tab',
        'select-tab',
    ])

    const props = defineProps({
        tab: {
            type: Object,
            required: true,
        },
    })
</script>

<style lang="sass" scoped>
    .tab
        flex: 1
        max-width: 20rem
        display: flex
        align-items: center
        height: 100%
        padding: 0
        margin: 0
        font-family: inherit
        font-size: inherit
        text-align: left
        position: relative
        color: var(--color-text-on-background-dark)
        background: transparent
        border: none
        border-radius: var(--radius-m)
        user-select: none

        &:hover
            background: #ffffff10
            .indicator
                .icon
                    transform: scale(1) !important
                    opacity: 1 !important

        &.active
            z-index: 1
            border-radius: var(--radius-m) var(--radius-m) 0 0
            color: var(--color-heading-on-background-dark)
            background: var(--color-background-dark)

            .corner
                display: block

        .corner
            display: none
            height: var(--radius-m)
            width: var(--radius-m)
            position: absolute
            bottom: 0
            overflow: hidden
            pointer-events: none

            &.start
                left: 0
                transform: translateX(-100%)
            &.end
                right: 0
                transform: translateX(100%)

            &.start::after
                border-bottom-right-radius: 100%

            &.end::after
                border-bottom-left-radius: 100%
            
            &::after
                content: ''
                height: 100%
                width: 100%
                position: absolute
                top: 0
                left: 0
                box-shadow: 0 0 0 500px var(--color-background-dark)

        > .icon
            font-family: var(--font-icon)
            font-size: 1.25rem
            width: 3.5rem
            display: flex
            align-items: center
            justify-content: center
            color: var(--color-text-on-background-dark)

        > .title
            flex: 1
            font-size: .9rem
            white-space: nowrap
            overflow: hidden
            text-overflow: ellipsis

        .indicator
            display: flex
            padding: 0
            margin: 0
            font-family: inherit
            font-size: inherit
            color: inherit
            background: transparent
            border: none

            .icon
                font-family: var(--font-icon)
                font-size: 1rem
                height: 2.25rem
                width: 2.25rem
                border-radius: 50%
                display: flex
                align-items: center
                justify-content: center
                transition: all 80ms ease-in-out
                transform: scale(0)
                opacity: 0
</style>