<template>
    <div class="card-wrapper">
        <div v-if="icon" class="icon" aria-hidden="true">{{icon}}</div>
        <h3 v-if="title">{{title}}</h3>
        <p v-if="$slots.default || text"><slot>{{text}}</slot></p>
    </div>
    
</template>

<script setup>
    defineProps({
        icon: String,
        title: String,
        text: String,
    })
</script>

<style lang="sass" scoped>
    .card-wrapper
        display: flex
        flex-direction: column
        align-items: center
        text-align: center
        gap: 2rem
        padding: 2rem
        border-radius: .5rem
        border: 1px solid #e6e6e6

        h3
            font-size: 1.25rem
            font-weight: 500
            margin: 0

        p
            margin: 0

        .icon
            font-family: var(--font-icon)
            font-size: 3rem
            line-height: 1
            display: flex
            justify-content: center
            align-items: center
            text-align: center
            color: var(--color-primary)
            position: relative
            height: 5rem
            width: 5rem
            border-radius: .5rem
            user-select: none

            &::before
                content: ''
                position: absolute
                top: 0
                left: 0
                width: 100%
                height: 100%
                border-radius: inherit
                background-color: currentColor
                opacity: 0.1
                z-index: -1
</style>