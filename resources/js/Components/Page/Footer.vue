<template>
    <footer>
        <div class="limiter certificate-row">
            <p>Wir sind zertifiziert durch:</p>
            <div class="divider"></div>
            <div class="wrapper">
                <a class="cert-wrapper" href="/downloads/zertifikate/qs_zertifikat_2022.pdf" target="_blank" rel="noopener noreferrer" style="border-radius: 0">
                    <img src="/images/assets/zertifikate/qs_logo.webp" alt="QS Zertifizierung">
                </a>
                <a class="cert-wrapper" href="/downloads/zertifikate/Bio_2022_A4.pdf" target="_blank" rel="noopener noreferrer">
                    <img src="/images/assets/zertifikate/bio_logo.webp" alt="Bio Zertifizierung">
                </a>
                <a class="cert-wrapper" href="/downloads/zertifikate/ifs_2022.pdf" target="_blank" rel="noopener noreferrer">
                    <img src="/images/assets/zertifikate/ifs_wholesale_logo.webp" alt="IFS Wholesale Zertifizierung">
                </a>
                <a class="cert-wrapper" href="/downloads/zertifikate/Zertifikat_Orgainvent.pdf" target="_blank" rel="noopener noreferrer">
                    <img src="/images/assets/zertifikate/orgainvent_logo.webp" alt="Orgainvent Zertifizierung">
                </a>
                <a class="cert-wrapper" href="/downloads/zertifikate/CrefoZert_2020_2030012751_Fleischer_Dienst_Braunschweig_eG.pdf" target="_blank" rel="noopener noreferrer">
                    <img src="/images/assets/zertifikate/crefo_logo.webp" alt="CreFo Zertifizierung">
                </a>
                <div class="cert-wrapper" href="#" target="_blank" rel="noopener noreferrer">
                    <img src="/images/assets/zertifikate/itw_logo.webp" alt="Initiative Tierwohl Zertifizierung">
                </div>
                <div class="cert-wrapper">
                    <img src="/images/assets/zertifikate/lucid_regnr_text.webp" alt="LUCID Registrierungsnummer: DE3379292435101">
                </div>
            </div>
        </div>

        <div class="limiter link-row">
            <div class="block">
                <h3 class="headline primary">Abholmarkt</h3>
                <div class="content">
                    <b>Öffnungszeiten:</b><br>
                    Mo - Do: 06:00 - 16:00<br>
                    Fr: 06:00 - 14:00<br>
                    <br>
                    <b>Bestellhotline:</b><br>
                    0531 210 55 23<br>
                    (besetzt von 6 bis 24 Uhr)<br>
                </div>
            </div>
            <div class="block">
                <h3 class="headline primary">Produkte & Services</h3>
                <nav class="navigation">
                    <Link class="link" v-for="item in productsMenu" :key="item.id" :href="item.href">{{item.label}}</Link>
                </nav>
            </div>
            <div class="block">
                <h3 class="headline primary">Über Uns</h3>
                <nav class="navigation">
                <Link class="link" v-for="item in aboutMenu" :key="item.id" :href="item.href">{{item.label}}</Link>
                </nav>
            </div>
            <div class="block">
                <h3 class="headline primary">Rechtliches</h3>
                <nav class="navigation">
                    <Link class="link" v-for="item in legalMenu" :key="item.id" :href="item.href">{{item.label}}</Link>
                </nav>
            </div>
        </div>

        <div class="limiter copyright-row">
            <div class="row">
                <div class="copyright">
                    <img src="/images/branding/logo_sloganless_black.svg" alt="FDBS Logo">
                    <span aria-hidden="true">© {{new Date().getFullYear()}}</span>
                </div>
                <div class="spacer"></div>
                <div class="social-wrapper">
                    <a href="https://g.page/r/CWfKbNs4inYXEAg/review" target="_blank">Bewerten Sie uns auf Google</a>
                    <span>•</span>
                    <button class="szb" @click="openPopup()">Hier nicht klicken</button>
                    <span>•</span>
                    <a href="https://www.linkedin.com/company/fdbsfoodservice" target="_blank" rel="opener">LinkedIn</a>
                    <a href="https://www.xing.com/pages/fleischer-dienst-braunschweig-eg" target="_blank" rel="opener">Xing</a>
                    <!-- <a href="#" target="_blank" rel="opener">YouTube</a> -->
                    <a href="https://www.instagram.com/fdbs_foodservice/" target="_blank" rel="opener">Instagram</a>
                    <a href="https://www.facebook.com/FleischerDienstBraunschweig" target="_blank" rel="opener">Facebook</a>
                    <a href="https://www.ebay-kleinanzeigen.de/pro/FDBS" target="_blank" rel="opener">Ebay</a>
                    <a href="https://job38.de/arbeitgeber/fdbs-69115" target="_blank" rel="opener">job38</a>
                </div>
            </div>
        </div>
    </footer>

    <Popup ref="easteregg_one" class="easteregg_one" @close="clearTimer()">
        <div class="flex padding-2 gap-2 vertical">
            <h3 class="margin-0 text-align-center">Sie haben die Selbstzerstörung eingeleitet!</h3>
            <hr>
            <div class="flex vertical">
                <h3 class="margin-0 text-align-center"><b>Selbstzerstörung in:</b></h3>
                <h2 class="margin-0 text-align-center heading">{{timer}} Sekunden</h2>
            </div>
            <hr>
        </div>
    </Popup>

    <div class="blend" :class="{'active': isBlack}"></div>
