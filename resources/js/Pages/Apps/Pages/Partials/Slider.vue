<template>
    <div class="slider-container">
        <div class="controls">
            <IodIconButton type="button" icon="arrow_back" variant="text" shape="radius-l" @click="previous(); stopAutoplay()"/>
            <IodIconButton type="button" icon="arrow_forward" variant="text" shape="radius-l" @click="next(); stopAutoplay()"/>
        </div>

        <TransitionGroup tag="div" class="animation-wrapper" :name="`slide-${direction}`">
            <div class="slide" v-for="(slide, index) in items" :key="index" v-show="currentIndex === index" :style="{
                backgroundImage: `url(${slide.image})`,
                backgroundColor: slide.color.background,
                color: slide.color.text,
            }">
                <div class="background-overlay" :style="`background: linear-gradient(90deg, ${slide.color.background}ff 33%, ${slide.color.background}40 66%)`"></div>
                <div class="text-wrapper">
                    <h2 v-if="slide.superHeadline || slide.headline">
                        <span v-if="slide.superHeadline">{{ slide.superHeadline }}</span>
                        <b v-if="slide.headline">{{ slide.headline}}</b>
                    </h2>
                    <div class="text">
                        <p v-if="slide.text" v-html="slide.text"></p>
                    </div>
                    <IodButton v-if="slide.button" is="a" :label="slide.button.label" :href="slide.button.href ?? '#'" :target="slide.button.target ?? '_blank'" variant="contained"/>
                </div>
            </div>
        </TransitionGroup>
    </div>
</template>

<script setup>
    import { ref } from 'vue'



    const items = ref([
        {
            superHeadline: 'Ihr neues',
            headline: 'Dashboard',
            text: '<b>Brandneu und nun noch besser auf Sie abgestimmt!</b> Wir haben das Dashboard für Sie überarbeitet und mit neuen Funktionen ausgestattet.',
            // button: {
            //     label: 'Zum Beitrag',
            //     href: '#',
            //     target: '_blank',
            // },
            color: {
                background: '#e00047',
                text: '#ffffff',
            },
            image: '/images/content/intranet/slide_new_dashboard.jpg',
        },
    ])

    const currentIndex = ref(0)
    const autoplayInterval = ref(7000)
    const direction = ref('left')
    let autoplay



    const next = () => {
        direction.value = 'left'
        currentIndex.value = (currentIndex.value + 1) % items.value.length
    }

    const previous = () => {
        direction.value = 'right'
        currentIndex.value = (currentIndex.value - 1 + items.value.length) % items.value.length
    }



    startAutoplay()

    function startAutoplay() {
        autoplay = setInterval(() => {
            next()
        }, autoplayInterval.value)
    }

    function stopAutoplay() {
        clearInterval(autoplay)
    }
</script>

<style lang="sass" scoped>
    .slider-container
        display: flex
        border-radius: var(--radius-xl)
        background: var(--color-background-soft)
        position: relative
        overflow: hidden

        .controls
            background: var(--color-background)
            border-radius: var(--radius-xl) 0 var(--radius-xl) 0
            position: absolute
            z-index: 1000
            bottom: 0
            right: 0
            display: flex
            padding-top: .5rem
            padding-left: .5rem
            gap: .5rem
            box-shadow: .5rem .5rem 0 var(--color-background)

            &::before,
            &::after
                content: ''
                position: absolute
                height: 2rem
                width: 2rem
                border-radius: 0 0 var(--radius-xl) 0
                box-shadow: .5rem .5rem 0 var(--color-background)
                pointer-events: none

            &::before
                bottom: 0
                left: -2rem

            &::after
                top: -2rem
                right: 0

            .iod-button
                position: relative
                z-index: 1
                --local-color-background: var(--color-text)

        .animation-wrapper
            position: relative
            width: 100%
            height: 100%

        .slide-left-move,
        .slide-right-move,
        .slide-left-enter-active,
        .slide-right-enter-active,
        .slide-left-leave-active,
        .slide-right-leave-active
            transition: all 700ms ease

        .slide-left-enter-from,
        .slide-right-leave-to
            transform: translate(100%, 0) !important

        .slide-right-enter-from,
        .slide-left-leave-to
            transform: translate(-100%, 0) !important

        .slide-left-leave-active,
        .slide-right-leave-active
            top: 0
            position: absolute

        .slide
            width: 100%
            min-height: 470px
            background: url('/images/content/intranet/slide_new_dashboard.jpg') no-repeat center center
            color: var(--color-text)
            background-color: var(--color-background-soft)
            background-size: cover
            background-blend-mode: multiply
            padding: 3rem
            display: flex
            flex-direction: column

            .background-overlay
                content: ''
                position: absolute
                top: 0
                left: 0
                right: 0
                bottom: 0
                background: linear-gradient(90deg, #e00047ff 33%, #e0004740 66%)
                pointer-events: none

            .text-wrapper
                flex: 1
                position: relative
                z-index: 1
                display: flex
                flex-direction: column
                color: inherit
                gap: 1rem
                max-width: 400px

                h2
                    display: flex
                    flex-direction: column
                    font-size: clamp(1.5rem, 7vw, 2rem)
                    font-weight: 400
                    margin: 0
                    color: inherit

                    span
                        display: inline

                    b
                        display: inline
                        font-weight: 700
                        font-size: clamp(2rem, 10vw, 4rem)

                .text
                    flex: 1

                .iod-button
                    --local-color-background: currentColor

    @media screen and (max-width: 500px)
        .slider-container
            .slide
                padding: 1.5rem
                padding-block: 2rem 4rem
</style>