<template>
    <GuestLayout>
        <Head>
            <title>The Competence in Foodservice</title>
            <meta name="description" content="Wir sind FDBS – Ihre Kompetenz rund um den Foodservice. Von Food, über Non-Food bis hin zum Marketing und technischen Kundendienst können wir Ihnen helfen.">
        </Head>

        <main>
            <section id="hero">
                <div class="limiter">
                    <img src="/images/content/banner/home.webp" alt="Willkommen; Bild von Jens Löser und Sebastian Gerlach">
                </div>
            </section>

            <section id="about">
                <div class="limiter text-limiter">
                    <div class="about-card">
                        <div class="text-wrapper flex vertical">
                            <p>
                                <b>Wir sind FDBS</b> – Ihre Kompetenz rund um den Foodservice.
                                Von <Link :href="route('ps.foodservice')">Food</Link>,
                                über <Link :href="route('ps.foodservice')">Non-Food</Link>
                                bis hin zum <Link :href="route('ps.marketing-und-kommunikation')">Marketing</Link>
                                und <Link :href="route('ps.technischer-kundendienst')">technischen Kundendienst</Link> können wir Ihnen helfen.
                            </p>
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
                            Sehen Sie unser breites Angebot an Seminaren und Workshops.
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
            id: '1',
            name: 'Eichenhof Fleisch',
            color: '#166938',
            text: 'Heute sind lückenlose Informationsketten zu den Themen Aufzucht, Haltung, Futter und Schlachtung in der Fleischproduktion wichtiger denn je! Heben Sie sich deutlich ab vom Standard und setzen Sie auf Qualität, Sicherheit und Vertrauen – mit der Qualitätsmarke Eichenhof!',
            headlineImage: {
                src: '/images/content/marken/eichenhof/eichenhof_text.svg',
                alt: 'Eichenhof',
            },
            cover: {
                src: '/images/content/marken/eichenhof/eichenhof_cover.webp',
                alt: 'Eichenhof Fleisch',
            },
            link: route('ps.marken.eichenhof'),
        },

        {
            id: '2',
            name: 'Il Campese',
            color: '#eb920e',
            text: 'Das Freilandhähnchen „Il Campese“ des Familienunternehmens Amadori ist ein Geschmackserlebnis und etwas Besonderes auf dem deutschen Markt: Denn abseits der kritischen Vogelzugrouten können diese Tiere in der Region Apulien im Süden Italiens im Freien entspannt aufwachsen – schmecken Sie den Unterschied!',
            headlineImage: {
                src: '/images/content/marken/il-campese/ilcampese_text.svg',
                alt: 'Il Campese',
            },
            cover: {
                src: '/images/content/marken/il-campese/ilcampese_cover.webp',
                alt: 'Il Campese',
            },
            link: route('ps.marken.il-campese'),
        },

        {
            id: '3',
            name: 'Maxi France',
            color: '#b61615',
            text: 'Mit Maxi France erhalten Sie ein hochwertiges, französisches Marken-Jungbullenfleisch. Das Fleisch für die Maxi France Produkte kommt ausnahmslos von vorab geprüften familiengeführten Bauernhöfen. Artgerechte Aufzucht, natürliche Haltungsbedingungen und kurze Transportwege werden großgeschrieben – das schmeckt man auch!',
            headlineImage: {
                src: '/images/content/marken/maxi-france/maxifrance_text.svg',
                alt: 'Maxi France',
            },
            cover: {
                src: '/images/content/marken/maxi-france/maxifrance_cover.webp',
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
        margin-top: calc(var(--height-header) + 1rem)
        width: 100%

        .limiter
            display: flex

        img
            background: var(--color-background-soft)
            width: 100%
            aspect-ratio: 65/25
            object-fit: cover
            padding-inline: 2rem
            border-radius: var(--radius-xl)

    section#about
        padding-block: 4rem 13rem

        .about-card
            display: flex
            gap: 2rem
            align-items: center

            .text-wrapper
                flex: 3
                color: var(--color-heading)
                text-align: center

                p
                    margin: 0 auto
                    font-size: 1.75rem
                    font-family: var(--font-heading)

                a
                    color: inherit
                    font-weight: 600
                    text-decoration: underline
                    text-decoration-thickness: 2px
                    text-underline-offset: 3px
                    text-decoration-color: var(--color-primary)
                    transition: all 100ms

                    &:hover,
                    &:focus
                        color: var(--color-primary)

            .image-wrapper
                flex: 2

                img
                    width: 100%
                    height: 100%
                    object-fit: cover
                    display: flex
                    border-radius: var(--radius-m)

    section#general
        background: var(--color-primary)
        color: var(--color-background)
        padding-block: 7rem

        .limiter
            gap: 4rem

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
            margin-top: 5rem
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
        section#hero
            img
                aspect-ratio: 2/1
                width: 100%
                padding-inline: 1rem
                object-fit: contain
                object-position: bottom center
                
        section#about
            padding-block: 5rem

            .limiter
                max-width: 600px

                .about-card
                    flex-direction: column
                    
                    .text-wrapper
                        width: 100%

                        h2
                            font-size: 2.5rem

                        p
                            font-size: 1rem

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