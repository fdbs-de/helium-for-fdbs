<template>
    <GuestLayout>
        <Head>
            <title>The Competence in Foodservice</title>
        </Head>

        <main>
            <section id="hero">
                <div class="limiter">
                    <img src="/images/content/slider/welcome_banner.png" alt="FDBS Willkommen; Bild von Jens Löser und Sebastian Gerlach">
                </div>
            </section>

            <section id="about">
                <div class="limiter">
                    <div class="about-card">
                        <div class="text-wrapper flex vertical">
                            <h2>Das sind Wir!</h2>
                            <p>
                                <b>Wir sind FDBS</b>...<br>
                                Ihre Kompetenz rund um den Foodservice.
                                Von Lebensmitteln, über Non-Food bis hin zum Marketing können wir Ihnen helfen.
                            </p>
                            <div class="spacer"></div>
                            <Link :href="route('philosophie')">Mehr Über Uns</Link>
                        </div>
                        <div class="image-wrapper">
                            <img src="/images/content/about.png" alt="FDBS">
                        </div>
                    </div>
                </div>
            </section>

            <section id="general">
                <div class="limiter flex gap">
                    <div class="flex-1">
                        <span class="icon" aria-hidden="true">verified</span>
                        <h2>Angebote</h2>
                        <p>
                            Finden Sie unsere aktuellen Monats- und Grillangebot ganz einfach zum Download.
                        </p>
                        <Link :href="route('ps.angebote')">Zu den Angeboten</Link>
                    </div>
                    <div class="flex-1">
                        <span class="icon" aria-hidden="true">work</span>
                        <h2>Karriere</h2>
                        <p>
                            Wir suchen Sie! Sehen Sie sich unsere aktuellen Stellenangebote an.
                        </p>
                        <Link :href="route('karriere')">Job Finden</Link>
                    </div>
                    <div class="flex-1">
                        <span class="icon" aria-hidden="true">content_paste</span>
                        <h2>Seminare</h2>
                        <p>
                            In Kürze werden Sie wieder unser breites Angebot an Seminaren und Workshops sehen.
                        </p>
                        <Link :href="route('ps.seminare')">Mehr Erfahren</Link>
                    </div>
                </div>
            </section>

            <section id="products">
                <div class="limiter">
                    <h2 class="text-align-center">Was wir für Sie tun können</h2>
                    <p class="text-align-center">
                        Unsere breite Auswahl an Produkten und Services für Ihr Unternehmen
                    </p>
                    <div class="grid">
                        <Card name="Foodservice" alt="Foodservice" cover :link="route('ps.foodservice')" image="/images/content/services/cover/foodservice_cover.png"/>
                        <Card name="Unsere Marken" alt="Unsere Marken" cover :link="route('ps.marken')" image="/images/content/services/cover/marken_cover.png"/>
                        <Card name="Fachberatung: Käse und Salate" alt="Fachberatung: Käse und Salate" cover :link="route('ps.fachberatung-kaese-und-salate')" image="/images/content/services/cover/kaese_und_salate_cover.png"/>
                        <Card name="Marketing & Kommunikation" alt="Marketing & Kommunikation" cover :link="route('ps.marketing-und-kommunikation')" image="/images/content/services/cover/mkbs_cover.png"/>
                        <Card name="Technischer Kundendienst" alt="Technischer Kundendienst" cover :link="route('ps.technischer-kundendienst')" image="/images/content/services/cover/technischer_kundendienst_cover.png"/>
                        <Card name="Seminare" alt="Seminare" cover :link="route('ps.seminare')" image="/images/content/services/cover/seminare_cover.png"/>
                    </div>
                </div>
            </section>

            <section id="products">
                <div class="limiter">
                    <ProductSlider :slides="slides"/>
                </div>
            </section>
        </main>
    </GuestLayout>
</template>

