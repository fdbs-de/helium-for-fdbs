<template>
    <TextSubLayout image="/images/content/mkbs/banner/header_some.png" large-hero>
        <Head>
            <title>Social Media Marketing – FDBS Marketing</title>
        </Head>

        <h2 class="w-100" style="text-align: center;">Unsere Leistungen im Überblick</h2>

        <div class="keyfacts">
            <div class="placeholder-c2"></div>
            <div class="fact-card">
                <div class="icon font-icon">design_services</div>
                <h3>Grundgestaltung oder Überarbeitung der Kanäle</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">insights</div>
                <h3>Ziel- und Zielgruppendefinition</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">build</div>
                <h3>Einrichtung von Accounts</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">edit_note</div>
                <h3>Planung, Erstellung und Verwaltung</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">query_stats</div>
                <h3>Performanceanalyse</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">gavel</div>
                <h3>DSGVO Prüfung und Absicherung</h3>
            </div>
        </div>

        <div class="limiter text-limiter">
            <h1>Unsere Leistungen im Social Media Marketing</h1>
            <p>
                Die sozialen Medien sind für viele Unternehmen noch immer Neuland. Sie sind aber auch ein Ort voller Möglichkeiten.
                Besonders junge Menschen lassen sich über Social-Media deutlich besser erreichen als auf herkömmlichem Wege. Und nicht
                nur das: Es gibt Ihnen als Unternehmen die Möglichkeit, sich neuen Kunden auf Augenhöhe vorzustellen und so Sympathien
                zu wecken. Neuigkeiten, wie Änderungen Ihres Sortiments lassen sich durch Posts viel schneller kommunizieren. Ihre
                Kunden, genauso wie zukünftige Angestellte, können auf Plattformen wie Instagram oder LinkedIn außerdem mit sehr
                geringem Aufwand direkt mit Ihnen in Kontakt treten.
            </p>
            
            <p>
                Dazu kommt, dass in den sozialen Medien Nutzer viel gezielter auf Ihr Unternehmen aufmerksam gemacht werden können.
                Beiträge lassen sich hier ganz einfach an eine spezifische, relevante Zielgruppe richten.
            </p>
    
            <br>
    
            <h2>Inhalte und Pflege</h2>
            <img src="/images/content/mkbs/leistungen/social_media_marketing/content.png" alt="" class="content-image">
            <p>
                Aber die Erstellung und Pflege solcher Social-Media-Accounts bedarf natürlich Zeit. Deshalb möchten wir Ihnen den
                Einstieg in die Welt der sozialen Medien erleichtern. Unser engagiertes Team übernimmt die Konzeption, Erstellung und
                Pflege der Social-Media-Präsenz Ihres Unternehmens, ganz nach Ihren Vorgaben und Ideen. Diese können wir dann Dank
                unserer Erfahrung und mit Blick auf die neuesten Entwicklungen und Trends in die Tat umsetzen. Auf den Plattformen
                Facebook, Instagram, LinkedIn, Xing und Google MyBusiness können wir für Sie Konten und anschließend auch Beiträge gemäß
                Ihrer Vorstellung erstellen, sowie mit der darauf ansprechenden Community interagieren.
            </p>
    
            <br>
    
            <h2>Datenschutz</h2>
            <img src="/images/content/mkbs/leistungen/social_media_marketing/privacy.png" alt="" class="content-image">
            <p>
                Insbesondere beim Thema Datenschutz bieten wir Ihnen zudem ein Zusatzpaket an, welches Ihre Seite entsprechend der DSGVO
                absichert. Hierbei besteht für die Rechtstexte eine anwaltliche Haftung, sodass Sie sich an dieser Stelle ebenfalls
                keine Sorgen machen müssen.
            </p>
    
            <br>
    
            <h2>Werbeanzeigen</h2>
            <img src="/images/content/mkbs/leistungen/social_media_marketing/ads.png" alt="" class="content-image">
            <p>
                Um über den so entstehenden Content und das generierte Image hinaus weitere Nutzer anzusprechen, gibt es weitere
                Möglichkeiten: Anzeigen auf den jeweiligen Plattformen, gerne auch in Kombination mit dem von uns angebotenen Offline
                Marketing. Anzeigen sind selbstverständlich auch unabhängig von der Erstellung eigener Konten möglich.
            </p>
        </div>

    </TextSubLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3'
import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
</script>

<style lang="sass" scoped>
    .keyfacts
        display: grid
        grid-template-columns: 1fr 1fr 1fr
        grid-auto-rows: 5rem
        grid-gap: 3rem
        padding-inline: 6rem
        padding-block: 3rem 10rem

        --color-local-primary: #4b7bec
        --color-local-primary-shade: #4b7bec30

    .placeholder-c2
        grid-column: 2
        grid-row: 1

    .fact-card
        background: var(--color-background)
        border-radius: var(--radius-l)
        padding: 1.5rem
        display: flex
        flex-direction: column
        align-items: center
        justify-content: center
        grid-row: span 2
        gap: 1.5rem
        border: 1px solid var(--color-background-soft)
        box-shadow: var(--shadow-elevation-low)
        transition: all 0.2s ease-in-out

        &:hover
            box-shadow: var(--shadow-elevation-medium)

        .icon
            font-size: 4rem
            line-height: 1
            color: var(--color-local-primary)
            filter: drop-shadow(0.07em 0.07em 0px var(--color-local-primary-shade))

        h3
            font-size: 1.3rem
            margin: 0
            text-align: center

    @media only screen and (max-width: 1100px)
        .keyfacts
            padding-inline: 0rem

    @media only screen and (max-width: 900px)
        .keyfacts
            grid-template-columns: 1fr 1fr

    @media only screen and (max-width: 600px)
        .keyfacts
            grid-template-columns: 1fr !important
            grid-auto-rows: auto
            gap: 2rem
            padding-bottom: 4rem

            .fact-card
                grid-row: auto

                .icon
                    font-size: 3rem

                h3
                    font-size: 1.1rem

            .placeholder-c2
                display: none
</style>