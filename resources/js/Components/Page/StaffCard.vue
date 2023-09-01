<template>
    <div class="card-wrapper" :class="{'has-overlay': overlay && image}" :style="'--card-color:' + color__">
        <div class="image-wrapper" v-if="image">
            <img loading="lazy" :src="image" :alt="alt__" class="card-image">
            <img loading="lazy" :src="overlay" :alt="alt__" class="card-image overlay">
            <div class="job-banner" v-if="job">{{job}}</div>
        </div>
        <div class="text-wrapper" v-if="name || label__ || job">
            <b v-if="name">{{name}}</b>
            <a v-if="link__ && label__" :href="link__" target="_blank"><small>{{label__}}</small></a>
            <small v-else-if="label__">{{label__}}</small>
        </div>
    </div>
</template>

<script setup>
    import { computed, ref } from 'vue'

    const props = defineProps({
        color: {
            type: String,
            default: 'var(--color-text)'
        },
        leader: {
            type: Boolean,
            default: false
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
        tel: {
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

    const basePhone = ref('0531 - 210 55-')

    const tel__ = computed(() => {

        // Wenn nur die Durchwahl gegenen ist
        if ([2,3].includes(props.tel?.length ?? 0))
        {
            // Dann ergänze die BaseNumber
            return basePhone.value + '' + props.tel
        }

        return props.tel || ''
    })

    const link__ = computed(() => (props.link || tel__?.value ? 'tel:'+tel__.value : null))
    const label__ = computed(() => (props.label || tel__?.value || null))

    const alt__ = computed(() => (props.alt || 'Portrait von '+props.name))

    const color__ = computed(() => (props.leader ? 'var(--color-primary)' : props.color))
</script>

<style lang="sass" scoped>
    .card-wrapper
        background: var(--color-background)
        border: 1px solid var(--color-background-soft)
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