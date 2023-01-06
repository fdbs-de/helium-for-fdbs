<template>
    <GuestLayout>
        <Head>
            <title>Produkte & Services: Marketing & Kommunikation</title>
        </Head>

        <section id="hero">
            <div class="limiter">
                <div class="hero-content">
                    <img src="/images/content/mkbs/woman.jpg" alt="Willkommen; Bild von Jens Löser und Sebastian Gerlach">
                    <h1>
                        <span class="text-primary">Marketing & Kommunikation</span>
                        <span class="text-secondary">Wir machen Sie sichtbar</span>
                    </h1>
                </div>
            </div>
        </section>

        <section id="about">
            <div class="limiter text-limiter">
                <h2>Das sind wir</h2>
                <p>
                </p>
            </div>
        </section>

        <section id="development" style="--color-local-primary: #e00047;">
            <div class="limiter">
                <div class="card fullcolor">
                    <div class="image" style="background-image: url(/images/content/mkbs/web_dev.jpg);"></div>
                    <div class="content">
                        <h2>Web Entwicklung</h2>
                        <p>
                            Ob Ihre Webseite als reine Informationsquelle dient, als Online Shop fungiert oder ein Mix aus beidem ist. Design und
                            Usability spielen eine große Rolle. Wir beraten Sie gerne und setzen gemeinsam mit Ihnen die Grundsteine für Ihre
                            Onlinepräsenz.
                        </p>
                        <Link :href="route('home')">Mehr erfahren</Link>
                    </div>
                </div>
            </div>
        </section>

        <section id="social-media" style="--color-local-primary: #0652DD;">
            <div class="limiter">
                <div class="card">
                    <div class="content">
                        <h2>Social Media Marketing</h2>
                        <p>
                            Über die verschiedenen Social Media Kanäle kommunizieren Sie in Echtzeit mit Ihren Kunden, begegnen Ihnen auf Augenhöhe
                            und schaffen durch Ihre Onlinepräsenz eine ganz neue Art der Vertrauensbasis. Erfahren Sie hier mehr über die Vorteile
                            von Instagram, Facebook & Co.
                        </p>
                        <Link :href="route('home')">Mehr erfahren</Link>
                    </div>
                    <div class="image" style="background-image: url(/images/content/mkbs/web_dev.jpg);"></div>
                </div>
            </div>
        </section>

        <section id="print" style="--color-local-primary: #10ac84;">
            <div class="limiter">
                <div class="card fullcolor">
                    <div class="image" style="background-image: url(/images/content/mkbs/web_dev.jpg);"></div>
                    <div class="content">
                        <h2>Print Design</h2>
                        <p>
                            Broschüren, Imageflyer, Handzettel und Couponhefte oder Stempelkärtchen sind fester Bestandteil der
                            Unternehmenskommunikation. Sie unterstreichen den Onlineaspekt und wirken unterstützend in der Werbung. Bei uns bekommen
                            Sie Ihre gesamte Ausstattung komplett aus einer Hand.
                        </p>
                        <Link :href="route('home')">Mehr erfahren</Link>
                    </div>
                </div>
            </div>
        </section>

        <section id="online-marketing" style="--color-local-primary: #e84393;">
            <div class="limiter">
                <div class="card">
                    <div class="content">
                        <h2>Online Marketing</h2>
                        <p>
                            Lassen Sie sich von uns beraten wie Sie sich und Ihr Unternehmen gezielt auf dem Onlinemarkt platzieren und die
                            vielfältigen Möglichkeiten die Ihnen dort geboten werden sinnvoll nutzen. Tauchen Sie gemeinsam mit uns in die Welt des
                            Online Marketing.
                        </p>
                        <Link :href="route('home')">Mehr erfahren</Link>
                    </div>
                    <div class="image" style="background-image: url(/images/content/mkbs/web_dev.jpg);"></div>
                </div>
            </div>
        </section>

        <section id="contacts">
            <div class="limiter text-limiter">
                <h2>Wir sind Ihre Ansprechpartner</h2>
                <div class="grid">
                    <StaffCard
                        class="service-scroll-item"
                        v-for="employee in departments.find(e => e.id === 'marketing').employees"
                        :key="employee.name"
                        :name="employee.name"
                        :job="employee.leader ? 'Leitung' : null"
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
    import departments from '@/Pages/Kontakt.json'
    
    import GuestLayout from '@/Layouts/Guest.vue'
    import StaffCard from '@/Components/Page/StaffCard.vue'
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
            flex-direction: column
            justify-content: flex-end
            width: 100%
            aspect-ratio: 2
            position: relative
            border-radius: var(--radius-xl)
            overflow: hidden

            img
                position: absolute
                top: 0
                left: 0
                background: var(--color-background-soft)
                width: 100%
                height: 100%
                object-fit: cover

            h1
                position: relative
                z-index: 1
                color: white
                padding: 4rem 1rem 2rem
                margin: 0
                display: flex
                flex-direction: column
                align-items: center
                text-align: center
                gap: 1rem
                background: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.7) 70%)

                .text-primary
                    font-size: clamp(1.5rem, 5vw, 3rem)
                    font-weight: 700

                .text-secondary
                    font-size: clamp(1.2rem, 3vw, 2rem)
                    font-weight: 400
                    opacity: .8

    section#about,
    section#development,
    section#social-media,
    section#print,
    section#online-marketing,
    section#contacts
        padding: 4rem 0
        --color-local-primary: var(--color-heading)

        h2
            text-align: center
            font-weight: 700
            margin: 0
            color: var(--color-local-primary)

        a
            color: var(--color-local-primary)

        .card
            display: flex
            align-items: center
            gap: 2rem

            &.fullcolor
                background: var(--color-local-primary)
                border-radius: var(--radius-xl)

                h2
                    color: white

                p
                    color: #ffffffcc

                a
                    color: white

                > div:first-child
                    border-radius: var(--radius-xl) 0 0 var(--radius-xl)

                > div:last-child
                    border-radius: 0 var(--radius-xl) var(--radius-xl) 0

                > .content:first-child
                    padding-left: 2rem

                > .content:last-child
                    padding-right: 2rem

            .image
                flex: 1
                aspect-ratio: 16/9
                border-radius: var(--radius-xl)
                background-size: cover
                background-position: center
                background-repeat: no-repeat
                filter: saturate(0)

            .content
                flex: 1
                padding: 2rem 0
                display: flex
                flex-direction: column
                justify-content: center
                gap: 1rem

                h2
                    text-align: left

        .grid
            display: grid
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr))
            gap: 2rem
</style>