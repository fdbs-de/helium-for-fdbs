<template>
    <div class="accordion" :class="{'open': isOpen}">
        <div class="head">
            <button type="button" class="toggle" @click="toggle()">
                <IodIcon icon="expand_more"/>
                <span>{{ title }}</span>
            </button>
            <div class="spacer"></div>
            <slot name="head-right" />
        </div>
        <Transition name="slide">
            <div class="body" v-show="isOpen">
                <slot />
            </div>
        </Transition>
    </div>
</template>

<script setup>
    import { ref } from 'vue'
    import LocalSetting from '@/Classes/Managers/LocalSetting'



    const props = defineProps({
        title: String,
        scope: String,
    })

    const isOpen = ref(LocalSetting.get(props.scope, 'isOpen', true))

    function toggle()
    {
        isOpen.value = !isOpen.value
        LocalSetting.set(props.scope, 'isOpen', isOpen.value)
    }
</script>

<style lang="sass" scoped>
    .accordion
        display: flex
        flex-direction: column
        gap: 1rem

        .head
            display: flex
            align-items: center
            position: relative
            z-index: 1
            gap: 1rem
            padding-inline: .5rem

            .toggle
                display: flex
                align-items: center
                gap: .75rem
                padding: .5rem 0
                min-height: 2.5rem
                border: none
                font-family: var(--font-heading)
                font-size: 1.2rem
                color: var(--color-text)
                background: transparent
                border-radius: var(--radius-m)
                cursor: pointer
                transition: all 100ms ease-in-out

                &:hover,
                &:focus
                    outline: none
                    color: var(--color-primary)

                .title
                    font-weight: 600

                .iod-icon
                    transition: transform 100ms ease-in-out

            .spacer
                flex: 1
                transform-origin: left
                transform: scaleX(0)
                transition: transform 300ms ease-in-out
                border-top: 1px solid var(--color-border)

        .slide-move,
        .slide-enter-active,
        .slide-leave-active
            transition: all 200ms ease-in-out
            transform-origin: top

        .slide-enter-from,
        .slide-leave-to
            transform: translateY(-20px)
            opacity: 0

        &.open
            .head
                .toggle
                    .iod-icon
                        transform: rotate(180deg)

        &:not(.open)
            .head
                .spacer
                    transform: scaleX(1)
</style>