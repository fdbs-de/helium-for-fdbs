<template>
    <GuestLayout>
        <main>
            <section id="hero-section">
                <div class="limiter">
                    <div class="inner-wrapper" :style="'background-image: url('+(image || '')+')'">
                        <h1>{{title}}</h1>
                    </div>
                </div>
            </section>
            <section id="contact-section">
                <div class="limiter">
                    <div class="inner-wrapper">
                        <h2>Ihre Ansprechpartner</h2>
                        <div class="scroll-wrapper">
                            <button class="scroll-button first" :class="{'clickable': canScrollLeft}" type="button" @click="prev">chevron_left</button>
                            <div class="scroller" ref="scroller">
                                <slot name="ansprechpartner" />
                            </div>
                            <button class="scroll-button last" :class="{'clickable': canScrollRight}" type="button" @click="next">chevron_right</button>
                        </div>
                    </div>
                </div>
            </section>
            <section id="content-section">
                <div class="limiter text-limiter">
                    <slot />
                </div>
            </section>
        </main>
    </GuestLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import GuestLayout from '@/Layouts/Guest.vue'
    import { ref, computed, onMounted } from 'vue'

    defineProps({
        title: String,
        image: String,
    })



    const scroller = ref(null)
    const canScrollLeft = ref(false)
    const canScrollRight = ref(false)

    const prev = () => scroller.value.scrollLeft -= 220
    const next = () => scroller.value.scrollLeft += 220

    onMounted(() => {
        scroller.value.addEventListener('scroll', evaluateScroll)
        evaluateScroll()
    })

    const evaluateScroll = () => {
        const { scrollLeft, scrollWidth, clientWidth } = scroller.value
        canScrollLeft.value = scrollLeft > 0
        canScrollRight.value = scrollLeft + clientWidth < scrollWidth
    }
</script>

<style lang="sass">
    .service-scroll-item
        grid-row: 1
        scroll-snap-align: start
        // scroll-margin: 0 10px
        // margin: 0 10px
</style>

<style lang="sass" scoped>
    #hero-section
        display: flex
        margin-top: calc(var(--height-header) + 1rem)

        .inner-wrapper
            display: flex
            align-items: center
            justify-content: center
            height: 300px
            padding: 0 1rem
            background-color: var(--color-background-soft)
            background-position: center
            background-repeat: no-repeat
            background-size: cover
            border-radius: var(--radius-xl)

        h1
            color: var(--color-primary)
            text-align: center
            font-weight: 700

    #contact-section
        margin-top: 2rem

        .inner-wrapper
            padding-top: 2rem
            border-radius: var(--radius-xl)
            background: var(--color-background-soft)

            h2
                margin: 0
                text-align: center
                padding-bottom: 7px

        .scroll-wrapper
            position: relative
            padding: 0 2.25rem
            width: min-content
            max-width: 100%
            margin: 0 auto

            .scroll-button
                height: 3.5rem
                width: 3.5rem
                display: grid
                place-content: center
                box-shadow: var(--shadow-elevation-medium)
                background: var(--color-primary)
                color: var(--color-background)
                font-family: var(--font-icon)
                font-size: 2rem
                border-radius: 50%
                border: none
                padding: 0
                user-select: none
                cursor: pointer
                position: absolute
                z-index: 1
                top: calc(50% - 1.75rem)
                transition: all 100ms, transform 200ms
                pointer-events: none
                transform: scale(0)

                &.first
                    left: .5rem

                &.last
                    right: .5rem

                &.clickable
                    transform: scale(1)
                    pointer-events: all

                &:hover
                    color: var(--color-primary)
                    background: var(--color-background)

                &:hover,
                &:focus
                    box-shadow: var(--shadow-elevation-high)

            .scroller
                display: grid
                gap: 32px
                grid-auto-columns: 220px
                padding: 32px 16px
                scroll-padding: 0 16px
                margin: 0
                overflow-x: scroll
                overflow-y: visible
                scroll-snap-type: x mandatory
                scroll-snap-points-y: repeat(220px)
                -ms-overflow-style: none
                scrollbar-width: none
                scroll-behavior: smooth

                &::-webkit-scrollbar
                    display: none

    #content-section
        padding-block: 4rem



    @media only screen and (max-width: 700px)
        #hero-section
            .inner-wrapper
                height: auto
                aspect-ratio: 2/1

        #contact-section
            margin-top: 1rem

            .scroll-wrapper
                padding: 0

                .scroll-button
                    display: none

                .scroller
                    grid-auto-columns: 170px
                    scroll-snap-points-y: repeat(170px)
                    -ms-overflow-style: initial
                    scrollbar-width: initial

                    &::-webkit-scrollbar
                        display: initial
</style>