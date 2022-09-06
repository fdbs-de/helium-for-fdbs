<template>
    <GuestLayout>
        <Head>
            <title>Kontakt</title>
        </Head>

        <main>
            <section id="hero-section">
                <h1>Kontakt & Ansprechpartner</h1>
            </section>

            <section id="form-section">
                <div class="limiter wrapper">
                    <div class="card">
                        <h2 class="no-margin">Anfahrt</h2>
                        <span>
                            Christian-Pommer-Straße 31/33<br>
                            38112 Braunschweig<br>
                        </span>
                        <span>
                            Email: <a href="mailto:info@fdbs.de">info@fdbs.de</a><br>
                            Telefon: <a href="tel:0531210550">0531 210 55 0</a><br>
                            Fax: 0531 210 55 39<br>
                        </span>
                    </div>
                    <form class="card" @submit.prevent="submit">
                        <Alert type="info" title="Vielen Dank für Ihre Anfrage!" v-if="$page.props.flash.success">
                            Wir haben Ihre Kontaktanfrage erhalten und werden Ihnen schnellsmöglich antworten.
                        </Alert>

                        <h2 class="no-margin">Kontaktformular</h2>
    
                        <ValidationErrors />
    
                        <mui-input type="text" label="Ihr Name" required autocomplete="name" v-model="form.name"/>
                        <mui-input type="email" label="Ihre Email" required autocomplete="email" v-model="form.email"/>
                        <mui-input type="textarea" class="textarea" label="Nachricht" max="2000" required autocomplete="message" v-model="form.message"/>
    
                        <div class="flex center">
                            <mui-toggle type="checkbox" class="checkbox" v-model="form.terms">
                                <template #label>
                                    <span>
                                        Ich habe die <a target="_blank" :href="route('datenschutz')">Datenschutzerklärung</a> gelesen und akzeptiere diese.
                                    </span>
                                </template>
                            </mui-toggle>
                            <div class="spacer"></div>
                            <mui-button type="submit" label="Absenden" :loading="form.processing"/>
                        </div>
                    </form>
                </div>
            </section>

            <section id="content-section">
                <div class="limiter">
                    <h2>Der Vorstand</h2>

                    <div class="staff-card-container">
                        <div></div>
                        <StaffCard name="Sebastian Gerlach" job="Vorstand" leader label="(geschäftsführend)" image="/images/content/mitarbeiter/sebastian_gerlach.png"/>
                        <!-- <StaffCard name="Sebastian Gerlach" job="Vorstand" leader label="(geschäftsführend)" image="/images/content/mitarbeiter/sebastian_gerlach.png" overlay="/images/content/mitarbeiter/sebastian_gerlach_zeichnung.png"/> -->
                        <StaffCard name="Jens Löser" job="Vorstand" leader label="(geschäftsführend)" image="/images/content/mitarbeiter/jens_loeser.png"/>
                        <!-- <StaffCard name="Jens Löser" job="Vorstand" leader label="(geschäftsführend)" image="/images/content/mitarbeiter/jens_loeser.png" overlay="/images/content/mitarbeiter/jens_loeser_zeichnung.png"/> -->
                        <div></div>
                    </div>

                    <h2>Ansprechpartner</h2>
                    
                    <div class="staff-card-container">
                        <StaffCard name="Jana Schildhauer" job="Assistentin des Vorstands / QM / Ausbildungsleitung" leader tel="44" image="/images/content/mitarbeiter/jana_schildhauer.png" overlay="/images/content/mitarbeiter/jana_schildhauer_zeichnung.png"/>
                        
                        <StaffCard name="Robert Heiduk" job="Leitung Buchhaltung / Personal" leader tel="37" image="/images/content/mitarbeiter/robert_heiduk.png" overlay="/images/content/mitarbeiter/robert_heiduk_zeichnung.png"/>
                        <StaffCard name="Silke Sanner" job="Verwaltung" tel="31" image="/images/content/mitarbeiter/missing.png"/>
                        <StaffCard name="Katja Stöger" job="Debitorenbuchhaltung" tel="15" image="/images/content/mitarbeiter/missing.png"/>
                    
                        <StaffCard name="Meik Binkowski" job="Controlling" leader tel="33" image="/images/content/mitarbeiter/meik_binkowski.png" overlay="/images/content/mitarbeiter/meik_binkowski_zeichnung.png"/>
                    
                        <StaffCard name="Christian Hornig" job="Leitung Einkauf / Warendisposition" leader tel="17" image="/images/content/mitarbeiter/christian_hornig.png" overlay="/images/content/mitarbeiter/christian_hornig_zeichnung.png"/>
                        <StaffCard name="Marius Hilger" job="Einkauf / Warendisposition" tel="46" image="/images/content/mitarbeiter/marius_hilger.png" overlay="/images/content/mitarbeiter/marius_hilger_zeichnung.png"/>
                        <StaffCard name="Maik Kirsch" job="Einkauf / Warendisposition" tel="68" image="/images/content/mitarbeiter/missing.png"/>
                        <StaffCard name="Tobias Klenke" job="Einkauf / Warendisposition" tel="21" image="/images/content/mitarbeiter/tobias_klenke.png" overlay="/images/content/mitarbeiter/tobias_klenke_zeichnung.png"/>
                        <StaffCard name="Peter Schmidt" job="Einkauf / Warendisposition" tel="19" image="/images/content/mitarbeiter/peter_schmidt.png" overlay="/images/content/mitarbeiter/peter_schmidt_zeichnung.png"/>
                        <StaffCard name="Nino Storch" job="Einkauf / Warendisposition" tel="48" image="/images/content/mitarbeiter/nino_storch.png" overlay="/images/content/mitarbeiter/nino_storch_zeichnung.png"/>
                    
                        <StaffCard name="Philipp Rost" job="Leitung Vertrieb" leader tel="99" image="/images/content/mitarbeiter/philipp_rost.png" overlay="/images/content/mitarbeiter/philipp_rost_zeichnung.png"/>
                        <StaffCard name="Niklas Figge" job="Fachberater" tel="80" image="/images/content/mitarbeiter/missing.png"/>
                        <StaffCard name="Elke Grigat" job="Fachberaterin Käse & Salate" tel="38" image="/images/content/mitarbeiter/elke_grigat.png" overlay="/images/content/mitarbeiter/elke_grigat_zeichnung.png"/>
                        <StaffCard name="Klaus-Dieter Hoffmann" job="Fachberater" tel="98" image="/images/content/mitarbeiter/missing.png"/>
                        <StaffCard name="Holger Kleinert" job="Fachberater" tel="14" image="/images/content/mitarbeiter/missing.png"/>
                        <StaffCard name="Marcus König" job="Fachberater" tel="93" image="/images/content/mitarbeiter/marcus_koenig.png" overlay="/images/content/mitarbeiter/marcus_koenig_zeichnung.png"/>
                        <StaffCard name="Lutz Nolte" job="Fachberater" tel="94" image="/images/content/mitarbeiter/lutz_nolte.png" overlay="/images/content/mitarbeiter/lutz_nolte_zeichnung.png"/>
                        <StaffCard name="Kenan Özden" job="Fachberater" tel="92" image="/images/content/mitarbeiter/kenan_oezden.png" overlay="/images/content/mitarbeiter/kenan_oezden_zeichnung.png"/>
                        <StaffCard name="Andreas Pape" job="Fachberater" tel="91" image="/images/content/mitarbeiter/andreas_pape.png" overlay="/images/content/mitarbeiter/andreas_pape_zeichnung.png"/>
                        <StaffCard name="Mathias Vetter" job="Fachberater" tel="95" image="/images/content/mitarbeiter/mathias_vetter.png" overlay="/images/content/mitarbeiter/mathias_vetter_zeichnung.png"/>
                        <StaffCard name="Jens Winkler" job="Fachberater" tel="97" image="/images/content/mitarbeiter/jens_winkler.png" overlay="/images/content/mitarbeiter/jens_winkler_zeichnung.png"/>
                    
                        <StaffCard name="Madlen Krause" job="Leitung Vertriebsinnendienst" leader tel="18" image="/images/content/mitarbeiter/missing.png"/>
                        <StaffCard name="Phil Bartelt" job="Vertriebsinnendienst" tel="36" image="/images/content/mitarbeiter/phil_bartelt.png" overlay="/images/content/mitarbeiter/phil_bartelt_zeichnung.png"/>
                        <StaffCard name="Silke Künstler" job="Vertriebsinnendienst" tel="23" image="/images/content/mitarbeiter/silke_kuenstler.png" overlay="/images/content/mitarbeiter/silke_kuenstler_zeichnung.png"/>
                        <StaffCard name="Romina Pagano" job="Vertriebsinnendienst" image="/images/content/mitarbeiter/missing.png"/>
                        <StaffCard name="Yasmin Ruben" job="Vertriebsinnendienst" tel="32" image="/images/content/mitarbeiter/yasmin_ruben.png" overlay="/images/content/mitarbeiter/yasmin_ruben_zeichnung.png"/>
                        <StaffCard name="Angela Schrödter" job="Vertriebsinnendienst" tel="20" image="/images/content/mitarbeiter/angela_schroedter.png" overlay="/images/content/mitarbeiter/angela_schroedter_zeichnung.png"/>
                    
                        <StaffCard name="Benjamin Vahle" job="Leitung Marketing & Kommunikation" leader tel="16" image="/images/content/mitarbeiter/benjamin_vahle.png" overlay="/images/content/mitarbeiter/benjamin_vahle_zeichnung.png"/>
                        <StaffCard name="Franziska Brandt" job="Printgestaltung & Produktion" tel="51" image="/images/content/mitarbeiter/franziska_brandt.png" overlay="/images/content/mitarbeiter/franziska_brandt_zeichnung.png"/>
                        <StaffCard name="Maurice Freuwört" job="Web Developer" tel="73" image="/images/content/mitarbeiter/maurice_freuwoert.png" overlay="/images/content/mitarbeiter/maurice_freuwoert_zeichnung.png"/>
                        <StaffCard name="Annika Görmann" job="Social Media Marketing" tel="72" image="/images/content/mitarbeiter/annika_goermann.png" overlay="/images/content/mitarbeiter/annika_goermann_zeichnung.png"/>
                        <StaffCard name="Carolin Götzner" job="Printgestaltung & Produktion" tel="43" image="/images/content/mitarbeiter/carolin_goetzner.png" overlay="/images/content/mitarbeiter/carolin_goetzner_zeichnung.png"/>
                        <StaffCard name="Julia Kirschner" job="Printgestaltung & Produktion" tel="13" image="/images/content/mitarbeiter/missing.png"/>
                        <StaffCard name="Sophie Quast" job="Printgestaltung & Produktion" tel="79" image="/images/content/mitarbeiter/missing.png"/>
                        <StaffCard name="Franziska Wolff" job="Printgestaltung & Produktion" image="/images/content/mitarbeiter/franziska_wolff.png" overlay="/images/content/mitarbeiter/franziska_wolff_zeichnung.png"/>
                    
                        <StaffCard name="Philipp Tronnier" job="Leitung Lager" leader tel="57" image="/images/content/mitarbeiter/missing.png"/>
                    
                        <StaffCard name="Timo Welskop" job="Leitung Fuhrpark" leader tel="56" image="/images/content/mitarbeiter/timo_welskop.png" overlay="/images/content/mitarbeiter/timo_welskop_zeichnung.png"/>
                        <StaffCard name="Kathrin Reviliak" job="Stv. Leitung Fuhrpark" leader tel="53" image="/images/content/mitarbeiter/missing.png"/>
                    
                        <StaffCard name="Tobias Behnstedt" job="Leitung Fleischabteilung" leader tel="26" image="/images/content/mitarbeiter/tobias_behnstedt.png" overlay="/images/content/mitarbeiter/tobias_behnstedt_zeichnung.png"/>
                        <StaffCard name="Niels Brandt" job="Leitung Fleischabteilung" leader tel="27" image="/images/content/mitarbeiter/niels_brandt.png" overlay="/images/content/mitarbeiter/niels_brandt_zeichnung.png"/>
                    
                        <StaffCard name="Annette Körner" job="Leitung Servicewerkstatt" leader tel="24" image="/images/content/mitarbeiter/annette_koerner.png" overlay="/images/content/mitarbeiter/annette_koerner_zeichnung.png"/>
                        <StaffCard name="Marcus Zetzsche" job="Stv. Leitung Servicewerkstatt" leader tel="12" image="/images/content/mitarbeiter/marcus_zetzsche.png" overlay="/images/content/mitarbeiter/marcus_zetzsche_zeichnung.png"/>
                        <StaffCard name="Sabine Barnert" job="Vetriebsinnendienst der Werkstatt" tel="76" image="/images/content/mitarbeiter/missing.png"/>
                        <StaffCard name="André Hoffmann" job="Fachberater Großküchentechnik" tel="41" image="/images/content/mitarbeiter/missing.png"/>
                        <StaffCard name="Peter Wiebke" job="Vetriebsinnendienst der Werkstatt" tel="75" image="/images/content/mitarbeiter/missing.png"/>
                    </div>
                </div>
            </section>
        </main>
    </GuestLayout>
