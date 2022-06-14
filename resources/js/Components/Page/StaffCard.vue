<template>
    <div class="card-wrapper" :class="{'has-overlay': overlay && image}" :style="'--card-color:' + color">
        <div class="image-wrapper" v-if="image">
            <img loading="lazy" :src="image" :alt="alt" class="card-image">
            <img loading="lazy" :src="overlay" :alt="alt" class="card-image overlay">
            <div class="job-banner" v-if="job">{{job}}</div>
        </div>
        <div class="text-wrapper" v-if="name || label || job">
            <b v-if="name">{{name}}</b>
            <a v-if="link && label" :href="link" target="_blank"><small>{{label}}</small></a>
            <small v-else-if="label">{{label}}</small>
        </div>
    </div>
</template>

<script setup>
    defineProps({
        color: {
            type: String,
            default: 'var(--color-primary)'
        },
        name: {
            type: String
        },
        job: {
            type: String
        },
        label: {
            type: String
        },
        link: {
            type: String
        },
        image: {
            type: String
        },
        overlay: {
            type: String
        },
        alt: {
            type: String
        },
    })
</script>

<style lang="sass" scoped>
    .card-wrapper
        background: white
        display: flex
        flex-direction: column
        box-shadow: var(--shadow-elevation-low)
        border-radius: 10px
        overflow: hidden
        transition: all 100ms ease-in-out

        .image-wrapper
            width: 100%
            aspect-ratio: 1
            background: var(--color-background-soft)
            position: relative

            .card-image
                width: 100%
                height: 100%
                object-fit: cover
                position: absolute
                top: 0
                left: 0

                &.overlay
                    opacity: 0
                    pointer-events: none

            .job-banner
                position: absolute
                bottom: 0
                left: 0
                right: 0
                color: var(--color-background)
                font-size: .9rem
                line-height: 1.3
                padding: .5rem 1rem
                text-align: center
                backdrop-filter: blur(10px)

                &::after
                    content: ""
                    position: absolute
                    top: 0
                    bottom: 0
                    left: 0
                    right: 0
                    z-index: -1
                    background: var(--card-color)
                    opacity: .8

        &:hover
            box-shadow: var(--shadow-elevation-medium)

        &.has-overlay:hover
            .card-image.overlay
                opacity: 1
                pointer-events: all

        .text-wrapper
            padding: 1rem
            display: flex
            flex-direction: column
            justify-content: center
            align-items: flex-start

            a
                color: var(--card-color)
</style>