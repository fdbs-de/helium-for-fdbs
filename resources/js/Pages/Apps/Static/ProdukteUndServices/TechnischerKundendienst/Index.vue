<template>
    <TextSubLayout title="Technischer Kundendienst" image="/images/content/banner/service_425530867_425530980_436047070_425530651_425530924_425530335.webp">
        <Head>
            <title>Produkte & Services: Technischer Kundendienst – FDBS</title>
        </Head>

        <h2 class="w-100" style="text-align: center;">Unsere Leistungen im Überblick</h2>

        <div class="keyfacts">
            <div class="placeholder-c2"></div>
            <div class="fact-card">
                <div class="icon font-icon">support_agent</div>
                <h3>Service</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">science</div>
                <h3>Chemie</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">sell</div>
                <h3>Verkauf & Planung</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">local_drink</div>
                <h3>Wasseraufbereitung</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">blender</div>
                <h3>Maschinen</h3>
            </div>
        </div>

        <div class="limiter text-limiter">
            <img src="/images/content/customerservice/service_393833200.png" alt="Service" class="content-image">
            <h2>Service</h2>
            <p>
                <ul>
                    <li>
                        <b>Reparatur und Wartung</b> von Fleischereimaschinen,
                        Gewerbespülmaschinen, Kombidämpfer, Herden,
                        Kippbratpfannen und weitere thermische Geräte,
                        Vakuumgeräte
                    </li>
                    <li><b>Geräteprüfung nach DGUV V3</b></li>
                    <li>
                        <b>Schleifarbeiten:</b> Kuttermesser, Wolfscheiben,
                        Aufschnittmaschinenmesser, Hand-Messer, usw
                    </li>
                    <li><b>Begradigungen</b> von Hackblock und Schneidbrett</li>
                    <li><b>Schweißarbeiten</b></li>
                    <li><b>Kältedichtungen,</b> auch im Sondermaß</li>
                    <li><b>Herstellerunabhängig!</b></li>
                </ul>
            </p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>

            <img src="/images/content/customerservice/chemie_408353537.png" alt="Chemie" class="content-image">
            <h2>Chemie</h2>
            <p>
                <ul>
                    <li>
                        <b>Reinigung</b> ihrer Kombidämpfer;
                        automatisch oder manuell
                    </li>
                    <li>
                        <b>Reinigerchemie</b> für ihre Spülmaschine: Immer die
                        richtige Chemie für ihr perfektes Spülergebnis;
                        egal ob Porzellan, Kunststoff, Besteck oder Gläser
                    </li>
                    <li>
                        <b>Wir beraten Sie</b> vor Ort und stellen bei Bedarf
                        ihre Geräte auf die benötigten Reiniger ein
                    </li>
                    <li>
                        <b>Hygienisches Spülergebnis</b> und <b>Kostenersparnis</b>
                        durch die richtige Dosierung
                    </li>
                </ul>
            </p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            
            <img src="/images/content/customerservice/verkauf_253708394.png" alt="Verkauf & Planung" class="content-image">
            <h2>Verkauf & Planung</h2>
            <p>
                <ul>
                    <li>
                        Verkauf von Fleischerei- und Großküchenbedarf – vom Schneidebrett bis zum maßgeplanten Küchenblock
                    </li>
                    <li>Küchenplanung für Gewerbeküchen</li>
                    <li>
                        Edelstahlarbeiten nach Aufmaß vor Ort für:<br>
                        Regale<br>
                        Tische<br>
                        Schränke<br>
                        Abzugshauben<br>
                        Eckschutzschienen<br>
                        usw.
                    </li>
                    <li>Kühlraum- und Betriebsraumtüren mit Aufmaß vor Ort</li>
                </ul>
            </p>
            <p>
                Sie haben ein besonderes Anliegen?<br>
                Sprechen Sie uns an!
            </p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>

            <img src="/images/content/customerservice/wasseraufbereitung_604959639.png" alt="Wasseraufbereitung" class="content-image">
            <h2>Wasseraufbereitung</h2>
            <p>
                <ul>
                    <li>
                        <b>Perfektes Wasser</b> für jede Gelegenheit!
                        Egal ob Kaffee, Kochen oder Spülen, wir ermitteln
                        ihren Bedarf und finden für sie die richtige
                        Wasseraufbereitung
                    </li>
                    <li><b>Prüfen</b> ihrer Wasserqualität</li>
                </ul>
            </p>
            <p>&nbsp;</p>

            <h2>Hightech-Highlights</h2>
            <p>Entdecken Sie regelmäßig ausgewählte Maschinen zu unschlagbaren Sonderpreisen für Ihre Großküche.</p>
            <div class="card margin-top-2">
                <img src="/images/content/customerservice/hobart.png" alt="Hightech-Highlights" class="content-image">
                <span class="flex h-center text-center">– Preise auf Anfrage –</span>
                <DownloadManager id="11195" class="border-top"/>
            </div>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
        </div>

        <!-- <div class="limiter">
            <h2 class="text-align-center">Unser Team</h2>
            <div class="grid">
                <StaffCard
                    v-for="employee in departments.find(e => e.id === 'service').employees"
                    :key="employee.name"
                    :name="employee.name"
                    :job="employee.job"
                    :leader="employee.leader"
                    :tel="employee.tel"
                    :image="employee.image || '/images/content/mitarbeiter/missing.png'"
                    :overlay="employee.overlay"/>
            </div>
        </div> -->
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