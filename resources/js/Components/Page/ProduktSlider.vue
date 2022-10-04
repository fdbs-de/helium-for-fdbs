<template>
    <div class="outer-wrapper" :style="`--color-brand: ${selectedSlide.color};`">
        <transition-group name="big-slide">
            <img v-for="slide in slides" :key="slide.id" :src="slide.headlineImage.src" :alt="slide.headlineImage.alt" aria-hidden="true" v-show="slide.id === selectedSlide.id">
        </transition-group>
        
        <div class="inner-wrapper">
            <button class="prev" type="button" @click="prevSlide(true)" title="Vorige Marke">chevron_left</button>
            <transition-group name="small-slide">
                <div class="container" v-for="slide in slides" :key="'container-'+slide.id" v-show="slide.id === selectedSlide.id">
                    <img :src="slide.cover.src" :alt="slide.cover.alt">
                    <div class="text-wrapper">
                        <h2>{{slide.name}}</h2>
                        <p>{{slide.text}}</p>
                        <Link :href="slide.link">Mehr Erfahren</Link>
                    </div>
                </div>
            </transition-group>
            <button class="next" type="button" @click="nextSlide(true)" title="Nächste Marke">chevron_right</button>
        </div>
    </div>
</template>

<script setup>
    import { Link } from '@inertiajs/inertia-vue3'
    import { ref, computed } from 'vue'

    const props = defineProps({
        slides: {
            type: Array,
            required: true
        }
    })

    const slide = ref(0)

    const selectedSlide = computed(() => {
        return props.slides[slide.value] ?? null
    })

    const nextSlide = (manual = false) => {
        if (manual) clearInterval(interval)
        slide.value = (slide.value + 1) % props.slides.length
    }

    const prevSlide = (manual = false) => {
        if (manual) clearInterval(interval)
        slide.value = (slide.value - 1 + props.slides.length) % props.slides.length
    }

    const interval = setInterval(nextSlide, 5000)
</script>

<style lang="sass" scoped>
    .outer-wrapper
        position: relative
        padding-top: 10%

        .big-slide-move,
        .big-slide-enter-active,
        .big-slide-leave-active
            transition: all 0.5s ease

        .big-slide-enter-from
            opacity: 0
            transform: translate(0px, 0px) !important

        .big-slide-leave-to
            opacity: 0
            transform: translate(0px, 0px) !important

        .big-slide-leave-active
            position: absolute !important

        > img
            width: 100%
            object-fit: contain
            object-position: center
            opacity: 5%
            position: absolute
            top: 0
            left: 0

        .inner-wrapper
            position: relative

            > button
                position: absolute
                top: 50%
                transform: translateY(-50%)
                width: 4rem
                height: 4rem
                border-radius: 50%
                display: grid
                place-content: center
                line-height: 1
                font-size: 2rem
                padding: 0
                background: var(--color-background-soft)
                font-family: var(--font-icon)
                border: none
                text-align: inherit
                color: inherit
                cursor: pointer
                user-select: none
                transition: all 100ms

                &.prev
                    left: 1rem

                &.next
                    right: 1rem

                &:hover,
                &:focus
                    background: var(--color-primary)
                    color: var(--color-background)

        .small-slide-move,
        .small-slide-enter-active,
        .small-slide-leave-active
            transition: all 0.5s ease

        .small-slide-enter-from
            opacity: 0
            transform: translate(0px, 0px) !important
            
        .small-slide-leave-to
            opacity: 0
            transform: translate(0px, 0px) !important

        .small-slide-leave-active
            position: absolute !important
            top: 0 !important

        .container
            position: relative
            z-index: 1
            display: flex
            align-items: center
            overflow: hidden
            border-radius: 1rem
            background: var(--color-background)
            box-shadow: var(--shadow-elevation-high)
            margin-inline: 4rem

            img
                width: 250px
                align-self: stretch
                object-fit: cover

            .text-wrapper
                padding: 2rem
                display: flex
                flex-direction: column

                h2
                    font-size: 3rem
                    font-weight: 700
                    margin-block: 0rem 1rem

                p
                    margin: 0rem

                a
                    margin-top: 1.6rem
                    margin-right: auto
                    border-radius: .5rem
                    padding: 0 2rem
                    height: 2.5rem
                    display: flex
                    align-items: center
                    background: var(--color-brand)
                    color: var(--color-background)
                    text-decoration: none

    @media screen and (max-width: 900px)
        .outer-wrapper
            .container

                img
                    width: 210px

                .text-wrapper
                    h2
                        font-size: 2rem

    @media screen and (max-width: 700px)
        .outer-wrapper
            > img
                transform: translateY(0)

            .inner-wrapper
                > button
                    height: 3rem
                    width: 3rem
                    
                    &.prev
                        left: .5rem

                    &.next
                        right: .5rem

            .container
                flex-direction: column
                margin-inline: 3rem

                img
                    width: 100%
                    height: 300px
                    object-fit: contain
                    background: var(--color-background-soft)

                .text-wrapper
                    h2
                        font-size: 1.75rem

    @media screen and (max-width: 500px)
        .outer-wrapper
            > img
                display: none

            .inner-wrapper
                padding-top: 4.5rem

                > button
                    height: 3rem
                    width: 3rem
                    top: unset
                    top: 0
                    transform: translateY(0)
                    
                    &.prev
                        left: 0

                    &.next
                        right: 0
                        
            .container
                flex-direction: column
                margin-inline: 0rem
                border-radius: .75rem
                box-shadow: var(--shadow-elevation-medium)

                img
                    width: 100%
                    height: 300px
                    object-fit: contain
                    background: var(--color-background-soft)

                .text-wrapper
                    h2
                        font-size: 1.75rem
</style>