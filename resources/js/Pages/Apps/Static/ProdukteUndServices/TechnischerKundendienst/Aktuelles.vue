<template>
    <TextSubLayout title="Top Aktuelles vom technischen Kundendienst" image="/images/content/banner/service_425530867_425530980_436047070_425530651_425530924_425530335.webp">
        <Head>
            <title>Top Aktuelles vom technischen Kundendienst – FDBS</title>
        </Head>

        <div class="limiter text-limiter">
            <h2>Maximale Flexibilität mit den unterschiedlichen Modellen von MKN</h2>
            <p>
                In dieser Kundenreferenz sind bis zu fünf verschiedene Garverfahren gleichzeitig möglich. Mit den zusätzlichen Gerätefunktionen wie dem Übernachtgaren steht einem gelungenen Partyservice auch bei größeren Veranstaltungen nichts entgegen!
            </p>
            <p>
                Neben den Hightechgeräten wie z. B. dem Flexichef, ergänzt konventionelle Kochtechnik die Gesamtausstattung.
            </p>
            <p>&nbsp;</p>

            <h3>Modernisierungsprämie</h3>
            <p>
                Beim Austausch Ihres alten Kombidämpfers gegen einen neuen Flexi Combi Magic Pilot aus unserem Angebot erhalten Sie einen Sondernachlass:<br>
                06.1 Elektro = 350,00 € netto<br>
                10.1 Elektro = 550,00 € netto<br>
            </p>
            <img src="/images/content/customerservice/mkn_06_2023.png" alt="MKN Maschinen" class="content-image border">
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            
            <h2>Ihre Ansprechpartner</h2>
            <div class="grid">
                <StaffCard
                    class="service-scroll-item"
                    v-for="employee in departments.find(e => e.id === 'service').employees"
                    :key="employee.name"
                    :name="employee.name"
                    :job="employee.job"
                    :leader="employee.leader"
                    :tel="employee.tel"
                    :image="employee.image || '/images/content/mitarbeiter/missing.png'"
                    :overlay="employee.overlay"/>
            </div>
        </div>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import departments from '@/Pages/Apps/Static/Kontakt.json'

    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import StaffCard from '@/Components/Page/StaffCard.vue'
    import DownloadManager from '@/Components/Apps/Pages/Renderer/DownloadManager.vue'
</script>

<style lang="sass" scoped>
    .keyfacts
        display: grid
        grid-template-columns: 1fr 1fr 1fr
        grid-auto-rows: 4rem
        grid-gap: 3rem
        padding-inline: 6rem
        padding-block: 3rem 10rem

        --color-local-primary: #e00047
        --color-local-primary-shade: #e0004730

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

<style lang="sass" scoped>
    .grid
        display: grid
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr))
        gap: 2rem

    .card
        background: var(--color-background)
        border-radius: var(--radius-m)
        box-shadow: var(--shadow-elevation-low)
</style>