<script setup>
    import GuestLayout from '@/Layouts/Guest.vue'
    import Card from '@/Components/Page/Card.vue'
    import ProductSlider from '@/Components/Page/ProduktSlider.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import { ref } from 'vue'

    const slides = ref([
        {
            name: 'Eichenhof Fleisch',
            color: '#166938',
            text: 'Heute sind lückenlose Informationsketten zu den Themen Aufzucht, Haltung, Futter und Schlachtung in der Fleischproduktion wichtiger denn je! Heben Sie sich deutlich ab vom Standard und setzen Sie auf Qualität, Sicherheit und Vertrauen – mit der Qualitätsmarke Eichenhof!',
            headlineImage: {
                src: '/images/content/marken/eichenhof/eichenhof_text.svg',
                alt: 'Eichenhof',
            },
            cover: {
                src: '/images/content/marken/eichenhof/eichenhof_cover.png',
                alt: 'Eichenhof Fleisch',
            },
            link: route('ps.marken.eichenhof'),
        },

        {
            name: 'Il Campese',
            color: '#eb920e',
            text: 'Das Freilandhähnchen „Il Campese“ des Familienunternehmens Amadori ist ein Geschmackserlebnis und etwas Besonderes auf dem deutschen Markt: Denn abseits der kritischen Vogelzugrouten können diese Tiere in der Region Apulien im Süden Italiens im Freien entspannt aufwachsen – schmecken Sie den Unterschied!',
            headlineImage: {
                src: '/images/content/marken/il-campese/ilcampese_text.svg',
                alt: 'Il Campese',
            },
            cover: {
                src: '/images/content/marken/il-campese/ilcampese_cover.png',
                alt: 'Il Campese',
            },
            link: route('ps.marken.il-campese'),
        },

        {
            name: 'Maxi France',
            color: '#b61615',
            text: 'Mit Maxi France erhalten Sie ein hochwertiges, französisches Marken-Jungbullenfleisch. Das Fleisch für die Maxi France Produkte kommt ausnahmslos von vorab geprüften familiengeführten Bauernhöfen. Artgerechte Aufzucht, natürliche Haltungsbedingungen und kurze Transportwege werden großgeschrieben – das schmeckt man auch!',
            headlineImage: {
                src: '/images/content/marken/maxi-france/maxifrance_text.svg',
                alt: 'Maxi France',
            },
            cover: {
                src: '/images/content/marken/maxi-france/maxifrance_cover.png',
                alt: 'Maxi France',
            },
            link: route('ps.marken.maxi-france'),
        },
    ])
</script>

<style lang="sass" scoped>
    main
        display: flex
        flex-direction: column

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
        padding-block: 7rem

        .about-card
            background: var(--color-background-soft)
            border-radius: 12px
            display: flex
            overflow: hidden

            .text-wrapper
                width: 50%
                padding: 2rem
                color: var(--color-heading)

                h2
                    margin: 0
                    font-weight: 600

                a
                    display: flex
                    align-items: center
                    justify-content: center
                    background: var(--color-primary)
                    color: var(--color-background)
                    width: 160px
                    border-radius: .5rem
                    height: 2.5rem
                    font-size: .8rem
                    letter-spacing: .05rem
                    font-weight: 500
                    text-transform: uppercase
                    text-decoration: none

                    &:hover
                        background: var(--color-primary-soft)

            .image-wrapper
                flex: 1

                img
                    width: 100%
                    height: 100%
                    object-fit: cover
                    display: flex

    section#general
        background: var(--color-primary)
        color: var(--color-background)
        padding-block: 5rem

        .limiter
            gap: 2rem

        .flex-1
            border: 2px solid var(--color-primary-soft)
            width: 100%
            border-radius: .7rem
            padding: 0 2rem 2rem
            margin-top: 2.5rem

        .icon
            height: 5rem
            width: 5rem
            border: 2px solid var(--color-primary-soft)
            color: var(--color-background)
            background: var(--color-primary)
            border-radius: .8rem
            display: grid
            place-items: center
            font-size: 2.5rem
            font-family: var(--font-icon)
            user-select: none
            margin: -2.5rem auto 2rem

        h2
            margin-block: 0 .5rem
            color: inherit
            font-weight: 500

        p
            margin: 0
            margin-bottom: 2rem

        a
            display: flex
            align-items: center
            justify-content: center
            background: var(--color-background)
            width: 100%
            border-radius: .325rem
            height: 2.5rem
            font-size: .8rem
            letter-spacing: .05rem
            font-weight: 500
            text-transform: uppercase
            text-decoration: none

            &:hover
                background: var(--color-background-soft)

    section#products
        padding-block: 7rem

        h2
            margin: 0
            font-weight: 600
            font-size: 3.5em

        p
            margin: 0
            font-size: 1.3em

        .grid
            display: grid
            gap: 3rem
            margin-top: 3rem
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr))



    @media only screen and (max-width: 900px)
        section#general
            padding-block: 1rem 3rem

            .limiter
                max-width: 600px
                flex-direction: column
                gap: 1rem

                .flex-1
                    margin-top: 4rem
                    padding: 0 1rem 1rem

                    h2, p
                        text-align: center

    @media only screen and (max-width: 700px)
        section#about
            padding-block: 5rem

            .limiter
                max-width: 600px

                .about-card
                    flex-direction: column
                    
                    .text-wrapper
                        width: 100%
                        padding: 1.5rem 1rem 1rem
                        order: 1

                        a
                            width: 100%

        section#products
            padding-block: 5rem

            .limiter
                max-width: 600px

            h2
                font-size: 1.6rem

            p
                font-size: 1rem
</style>