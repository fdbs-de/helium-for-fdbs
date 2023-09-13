<template>
    <section class="fdbs-marken" :style="{padding, backgroundColor}">
        <component class="he-text-section-limiter" :is="LimiterManifest.component" :size="size">
            <h2>Unsere Marken</h2>
            <div class="grid">
                <a class="flex-1" href="/produkte-und-services/marken/il-campese">
                    <img src="/images/content/marken/il-campese/ilcampese_cover.png">
                </a>
                <a class="flex-1 highlight" href="/produkte-und-services/marken/eichenhof">
                    <img src="/images/content/marken/eichenhof/eichenhof_cover.png">
                </a>
                <a class="flex-1" href="/produkte-und-services/marken/maxi-france">
                    <img src="/images/content/marken/maxi-france/maxifrance_cover.png">
                </a>
            </div>
        </component>
    </section>
</template>

<script setup>
    import { ref } from 'vue'
    import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'
    
    
    
    defineProps({
        size: String,
        padding: String,
        backgroundColor: String,
    })
</script>

<style lang="sass" scoped>
    .fdbs-marken
        padding: 10rem 0

        h2
            font-size: clamp(2rem, 10vw, 3.5rem)
            text-align: center
            font-weight: 600
            margin-block: 0 4rem

        .grid
            display: flex
            gap: 4rem
            align-items: center

            a
                display: block
                width: 100%
                border-radius: 1rem
                overflow: hidden
                border: 1px solid var(--color-background-soft)
                flex: 50

                &.highlight
                    box-shadow: var(--shadow-elevation-high)
                    flex: 55

            img
                width: 100%
                display: flex

    @media only screen and (max-width: 700px)
        .fdbs-marken
            .grid
                gap: 2rem


    
    @media only screen and (max-width: 500px)
        .fdbs-marken
            padding: 6rem 0
            
            h2
                margin-bottom: 2rem

            .grid
                gap: .5rem

                a
                    flex: 1 !important
                    border-radius: .5rem !important
                    box-shadow: none !important
</style>