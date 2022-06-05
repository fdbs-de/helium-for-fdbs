<template>
    <footer>
        <div class="limiter certificate-row">
            <p>Wir sind zertifiziert durch:</p>
            <div class="divider"></div>
            <div class="wrapper">
                <a class="cert-wrapper" href="/downloads/qs_zertifikat_2022.pdf" target="_blank" rel="noopener noreferrer">
                    <img src="/images/zertifikate/qs_logo.jpg" alt="QS Zertifizierung">
                </a>
                <a class="cert-wrapper" href="/downloads/Bio_2022_A4.pdf" target="_blank" rel="noopener noreferrer">
                    <img src="/images/zertifikate/bio_logo.jpg" alt="Bio Zertifizierung">
                </a>
                <a class="cert-wrapper" href="/downloads/ifs_2022.pdf" target="_blank" rel="noopener noreferrer">
                    <img src="/images/zertifikate/ifs_wholesale_logo.png" alt="IFS Wholesale Zertifizierung">
                </a>
                <a class="cert-wrapper" href="/downloads/Zertifikat_Orgainvent.pdf" target="_blank" rel="noopener noreferrer">
                    <img src="/images/zertifikate/orgainvent_logo.png" alt="Orgainvent Zertifizierung">
                </a>
                <a class="cert-wrapper" href="/downloads/CrefoZert_2020_2030012751_Fleischer_Dienst_Braunschweig_eG.pdf" target="_blank" rel="noopener noreferrer">
                    <img src="/images/zertifikate/crefo_logo.jpg" alt="CreFo Zertifizierung">
                </a>
                <div class="cert-wrapper" href="#" target="_blank" rel="noopener noreferrer">
                    <img src="/images/zertifikate/itw_logo.jpg" alt="Initiative Tierwohl Zertifizierung">
                </div>
            </div>
        </div>

        <div class="limiter link-row">
            <div class="block">
                <h3 class="headline">Abholmarkt</h3>
                <div class="content">

                </div>
            </div>
            <div class="block">
                <h3 class="headline">Produkte & Services</h3>
                <nav class="navigation">
                    <Link class="link">Test</Link>
                </nav>
            </div>
            <div class="block">
                <h3 class="headline">Über Uns</h3>
                <nav class="navigation">
                    <Link class="link">Test</Link>
                </nav>
            </div>
            <div class="block">
                <h3 class="headline">Rechtliches</h3>
                <nav class="navigation">
                    <Link class="link">Test</Link>
                </nav>
            </div>
        </div>

        <div class="limiter copyright-row">
            <div class="copyright">
                <img src="/images/branding/logo_sloganless_black.svg" alt="FDBS Logo">
                <span>© {{new Date().getFullYear()}} FDBS</span>
            </div>
            <div class="spacer"></div>
            <div class="social-wrapper">
                <a href="https://www.facebook.com/fdbs" target="_blank" rel="opener">
                    <img src="/images/assets/facebook.svg" alt="Facebook">
                </a>
            </div>
        </div>
    </footer>
</template>

<script setup>
    import { Link } from '@inertiajs/inertia-vue3'
</script>

<style lang="sass" scoped>
    footer
        background: var(--color-background-soft)
        display: flex
        flex-direction: column
        gap: calc(var(--su) * 4)
        padding-top: calc(var(--su) * 4)

        .certificate-row
            display: flex
            flex-direction: column
            background: var(--color-background)
            box-shadow: var(--shadow-elevation-low)
            border-radius: calc(var(--su) * .5)
            padding: var(--su)

            p
                margin: 0

            .divider
                background: rgba(0,0,0,.1)
                height: 2px
                width: 100%

            .wrapper
                display: flex
                flex-wrap: wrap
                align-items: center
                gap: var(--su)
                margin-top: var(--su)

                .cert-wrapper
                    height: 5rem
                    border-radius: calc(var(--su) * .5)

                    img
                        height: 100%
                        width: auto
                        max-width: 100%
                        object-fit: cover
                        border-radius: inherit

        .link-row
            display: flex

            .block
                flex: 1
                display: flex
                flex-direction: column

        .copyright-row
            height: 4rem
            display: flex
            align-items: center
            gap: var(--su)

            .copyright
                height: 2rem
                display: flex
                align-items: center
                gap: var(--su)

                img
                    height: 2rem
                    width: auto
                    opacity: .5

                span
                    font-weight: 600
                    color: rgba(57,63,63,0.6)

            .spacer
                flex: 1

            .social-wrapper
                display: flex
                gap: var(--su)

    @media only screen and (max-width: 1300px)
        footer
            .certificate-row
                border-radius: 0
</style>