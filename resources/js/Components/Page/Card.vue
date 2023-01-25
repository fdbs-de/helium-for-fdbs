<template>
    <!-- TODO: use Link for internal links -->
    <a :href="link" :target="newWindow ? '_blank' : '_self'" :style="`--color-card-accent: ${color}`" class="card-wrapper">
        <div class="card-image-wrapper" v-if="image" :class="{'cover': cover, 'effect': effect, 'no-border': tagPosition == 'beneath-image'}" :style="`aspect-ratio: ${aspectRatio};`">
            <img loading="lazy" :src="image" :alt="alt" class="card-image"/>

            <div class="warning-wrapper" v-if="warning" v-tooltip="warning">Wichtig</div>

            <div class="tag-wrapper" v-if="tagPosition === 'image' && (primaryTag || tags.length)">
                <div class="tag primary" v-if="primaryTag">{{primaryTag}}</div>
                <div class="tag" v-for="(tag, i) in tags" :key="i">{{tag}}</div>
            </div>
        </div>
        <div class="tag-wrapper" v-if="tagPosition === 'beneath-image' && (primaryTag || tags.length)">
            <div class="tag primary" v-if="primaryTag">{{primaryTag}}</div>
            <div class="tag" v-for="(tag, i) in tags" :key="i">{{tag}}</div>
        </div>
        <div class="text-wrapper" v-if="name || $slots.default">
            <h2 v-if="name">{{name}}</h2>
            <slot />
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
        effect: {
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
        tagPosition: {
            type: String,
            default: 'image'
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
        warning: {
            type: String,
            default: null
        },
        color: {
            type: String,
            default: 'var(--color-primary)'
        }
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
        color: var(--color-text)

        .card-image-wrapper
            width: 100%
            aspect-ratio: 16/9
            border-bottom: 3px solid var(--color-card-accent)
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
                transition: all 200ms ease-out

            &.no-border
                border: none

            &.effect
                .card-image
                    filter: saturate(0)

            &.cover
                background: var(--color-card-accent)
                .card-image
                    object-fit: cover

            .warning-wrapper
                position: absolute
                top: 1rem
                right: 1rem
                height: 1.5rem
                padding-inline: .75rem
                display: flex
                justify-content: center
                align-items: center
                background: var(--color-warning)
                color: var(--color-background)
                border-radius: 40px
                font-size: .7rem
                text-transform: uppercase
                font-weight: 600
                letter-spacing: .05rem
                z-index: 1
                user-select: none

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
                        background: var(--color-card-accent)
                        opacity: .9

                    &::after
                        content: ""
                        position: absolute
                        top: 0
                        bottom: 0
                        left: 0
                        right: 0
                        border-radius: inherit
                        background: var(--color-card-accent)
                        opacity: .7
                        z-index: -1
                        pointer-events: none

        > .tag-wrapper
            color: var(--color-card-accent)
            display: flex
            flex-wrap: wrap
            gap: .5rem
            padding: .5rem 1rem
            font-size: .8rem
            position: relative

            &::before
                content: ""
                position: absolute
                top: 0
                left: 0
                right: 0
                bottom: 0
                background: currentColor
                opacity: .2
                z-index: 0

            .tag
                position: relative
                z-index: 1

            .tag.primary
                font-weight: 600

        .text-wrapper
            flex: 1
            padding: 1rem
            gap: 1rem
            display: flex
            flex-direction: column
            justify-content: center
            align-items: flex-start

            h2
                font-size: 1.35rem
                margin: .5rem 0

        &:hover,
        &:focus
            box-shadow: var(--shadow-elevation-medium)

            .card-image-wrapper
                .card-image
                    filter: saturate(1)
                    transform: scale(1.07)
</style>