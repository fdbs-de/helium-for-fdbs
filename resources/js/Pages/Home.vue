<template>
    <GuestLayout>
        <Head>
            <title>The Competence in Foodservice</title>
        </Head>

        <main>
            <section id="hero">
                <div class="limiter">
                    <img src="/images/content/test_banner.jpg" alt="FDBS">
                </div>
            </section>

            <section id="about">
                <div class="limiter flex gap v-center">
                    <div class="flex-1">
                        <h2>Das sind Wir!</h2>
                        <p>
                            Wir sind FDBS, Ihre Kompezension rund um den Foodservice.
                            Von Lebensmitteln, über Non-Food bis hin zum Marketing können wir Ihnen helfen.
                        </p>
                        <Link :href="route('philosophie')">Mehr Über Uns</Link>
                    </div>
                    <div class="flex-1">
                        <img src="/images/content/test_banner.jpg" alt="FDBS">
                    </div>
                </div>
            </section>

            <section id="general">
                <div class="limiter flex gap v-center">
                    <div class="flex-1">
                        <span class="icon" aria-hidden="true">verified</span>
                        <h2>Angebote</h2>
                        <p>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Fuga quisquam totam
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Fuga quisquam totam.
                        </p>
                        <Link :href="route('angebote')">Mehr Erfahren</Link>
                    </div>
                    <div class="flex-1">
                        <span class="icon" aria-hidden="true">work</span>
                        <h2>Karriere</h2>
                        <p>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Fuga quisquam totam
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Fuga quisquam totam.
                        </p>
                        <Link :href="route('karriere')">Job Finden</Link>
                    </div>
                    <div class="flex-1">
                        <span class="icon" aria-hidden="true">content_paste</span>
                        <h2>Seminare</h2>
                        <p>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Fuga quisquam totam
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Fuga quisquam totam.
                        </p>
                        <Link :href="route('seminare')">Mehr Erfahren</Link>
                    </div>
                </div>
            </section>

            <section id="products">
                <div class="limiter">
                    <h2>Was wir für Sie tun können</h2>
                    <p>
                        Unsere breite Auswahl an Produkten und Services für Ihr Unternehmen:
                    </p>
                    <div class="grid">
                        <Link class="item" :href="route('foodservice')">
                            <img src="/images/content/test_banner.jpg">
                        </Link>

                        <Link class="item" :href="route('unsere-marken')">
                            <img src="/images/content/test_banner.jpg">
                        </Link>

                        <Link class="item" :href="route('fachberatung-kaese-und-salate')">
                            <img src="/images/content/test_banner.jpg">
                        </Link>

                        <Link class="item" :href="route('marketing-und-kommunikation')">
                            <img src="/images/content/test_banner.jpg">
                        </Link>

                        <Link class="item" :href="route('technischer-kundendienst')">
                            <img src="/images/content/test_banner.jpg">
                        </Link>

                        <Link class="item" :href="route('seminare')">
                            <img src="/images/content/test_banner.jpg">
                        </Link>
                    </div>
                </div>
            </section>
        </main>
    </GuestLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3'
import GuestLayout from '@/Layouts/Guest.vue'
</script>

<style lang="sass" scoped>
    main
        display: flex
        flex-direction: column

        img
            width: 100%
            border-radius: 8px

    section#hero
        display: flex
        margin-top: var(--height-header)
        width: 100%
        background: var(--color-background-soft)

        .limiter
            display: flex

        img
            width: 100%
            border-radius: 0

    section#about
        padding-block: 5rem

        h2
            margin-top: 0
            font-weight: 600

    section#general
        background: var(--color-primary)
        color: var(--color-background)
        padding-block: 5rem

        .limiter
            gap: 3rem

        .icon
            height: 5rem
            width: 5rem
            color: var(--color-background)
            background: #ffffff33
            border-radius: .8rem
            display: grid
            place-items: center
            font-size: 2.5rem
            font-family: var(--font-icon)
            user-select: none
            margin-bottom: 2rem

        h2
            margin-block: 0 .5rem
            color: inherit
            font-weight: 500

        p
            margin: 0
            opacity: .9
            margin-bottom: 2rem

        a
            display: flex
            align-items: center
            justify-content: center
            background: var(--color-background)
            width: 160px
            border-radius: .5rem
            height: 2.5rem
            font-size: .8rem
            letter-spacing: .05rem
            font-weight: 500
            text-transform: uppercase
            text-decoration: none
            transition: all .2s ease-in-out

            &:hover
                color: var(--color-primary)
                text-decoration: underline

    section#products
        padding-block: 5rem

        h2
            margin: 0
            font-weight: 600

        p
            margin: 0

        .grid
            display: grid
            gap: 3rem
            margin-top: 3rem
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr))

            .item
                display: flex
                position: relative
                aspect-ratio: 3/2
                border-radius: 8px
                overflow: hidden

                &:hover,
                &:focus
                    img
                        transform: scale(1.1)
                img
                    border-radius: 0
                    position: absolute
                    top: 0
                    left: 0
                    width: 100%
                    height: 100%
                    transition: all 200ms



    @media only screen and (max-width: 700px)
        section#about
            .limiter
                flex-direction: column
                gap: 2rem
                
        section#general
            .limiter
                flex-direction: column
                gap: 5rem
</style>