<template>
    <section class="fdbs-kundendienst">
        <div class="limiter">
            <div class="flex v-center">
                <div class="content-wrapper flex-1">
                    <h2>
                        Planung<br>
                        Montage<br>
                        Reparatur
                    </h2>
                    <p>
                        Unser technischer Kundendienst für Ihre<br>
                        Gastro-Küchen, Maschinen und mehr.
                    </p>
                    <IodButton is="a" label="Jetzt durchstarten" href="/mkbs"/>
                </div>
                <img src="/images/content/customerservice/collage.png" alt="" class="flex-1">
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
            flex-direction: column
            align-items: stretch
            position: relative
            z-index: 2
            max-width: 700px
            gap: 2rem

            > h2
                font-size: clamp(2rem, 10vw, 3.5rem)
                font-weight: 900
                margin-block: 0
                color: var(--color-primary)

            p
                opacity: .9
            
            > .iod-button
                max-width: 400px

    @media only screen and (max-width: 1000px)
</style>