</template>

<script setup>
    import { Link } from '@inertiajs/inertia-vue3'
    import { mainMenu, aboutMenu, legalMenu } from '@/menus'
    import Popup from '@/Components/Form/Popup.vue'
    import { ref, computed } from 'vue'

    const productsMenu = computed(() => {
        return mainMenu.find(e => e.id === 'projekte-und-services')?.children || []
    })


    // EASTEREGG START //
    const easteregg_one = ref(null)
    const timer = ref(0)
    let interval = null
    const isBlack = ref(false)

    const openPopup = () => {
        timer.value = 15
        easteregg_one.value.open()
        interval = setInterval(reduceTimer, 1000)
    }

    const reduceTimer = () => {
        timer.value--
        if (timer.value <= 0) closePopup(true)
    }
    
    const closePopup = (playAnimation = false) => {
        clearTimer()

        setTimeout(() => {
            easteregg_one.value.close()
            if (playAnimation) animation()
        }, 600)
    }

    const clearTimer = () => {
        clearInterval(interval)
    }

    const animation = () => {
        isBlack.value = true

        setTimeout(() => {
            isBlack.value = false
        }, 3000)
    }
    // EASTEREGG END //
</script>

<style lang="sass" scoped>
    .easteregg_one
        .heading
            color: var(--color-primary)
            font-size: 3rem

    .szb
        background: none
        border: none
        color: var(--color-primary)
        cursor: pointer
        font-size: inherit
        font-weight: inherit
        font-family: inherit
        padding: 0

    .blend
        position: fixed
        z-index: 9999
        top: 0
        left: 0
        width: 100vw
        height: 100vh
        background-color: black
        opacity: 0
        transition: opacity 100ms ease-in-out
        pointer-events: none

        &.active
            opacity: 1
            pointer-events: all
</style>

<style lang="sass" scoped>
    footer
        background: var(--color-background-soft)
        display: flex
        flex-direction: column
        gap: calc(var(--su) * 3)
        padding-top: calc(var(--su) * 3)
        color: var(--color-text)
        --color-text: #525858

        .certificate-row
            display: flex
            flex-direction: column
            background: var(--color-background)
            box-shadow: var(--shadow-elevation-low)
            border-radius: calc(var(--su) * .5)
            padding: var(--su)
            border: 1px solid var(--color-background-soft)

            p
                margin: 0

            .wrapper
                display: flex
                flex-wrap: wrap
                align-items: center
                gap: calc(var(--su) * 2)
                margin-block: calc(var(--su) * 2) var(--su)

                .cert-wrapper
                    height: 5rem
                    border-radius: calc(var(--su) * .5)
                    filter: saturate(0)

                    img
                        height: 5rem
                        width: auto
                        max-width: 100%
                        object-fit: cover
                        border-radius: inherit

                    &:hover,
                    &:focus
                        filter: saturate(1)

        .link-row
            display: grid
            grid-template-columns: repeat(4,minmax(200px,1fr))

            .block
                display: flex
                flex-direction: column

                h3
                    margin-block: 0 1rem
                    font-weight: 700
                    color: var(--color-heading)
                    
                    &.primary
                        color: var(--color-primary)

                .navigation
                    display: flex
                    flex-direction: column

                    .link
                        background-image: url('/images/assets/li_dot.svg')
                        background-repeat: no-repeat
                        background-size: .7rem
                        background-position: 0 center
                        padding-left: 1.5rem
                        transition: all 100ms

                        &:hover,
                        &:focus
                            background-position: .3rem center

        .copyright-row
            display: flex

            .row
                border-top: 2px solid rgba(0,0,0,.1)
                flex: 1
                display: flex
                align-items: center
                height: 5rem
                gap: var(--su)

            .copyright
                height: 2rem
                display: flex
                align-items: center
                gap: var(--su)
                line-height: 1

                img
                    height: 2rem
                    width: auto
                    opacity: .6

                span
                    font-weight: 600

            .spacer
                flex: 1

            .social-wrapper
                display: flex
                gap: var(--su)
                flex-wrap: wrap

    @media only screen and (max-width: 1300px)
        footer
            .certificate-row
                margin-inline: var(--su)
                width: calc(100% - var(--su) * 2)

    @media only screen and (max-width: 1000px)
        footer
            .link-row
                grid-template-columns: repeat(2,minmax(200px,1fr))
                gap: calc(var(--su) * 3)

    @media only screen and (max-width: 700px)
        footer
            gap: 0

            .certificate-row
                margin-bottom: 1.5rem

                .wrapper .cert-wrapper
                    height: 3.4rem
                    border-radius: calc(var(--su) * .3)

            .link-row
                grid-template-columns: 1fr
                gap: 0

                .block
                    margin-top: 1.5rem
                    border-top: 2px solid rgba(0,0,0,.1)

                    h3
                        margin-block: 1.5rem 1rem

            .copyright-row
                .row
                    flex-direction: column
                    height: auto
                    gap: 0
                    margin-top: 1.5rem

                    .spacer
                        display: none

                    .social-wrapper
                        width: 100%
                        order: 1
                        justify-content: center
                        border-bottom: 2px solid rgba(0,0,0,.1)
                        padding-block: 1.5rem

                    .copyright
                        order: 2
                        margin-block: 1.5rem
</style>