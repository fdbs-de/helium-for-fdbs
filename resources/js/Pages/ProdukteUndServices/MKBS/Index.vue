<template>
    <GuestLayout>
        <Head>
            <title>Marketing & Kommunikation – FDBS Marketing</title>
        </Head>

        <section id="hero">
            <div class="limiter">
                <div class="hero-content">
                    <div class="bg" :style="`height: calc(100% - ${offset}px); top: ${offset}px;`">
                        <h1><b>Marketing</b> // <b>Kommunikation</b></h1>
                    </div>
                </div>
            </div>
        </section>

        <section id="about">
            <div class="limiter">
                <h2 class="mega-heading">
                    <div class="larger">
                        <span class="word">Wir </span>
                        <span class="word">sind </span>
                        <span class="word"><b>MKBS</b> ✨</span>
                    </div>
                    <br>
                    <br>
                    <span class="word">Wir </span>
                    <span class="word">kümmern </span>
                    <span class="word">uns </span>
                    <span class="word">um </span>
                    <span class="word">Ihr </span>
                    <span class="word">Marketing.</span>
                    <br>
                    <span class="word">Ob </span> 
                    <Link class="word fancy red" :href="route('mkbs.web')">Web</Link>
                    <span class="word">, </span>
                    <Link class="word fancy blue" :href="route('mkbs.social-media')">Social Media</Link>
                    <span class="word">, </span>
                    <Link class="word fancy yellow" :href="route('mkbs.print')">Print</Link>
                    <span class="word"> oder </span>
                    <Link class="word fancy green" :href="route('mkbs.crossmedia')">Crossmedia Marketing</Link>
                    <span class="word">.</span>
                    <br>
                    <span class="word">Wir </span>
                    <span class="word">bringen </span>
                    <span class="word">Sie </span>
                    <span class="word">an </span>
                    <span class="word">die </span>
                    <span class="word"><b>Spitze</b>! 💪</span>
                </h2>
            </div>
        </section>

        <section id="survey">
            <div class="limiter text-limiter">
                <h2>Wie zufrieden sind Sie mit uns?</h2>
                <p class="text-align-center">
                    Teilen Sie uns Ihre Meinung in einer kurzen Umfrage mit und helfen Sie uns aktiv, uns zu verbessern. <b>Wir freuen uns über Ihr Feedback!</b>
                </p>
                <div class="flex h-center v-center margin-top-2">
                    <mui-button as="a" target="_blank" href="/umfragen/mkbs-kundenzufriedenheit" size="large" label="Zur Kundenunfrage"/>
                </div>
            </div>
        </section>

        <section id="contacts">
            <div class="limiter">
                <h2>Unser Team</h2>
                <div class="grid">
                    <StaffCard
                        v-for="employee in departments.find(e => e.id === 'marketing').employees"
                        :key="employee.name"
                        :name="employee.name"
                        :job="employee.job"
                        :leader="employee.leader"
                        :tel="employee.tel"
                        :image="employee.image || '/images/content/mitarbeiter/missing.png'"
                        :overlay="employee.overlay"/>
                </div>
            </div>
        </section>
    </GuestLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import { ref } from 'vue'
    import departments from '@/Pages/Kontakt.json'
    
    import GuestLayout from '@/Layouts/Guest.vue'
    import StaffCard from '@/Components/Page/StaffCard.vue'



    const offset = ref(window.pageYOffset)

    window.addEventListener('scroll', () => {
        offset.value = window.pageYOffset
    })
</script>

<style lang="sass" scoped>
    section#hero
        display: flex
        margin-top: calc(var(--height-header) + 1rem)
        width: 100%

        .limiter
            display: flex

        .hero-content
            display: flex
            width: 100%
            aspect-ratio: 2
            position: relative
            overflow: hidden
            border-radius: var(--radius-xl)

            .bg
                position: absolute
                top: 0
                left: 0
                background: var(--color-background-soft)
                width: 100%
                height: 100%
                background-image: url('/images/content/mkbs/woman.jpg')
                background-size: cover
                background-position: center
                background-repeat: no-repeat
                border-radius: var(--radius-xl)
                overflow: hidden

            h1
                position: absolute
                z-index: 1
                bottom: 0
                left: 0
                width: 100%
                color: #ffffffcc
                padding: 4rem 1rem 2rem
                margin: 0
                text-align: center
                background: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.7) 70%)
                font-size: clamp(1.5rem, 5vw, 3rem)
                font-weight: 400

                b
                    color: #ffffff



    section#about
        padding: 12.5rem 0

        .mega-heading
            font-size: clamp(1.3rem, 5vw, 4.7rem)
            font-weight: 400
            margin: 0 0 4rem
            line-height: 1.4
            text-align: left
            font-family: var(--font-text)

            .larger
                font-size: clamp(2.5rem, 5vw, 6rem)
                font-weight: 700
                display: contents


            .word
                transition: opacity 100ms ease-in-out
                --color-local-primary: var(--color-heading)

                &.red
                    --color-local-primary: #eb3b5a

                &.blue
                    --color-local-primary: #4b7bec

                &.yellow
                    --color-local-primary: #f7b731

                &.green
                    --color-local-primary: #20bf6b

            &:has(.fancy:hover) .word:not(.fancy:hover)
                opacity: .5

            .fancy,
            b
                font-weight: 900
                color: transparent
                transition: all 100ms ease-in-out
                -webkit-text-stroke: 0.02em var(--color-local-primary)

            .fancy:hover
                color: var(--color-local-primary)


    
    section#survey
        padding-block: 5rem
        background: var(--color-background-soft)
        position: relative

        &::before,
        &::after
            content: ''
            width: 100%
            height: 1rem
            border-radius: 1rem
            background: var(--color-background)
            position: absolute

        &::before
            top: 0
            left: 0
            border-radius: 0 0 1rem 1rem

        &::after
            bottom: 0
            left: 0
            border-radius: 1rem 1rem 0 0

        h2
            font-size: clamp(1.5rem, 5vw, 2.5rem)
            margin: 0 0 3rem
            line-height: 1.4
            text-align: center
            font-family: var(--font-text)

    

    section#contacts
        padding-block: 10rem

        h2
            font-size: clamp(1.5rem, 5vw, 2.5rem)
            margin: 0 0 4rem
            line-height: 1.4
            text-align: center
            font-family: var(--font-text)
        
        .grid
            display: grid
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr))
            gap: 2rem



    @media only screen and (max-width: 1000px)
        section#about
            padding: 10rem 0

    @media only screen and (max-width: 600px)
        section#about
            padding: 5rem 0

            .mega-heading
                .fancy,
                b
                    color: var(--color-local-primary)
                    -webkit-text-stroke: 0 transparent
</style>