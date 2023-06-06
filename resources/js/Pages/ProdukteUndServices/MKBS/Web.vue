<template>
    <TextSubLayout image="/images/content/mkbs/banner/header_webentwicklung.png" large-hero>
        <Head>
            <title>Web Entwicklung – FDBS Marketing</title>
        </Head>

        <div class="limiter text-limiter">
            <h2>Unsere Leistungen im Überblick</h2>
        </div>

        <div class="keyfacts">
            <!--
                Von der Idee bis zur Programmierung
                Konzeption und Gestaltung
                Zielgruppenanalyse
                Pflege, Service und Wartung der Seiten
                (auch als monatliche Servicepakete buchbar)
                E-Commerce / Online Shops
                Content Marketing
                SEO - Suchmaschinenoptimierung
                SEA - Suchmaschinenwerbung
                DSGVO Prüfung und Absicherung
            -->
            <div class="fact-card">
                <div class="icon font-icon">data_object</div>
                <h3>Von der Idee bis zur Programmierung</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">design_services</div>
                <h3>Konzeption und Gestaltung</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">insights</div>
                <h3>Zielgruppenanalyse</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">build</div>
                <h3>Pflege, Service und Wartung</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">shopping_cart</div>
                <h3>E-Commerce / Online Shops</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">edit_note</div>
                <h3>Content Marketing</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">query_stats</div>
                <h3>SEO - Suchmaschinenoptimierung</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">verified</div>
                <h3>SEA - Suchmaschinenwerbung</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">gavel</div>
                <h3>DSGVO Prüfung und Absicherung</h3>
            </div>
        </div>

        <div class="limiter text-limiter">
            <h1>Unsere Leistungen in der Webentwicklung</h1>
            <p>
                Heutzutage ist eine Webpräsenz nicht nur ein wichtiger Unternehmensbestandteil, sie ist das Aushängeschild eines
                Unternehmens, das, was Kunden als Erstes auffällt. Um sich bereits hier von Ihrer Konkurrenz abheben zu können, bieten
                wir Ihnen die Konzeption ansprechender Webseiten maßgeschneidert auf Ihre Kunden, ebenso wie die Entwicklung dazu
                passender Online-Shops. Und nicht nur bei der Neugestaltung Ihrer Internetpräsenz kann Sie unser professionelles Team
                unterstützen, sondern auch die Webseiten-Pflege können wir für Sie übernehmen. Unsere jahrelange Erfahrung in den
                Bereichen des Gestaltens, Programmierens und Optimierens macht uns zu Ihrem idealen Ansprechpartner, um Ihr Unternehmen
                online nach vorne zu bringen.
            </p>
    
            <br>
    
            <h2>Konzeption</h2>
            <img src="/images/content/mkbs/leistungen/web/wireframe.png" alt="" class="content-image">
            <p>
                Sie planen eine Webseite oder einen Online-Shop für Ihr Unternehmen, wissen aber nicht, wo Sie anfangen sollen? Dann
                sind Sie bei uns genau richtig. Sagen Sie uns einfach, worauf Sie Wert legen. So können wir nach Ihren Ideen und mit
                unserer Expertise gemeinsam ein individuelles Konzept entwickeln, das passgenau auf Ihre Zielgruppe abgestimmt sind.
            </p>
    
            <br>
    
            <h2>Gestaltung</h2>
            <img src="/images/content/mkbs/leistungen/web/design.png" alt="" class="content-image">
            <p>
                Ein ansprechendes Design ist bei Ihrer Online-Präsenz natürlich ein Muss. Von der Fleischerei über die Gastronomie
                bis zur Kanzlei: Als erfahrene Mediengestalter wissen wir, wie wir auch für Ihr Unternehmen eine Webseite oder einen
                Online-Shop erstellen, der Ihre Kunden optimal an Ihre Produkte heranführt und durch einen attraktiven Aufbau glänzt.
            </p>
    
            <br>
    
            <h2>Entwicklung</h2>
            <img src="/images/content/mkbs/leistungen/web/development.png" alt="" class="content-image">
            <p>
                Wir begleiten Sie von dem ersten Prototypen bis zur Entwicklung komplexer Web-Apps und verstehen uns darauf, auch
                kreative und innovative Ideen wie Animationen, visuelle Gags und umfassende Shopsysteme in die Tat umzusetzen. Außerdem
                stellen wir sicher, dass sich Ihre Kunden auf jedem Endgerät bei Ihnen zurechtfinden und alles reibungslos läuft.
            </p>
    
            <br>
    
            <h2>Optimierung</h2>
            <img src="/images/content/mkbs/leistungen/web/optimization.png" alt="" class="content-image">
            <p>
                Durch langfristige und seriöse Suchmaschinenoptimierung und Suchmaschinenmarketing sorgen wir anschließend zudem
                dafür, dass Ihre Webseite in Zukunft auch von Ihrer Zielgruppe gefunden wird, indem sie an erster Stelle der
                Suchmaschinen auftaucht. So finden Sie Kunden, die genau das brauchen, was Sie anbieten.
            </p>
    
            <br>
    
            <h2>Support</h2>
            <img src="/images/content/mkbs/leistungen/web/support.png" alt="" class="content-image">
            <p>
                Auch nach Fertigstellung Ihrer Internetpräsenz unterstützen wir Sie weiter bei der Pflege und Aktualisierung Ihrer
                Webseite. Durch regelmäßige Updates und Backups halten wir Ihre Webseite auf dem neuesten Stand von Technik und
                Sicherheit und bieten zudem Tech Support, ebenso wie die Aktualisierung von Inhalten. Und auch um den Schutz der Daten
                Ihrer Kunden brauchen Sie sich keine Sorgen zu machen, denn bei uns bekommen Sie darüber hinaus Datenschutzpakete mit
                anwaltlicher Haftung.
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
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr))
        grid-auto-rows: 3rem
        grid-gap: 3rem
        padding-inline: 6rem
        padding-block: 3rem 10rem

    .fact-card
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-medium)
        border-radius: var(--radius-l)
        padding: 1.5rem
        display: flex
        flex-direction: column
        align-items: center
        justify-content: center
        grid-row: span 3
        gap: 1.5rem
        border: 1px solid var(--color-background-soft)

        .icon
            font-size: 4rem
            line-height: 1
            color: var(--color-primary)
            filter: drop-shadow(0.07em 0.07em 0px #e0004730)

        h3
            font-size: 1.3rem
            margin: 0
            text-align: center
</style>