<template>
    <a :href="link" target="_blank" class="card-wrapper">
        <div class="card-image-wrapper">
            <img loading="lazy" :src="image" :alt="alt" class="card-image" />

            <div class="tag-wrapper">
                <div class="tag primary">{{type}}</div>
                <div class="tag" v-for="(tag, i) in tags" :key="i">{{tag}}</div>
            </div>
        </div>
        <div class="text-wrapper">
            <h2>{{name}}</h2>
        </div>
    </a>
</template>

<script setup>
    defineProps({
        name: {
            type: String
        },
        type: {
            type: String,
            default: 'Job'
        },
        tags: {
            type: Array,
            default: () => ['m/w/d']
        },
        link: {
            type: String
        },
        image: {
            type: String
        },
        alt: {
            type: String
        },
    })
</script>

<style lang="sass" scoped>
    .card-wrapper
        background: var(--color-background)
        display: flex
        flex-direction: column
        box-shadow: var(--shadow-elevation-low)
        border-radius: 10px
        overflow: hidden
        transition: all 200ms ease-out
        position: relative
        cursor: pointer

        .card-image-wrapper
            width: 100%
            aspect-ratio: 16/9
            border-bottom: 3px solid var(--color-primary)
            background: var(--color-primary)
            position: relative
            overflow: hidden

            .card-image
                width: 100%
                height: 100%
                object-fit: cover
                position: absolute
                top: 0
                left: 0
                filter: saturate(0)
                transition: all 200ms ease-out

            .tag-wrapper
                position: absolute
                bottom: 0
                left: 0
                right: 0
                display: flex
                gap: .5rem
                padding: 1rem
                flex-wrap: wrap

                .tag
                    position: relative
                    display: flex
                    align-items: center
                    height: 1.75rem
                    padding: 0 1rem
                    font-size: .9rem
                    line-height: 1
                    border-radius: 2rem
                    color: var(--color-background)
                    backdrop-filter: blur(10px)

                    &.primary::after
                        background: var(--color-primary)
                        opacity: .9

                    &::after
                        content: ""
                        position: absolute
                        top: 0
                        bottom: 0
                        left: 0
                        right: 0
                        border-radius: inherit
                        background: var(--color-primary-soft)
                        opacity: .7
                        z-index: -1
                        pointer-events: none

        .text-wrapper
            padding: 2rem 1rem
            gap: 1rem
            display: flex
            flex-direction: column
            justify-content: center
            align-items: flex-start

            h2
                font-size: 1.35rem
                margin: 0

        &:hover
            box-shadow: var(--shadow-elevation-medium)

            .card-image-wrapper
                .card-image
                    filter: saturate(1)
                    transform: scale(1.1)
</style>