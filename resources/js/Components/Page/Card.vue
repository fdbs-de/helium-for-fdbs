<template>
    <!-- TODO:: use Link for internal links -->
    <a :href="link" :target="newWindow ? '_blank' : '_self'" class="card-wrapper">
        <div class="card-image-wrapper" v-if="image" :class="{'cover': cover}" :style="`aspect-ratio: ${aspectRatio};`">
            <img loading="lazy" :src="image" :alt="alt" class="card-image"/>

            <div class="tag-wrapper" v-if="primaryTag || tags.length">
                <div class="tag primary" v-if="primaryTag">{{primaryTag}}</div>
                <div class="tag" v-for="(tag, i) in tags" :key="i">{{tag}}</div>
            </div>
        </div>
        <div class="text-wrapper" v-if="name">
            <h2>{{name}}</h2>
        </div>
    </a>
</template>

<script setup>
    import {  Link } from '@inertiajs/inertia-vue3'
    
    defineProps({
        name: {
            type: String
        },
        cover: {
            type: Boolean,
            default: false
        },
        aspectRatio: {
            type: String,
            default: '3/2'
        },
        newWindow: {
            type: Boolean,
            default: false
        },
        primaryTag: {
            type: String,
            default: null
        },
        tags: {
            type: Array,
            default: () => []
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
        border: 1px solid var(--color-background-soft)
        border-radius: 10px
        overflow: hidden
        transition: all 200ms ease-out
        position: relative
        cursor: pointer

        .card-image-wrapper
            width: 100%
            aspect-ratio: 16/9
            border-bottom: 3px solid var(--color-primary)
            background: var(--color-background-soft)
            box-sizing: content-box
            position: relative
            overflow: hidden

            .card-image
                width: calc(100% + 4px)
                height: calc(100% + 4px)
                object-fit: contain
                position: absolute
                top: -2px
                left: -2px
                filter: saturate(0)
                transition: all 200ms ease-out

            &.cover
                background: var(--color-primary)
                .card-image
                    object-fit: cover

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

        &:hover,
        &:focus
            box-shadow: var(--shadow-elevation-medium)

            .card-image-wrapper
                .card-image
                    filter: saturate(1)
                    transform: scale(1.07)
</style>