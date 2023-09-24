<template>
    <section class="fdbs-video-hero">
        <video src="/images/content/background_loop.mp4" loop muted autoplay controls="false"></video>
        <div class="content-wrapper">
            <h1>Wir sind FDBS</h1>
            <p class="limiter text-limiter">
                Ihr kompetenter Großhandel und Foodservice in Braunschweig.
                Von <Link :href="route('ps.foodservice')">Food</Link>
                über <Link style="white-space: nowrap;" :href="route('ps.foodservice')">Non-Food</Link>
                bis hin zum <Link :href="route('mkbs')">Marketing</Link>
                und <Link :href="route('ps.technischer-kundendienst')">technischen Kundendienst</Link> können wir Ihnen helfen.
            </p>
            <a class="bottom-cta" href="#services">
                Unsere Services
                <img src="/images/assets/arrow_white_down.svg" alt="arrow down">
            </a>
        </div>
    </section>
</template>

<script setup>
    import { Link } from '@inertiajs/inertia-vue3'
    import { ref, computed } from 'vue'
</script>

<style lang="sass" scoped>
    .fdbs-video-hero
        width: 100%
        position: relative
        background: var(--color-background-soft)

        video
            width: 100%
            height: 100%
            object-fit: cover
            position: absolute
            top: 0
            left: 0
            z-index: 0

        &::after
            content: ''
            background-color: rgb(white, 0.85)
            background-image: linear-gradient(rgb(white, 0) 50%, rgb(white, 1) 100%)
            width: 100%
            height: 100%
            position: absolute
            bottom: 0
            left: 0
            z-index: 1

        .content-wrapper
            min-height: calc(100vh - 4.5rem)
            display: flex
            flex-direction: column
            justify-content: center
            align-items: center
            position: relative
            z-index: 2
            padding: 2rem 1rem 6rem
            font-family: var(--font-heading)

            > h1
                font-size: clamp(2.2rem, 10vw, 6rem)
                font-weight: 700
                color: var(--color-primary)
                margin-block: 1rem

            > p
                font-size: clamp(1.25rem, 2vw, 1.7rem)
                text-align: center
                color: var(--color-text)

                a
                    font-weight: 700

            .bottom-cta
                height: 3rem
                color: var(--color-text)
                background: var(--color-background)
                border-radius: 3rem
                padding: 0 2rem
                display: flex
                align-items: center
                justify-content: center
                font-family: var(--font-heading)
                font-weight: 500
                font-size: 1rem
                white-space: nowrap
                filter: drop-shadow(0 .5rem .5rem rgb(0 0 0 / .15))
                position: absolute
                bottom: 2rem
                left: 50%
                transform: translate(-50%, 0)
                animation: float 4s infinite ease-in-out

                > img
                    position: absolute
                    top: 100%
                    left: 50%
                    transform: translate(-50%, 0)
                    pointer-events: none

                @keyframes float
                    0%
                        transform: translate(-50%, -1rem)
                    50%
                        transform: translate(-50%, 0rem)
                    100%
                        transform: translate(-50%, -1rem)
</style>