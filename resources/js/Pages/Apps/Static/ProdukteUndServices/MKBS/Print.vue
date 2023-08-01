<template>
    <TextSubLayout image="/images/content/mkbs/banner/header_print.png" large-hero>
        <Head>
            <title>Print Design – FDBS Marketing</title>
        </Head>

        <h2 class="w-100" style="text-align: center;">Unsere Leistungen im Überblick</h2>

        <div class="keyfacts">
            <div class="placeholder-c2"></div>
            <div class="fact-card">
                <div class="icon font-icon">diamond</div>
                <h3>Logoentwicklung</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">web_stories</div>
                <h3>Flyer/Broschüren</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">store</div>
                <h3>Geschäftsausstattung</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">confirmation_number</div>
                <h3>Etiketten/Banderolen</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">euro</div>
                <h3>Preisauszeichnung</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">description</div>
                <h3>Handzettel</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">photo_frame</div>
                <h3>Plakate</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">sell</div>
                <h3>Thekenaufsteller</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">flag</div>
                <h3>Rollups, Beachflags</h3>
            </div>
        </div>

        <div class="limiter text-limiter">
            <h1>Unsere Leistungen im Print</h1>
            <p>
                Trotz aller Neuerungen, technologischen Entwicklungen und Innovationen im Bereich des Marketings, dürfen das klassische
                Marketing und insbesondere Printartikel nicht aus den Augen verloren werden. Denn nach wie vor erreicht man viele Kunden
                durch Plakate, Broschüren oder mit klassischen Anzeigen. Es ist trotz aller Erreichbarkeit online immer noch hilfreich,
                mit z.B. Handzetteln Kunden auf sich aufmerksam zu machen und in Erinnerung zu bleiben. Voraussetzung dafür ist ein
                attraktives Design, das die Menschen anspricht, die sie erreichen möchten.
            </p>
            <p>
                Bei uns können Sie daher neben der Vielzahl an digitalen Optionen auch die Konzeption, die Gestaltung und den Druck
                solcher Printprodukte in Auftrag geben.
            </p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
    
            <img src="/images/content/mkbs/leistungen/print/products.png" alt="" class="content-image">
            <h2>Produktauswahl</h2>
            <p>
                Von den klassischen Produkten, wie Handzetteln, Plakaten oder Broschüren bis hin zu Etiketten, Fahnen oder Roll-Ups ist
                bei uns grundsätzlich alles möglich. Wir sind für Anfragen offen und finden Lösungen, auch ausgefallenere Ideen
                umzusetzen.
            </p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
    
            <img src="/images/content/mkbs/leistungen/print/concept_and_design.png" alt="" class="content-image">
            <h2>Konzeption und Gestaltung</h2>
            <p>
                Unser Service beginnt dabei mit einem Erstgespräch, der Ideenfindung und der Entwicklung eines ersten Layouts, wobei wir
                auch gleich Umfang und Produktion definieren. Bei Konzept und Layout besteht selbstverständlich auch die Möglichkeit,
                sich an Online-Marketingkampagnen zu orientieren und beides zu kombinieren.
            </p>
            <p>
                Die Konzeption, Gestaltung und Produktion der Printartikel geschieht dabei alles aus einer Hand bei uns im Haus.
                Zusätzlich arbeiten wir mit einem großen Netzwerk an Partnern zusammen, um Ihre Aufträge schnellstmöglich fertigstellen
                zu können.
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

        --color-local-primary: #f7b731
        --color-local-primary-shade: #f7b73130

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