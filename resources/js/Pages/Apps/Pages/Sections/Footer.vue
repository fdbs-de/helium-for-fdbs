<template>
    <footer>
        <div class="limiter certificate-row">
            <h3>Zertifiziert durch</h3>
            <div class="wrapper">
                <a class="cert-wrapper" href="/downloads/zertifikate/CrefoZert_2022_2030012751_Fleischer_Dienst_Braunschweig_eG.pdf" target="_blank" rel="noopener noreferrer">
                    <img src="/images/assets/zertifikate/crefo_logo.jpg" alt="CreFo Zertifizierung">
                </a>
                <a class="cert-wrapper" href="/downloads/zertifikate/qs_zertifikat_2024.pdf" target="_blank" rel="noopener noreferrer">
                    <img src="/images/assets/zertifikate/qs_logo.webp" alt="QS Zertifizierung">
                </a>
                <a class="cert-wrapper" href="/downloads/zertifikate/Zertifikat_Orgainvent.pdf" target="_blank" rel="noopener noreferrer">
                    <img src="/images/assets/zertifikate/orgainvent_logo.webp" alt="Orgainvent Zertifizierung">
                </a>
                <a class="cert-wrapper" href="/downloads/zertifikate/Bio_2023_A4.pdf" target="_blank" rel="noopener noreferrer">
                    <img src="/images/assets/zertifikate/bio_logo.webp" alt="Bio Zertifizierung">
                </a>
                <a class="cert-wrapper" href="/downloads/zertifikate/ifs_2024.pdf" target="_blank" rel="noopener noreferrer">
                    <img src="/images/assets/zertifikate/ifs_wholesale_logo.webp" alt="IFS Wholesale Zertifizierung">
                </a>
                <div class="cert-wrapper">
                    <img src="/images/assets/zertifikate/lucid_regnr_text.webp" alt="LUCID Registrierungsnummer: DE3379292435101">
                </div>
                <a class="cert-wrapper" href="/downloads/zertifikate/Zertifikat_ITW.pdf" target="_blank" rel="noopener noreferrer">
                    <img src="/images/assets/zertifikate/itw_logo.webp" alt="Initiative Tierwohl Zertifizierung">
                </a>
            </div>
        </div>

        <div class="limiter link-row">
            <div class="block">
                <h3 class="headline primary">Abholmarkt</h3>
                <div class="content">
                    <b>Öffnungszeiten:</b><br>
                    Mo - Do: 06:00 - 15:00<br>
                    Fr: 06:00 - 12:00<br>
                    <br>
                    <b>Bestellhotline:</b><br>
                    0531 - 210 55-23<br>
                    (besetzt von 07:00 - 16:00)<br>
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
                    <a class="link" @click.prevent="openCookieDialog()" href="#">Cookie Einstellungen</a>
                </nav>
            </div>
        </div>

        <div class="limiter copyright-row">
            <div class="row">
                <div class="copyright">
                    <img src="/images/branding/logo_sloganless_black.svg" alt="FDBS Logo">
                </div>
                <div class="spacer"></div>
                <div class="social-wrapper">
                    <!-- <a href="https://job38.de/arbeitgeber/fdbs-69115" target="_blank" rel="opener" title="job38">job38</a> -->
                    <a href="https://www.kleinanzeigen.de/pro/FDBS" target="_blank" rel="opener" title="Kleinanzeigen">
                        <img src="/images/assets/social-icons/icon_kleinanzeigen.svg" alt="Kleinanzeigen">
                    </a>
                    <a href="https://www.instagram.com/fdbs_foodservice/" target="_blank" rel="opener" title="Instagram">
                        <img src="/images/assets/social-icons/icon_instagram.svg" alt="Instagram">
                    </a>
                    <a href="https://job38.de/arbeitgeber/fdbs-69115" target="_blank" rel="opener" title="job38">
                        <img src="/images/assets/social-icons/icon_job38.svg" alt="job38">
                    </a>
                    <a href="https://www.xing.com/pages/fleischer-dienst-braunschweig-eg" target="_blank" rel="opener" title="Xing">
                        <img src="/images/assets/social-icons/icon_xing.svg" alt="Xing">
                    </a>
                    <a href="https://g.page/r/CWfKbNs4inYXEAg/review" target="_blank" rel="opener" title="Bewerten Sie uns auf Google">
                        <img src="/images/assets/social-icons/icon_google.svg" alt="Bewerten Sie uns auf Google">
                    </a>
                    <a href="https://www.facebook.com/FleischerDienstBraunschweig" target="_blank" rel="opener" title="Facebook">
                        <img src="/images/assets/social-icons/icon_facebook.svg" alt="Facebook">
                    </a>
                    <a href="https://www.linkedin.com/company/fdbsfoodservice" target="_blank" rel="opener" title="LinkedIn">
                        <img src="/images/assets/social-icons/icon_linkedin.svg" alt="LinkedIn">
                    </a>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
    import { Link } from '@inertiajs/inertia-vue3'
    import { ref, computed } from 'vue'
    import { mainMenu, aboutMenu, legalMenu } from '@/Pages/Apps/Static/menus'

    import Popup from '@/Components/Form/Popup.vue'



    const productsMenu = computed(() => {
        return mainMenu.find(e => e.id === 'produkte-und-services')?.children || []
    })



    const openCookieDialog = () => {
        document.getElementById('cookie-settings-button').click()
    }