</template>

<script setup>
    import { ref } from 'vue'
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
    import GuestLayout from '@/Layouts/Guest.vue'
    import ValidationErrors from '@/Components/ValidationErrors.vue'
    import StaffCard from '@/Components/Page/StaffCard.vue'
    import Alert from '@/Components/Alert.vue'

    const form = useForm({
        email: '',
        name: '',
        message: '',
        terms: false
    })

    const isSent = ref(false)

    const submit = () => {
        form.post(route('kontakt.send'), {
            onSuccess: () => {
                isSent.value = true
                form.reset()
            },
        })
    }
</script>

<style lang="sass" scoped>
    #hero-section
        display: flex
        align-items: center
        justify-content: center
        margin-top: var(--height-header)
        padding-bottom: var(--height-header)
        height: calc(350px + var(--height-header))
        background: var(--color-background-soft)

        h1
            color: var(--color-primary)

    #form-section
        .wrapper
            display: flex
            transform: translateY(calc(-1 * var(--height-header)))
            margin-bottom: var(--height-header)
            gap: 3rem

            .card
                flex: 1
                display: flex
                flex-direction: column
                padding: calc(var(--su) * 2)
                gap: calc(var(--su) * 2)
                background: var(--color-background)
                border-radius: calc(var(--su) * .75)
                box-shadow: var(--shadow-elevation-low)


        form
            --mui-background: var(--color-background-soft)

            .checkbox
                --mui-background: var(--color-background)

            .textarea
                --base-height: 10rem

    #content-section

        h2
            color: var(--color-primary)
            text-align: center
        .staff-card-container
            display: grid !important
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr))
            gap: 3rem
            margin-bottom: 4rem



    @media only screen and (max-width: 500px)
        #hero-section
            height: calc(250px + var(--height-header))

        #form-section
            .wrapper
                flex-direction: column
                margin-bottom: calc(var(--su) * 2)
                padding-inline: var(--su)

                .card
                    padding-inline: var(--su)
</style>