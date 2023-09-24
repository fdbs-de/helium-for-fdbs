<template>
    <section class="fdbs-kundendienst">
        <div class="limiter">
            <div class="content-wrapper">
                <div class="plain text-plain">
                    <h2>
                        Planung<br>
                        Montage<br>
                        Reparatur
                    </h2>
                    <p>
                        Unser technischer Kundendienst für Ihre<br>
                        Gastro-Küchen, Maschinen und mehr.
                    </p>
                    <IodButton is="a" label="Kontaktieren Sie uns" href="/produkte-und-services/technischer-kundendienst"/>
                </div>
                <div class="plain image-plain">
                    <img src="/images/content/customerservice/collage.png" alt="">
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
    import { Link } from '@inertiajs/inertia-vue3'
    import { ref, computed } from 'vue'
</script>

<style lang="sass" scoped>
    .fdbs-kundendienst
        width: 100%
        position: relative
        padding-block: 10rem

        .content-wrapper
            display: flex
            position: relative
            z-index: 2
            gap: 4rem

            .plain
                flex: 1
                display: flex
                flex-direction: column
                justify-content: center
                gap: 2rem

                > h2
                    font-size: clamp(2rem, 10vw, 3.5rem)
                    font-weight: 900
                    margin-block: 0
                    color: var(--color-primary)

                > p
                    opacity: .9
                
                > .iod-button
                    max-width: 400px

                > img
                    width: 100%
                    display: flex



    @media only screen and (max-width: 700px)
        .fdbs-kundendienst
            .content-wrapper
                flex-direction: column
                align-items: center

                .plain
                    align-items: stretch
                    text-align: center

                .text-plain
                    order: 2

                .image-plain
                    max-width: 300px


    
    @media only screen and (max-width: 500px)
        .fdbs-kundendienst
            padding-block: 6rem

            .content-wrapper
                gap: 6rem
</style>