</script>

<style lang="sass" scoped>
    footer
        background: var(--color-background-soft)
        color: var(--color-text-soft)
        border-top: 5px solid var(--color-primary)
        display: flex
        flex-direction: column
        gap: 3rem
        padding-top: 3rem

        .certificate-row
            display: flex
            flex-direction: column
            gap: 1.5rem
            border: 1px solid var(--color-background-soft)

            h3
                text-align: center
                margin: 0
                font-weight: 600
                font-family: var(--font-heading)
                color: var(--color-text)
                font-size: 1.5rem

            .wrapper
                display: flex
                flex-wrap: wrap
                align-items: center
                justify-content: space-between
                gap: 1.5rem
                padding-bottom: 3rem
                border-bottom: 2px solid rgba(0,0,0,.1)

                .cert-wrapper
                    height: 6rem
                    border-radius: var(--radius-m)
                    background: var(--color-background)
                    box-shadow: var(--shadow-elevation-low)
                    filter: saturate(0)
                    padding: .5rem

                    img
                        height: 100%
                        width: 100%
                        max-width: 100%
                        object-fit: contain

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
                    font-weight: 600
                    font-size: 1.5rem
                    color: var(--color-text)

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
                        color: var(--color-primary)
                        filter: saturate(0)

                        &:hover,
                        &:focus
                            filter: saturate(1)
                            background-position: .3rem center

        .copyright-row
            display: flex

            .row
                border-top: 2px solid rgba(0,0,0,.1)
                flex: 1
                display: flex
                align-items: center
                height: 5rem
                gap: 1rem

            .copyright
                height: 2rem
                display: flex
                align-items: center
                gap: 1rem
                line-height: 1

                img
                    height: 2rem
                    width: auto
                    opacity: .6

                span
                    font-weight: 400

            .spacer
                flex: 1

            .social-wrapper
                display: flex
                gap: 1rem
                flex-wrap: wrap
                align-items: center

                > a
                    display: flex

                    &:hover
                        img
                            opacity: 1

                    img
                        height: 1.75rem
                        opacity: .8



    @media only screen and (max-width: 1000px)
        footer
            .link-row
                grid-template-columns: repeat(2,minmax(200px,1fr))
                gap: 3rem

    @media only screen and (max-width: 700px)
        footer
            gap: 0

            .certificate-row
                .wrapper
                    border-bottom: none
                    padding-bottom: 0

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