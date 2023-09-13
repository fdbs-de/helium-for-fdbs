<template>
    <section class="fdbs-marketing">
        <div class="limiter">
            <div class="content-wrapper">
                <div class="plain text-plain">
                    <h2>Wir machen Ihr Unternehmen sichtbar!</h2>
                    <div>
                        <p>
                            Unsere Marketingabteilung macht<br>
                            Ihr Unternehmen bekannt.
                        </p>
                        <p>
                            Ob im Web, auf Social Media oder als Print:<br>
                            <b>wir bringen Sie an die Spitze!</b>
                        </p>
                    </div>
                    <IodButton is="a" label="Jetzt durchstarten" href="/mkbs"/>
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
    .fdbs-marketing
        --cut: 5vw
        width: 100%
        position: relative
        background: var(--color-background-soft)
        background-image: url('/images/content/mkbs/woman.jpg')
        background-size: cover
        background-position: center
        background-repeat: no-repeat
        background-attachment: fixed
        clip-path: polygon(0 0, 100% var(--cut), 100% 100%, 0 calc(100% - var(--cut)))

        &::after
            content: ''
            background-image: linear-gradient(90deg, rgb(#e00047, 1) 40%, rgb(#e00047, .2) 60%)
            width: 100%
            height: 100%
            position: absolute
            bottom: 0
            left: 0
            z-index: 1

        .content-wrapper
            display: flex
            position: relative
            z-index: 2
            gap: 4rem
            padding-block: 10rem 12rem
            
            .plain
                color: var(--color-on-primary)
                display: flex
                flex-direction: column
                align-items: stretch
                position: relative
                z-index: 2
                gap: 2rem

                > h2
                    font-size: clamp(2rem, 10vw, 3.5rem)
                    font-weight: 600
                    margin-block: 0
                    color: inherit
                    max-width: 700px

                > div p
                    color: inherit
                    opacity: .9
                
                > .iod-button
                    --local-color-background: var(--color-on-primary)
                    --local-color-text: var(--color-primary)
                    max-width: 400px



    @media only screen and (max-width: 500px)
        .fdbs-marketing
            &::after
                background-image: linear-gradient(0deg, rgb(#e00047, 1) 20%, rgb(#e00047, .2) 80%)

            .content-wrapper
                padding-block: 6rem
                gap: 2rem

                .plain
                    text-align: center
                    align-items: center
</style>