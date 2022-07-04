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
    
                        <mui-input type="text" no-border label="Ihr Name" required autocomplete="name" v-model="form.name"/>
                        <mui-input type="email" no-border label="Ihre Email" required autocomplete="email" v-model="form.email"/>
                        <mui-input type="textarea" class="textarea" no-border label="Nachricht" max="2000" required autocomplete="message" v-model="form.message"/>
    
                        <div class="flex center">
                            <mui-toggle type="checkbox" class="checkbox" no-border v-model="form.terms">
                                <template #appendLabel>
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
                        <!-- <StaffCard name="Zentrale" link="tel:0531 210 55 0" label="0531 210 55 0" image="/images/content/mitarbeiter/missing.png" alt="Zentrale"/> -->
                        <StaffCard name="Sebastian Gerlach" job="Vorstand" label="(geschäftsführend)" image="/images/content/mitarbeiter/sebastian_gerlach.png" alt="Portrait von "/>
                        <StaffCard name="Jens Löser" job="Vorstand" label="(geschäftsführend)" image="/images/content/mitarbeiter/jens_loeser.png" alt="Portrait von "/>
                        <!-- <StaffCard name="Jens Neubauer" job="Vorstand" label="(ehrenamtlich)" image="/images/content/mitarbeiter/missing.png" alt="Portrait von "/> -->
                        <div></div>
                    </div>

                    <h2>Ansprechpartner</h2>
                    
                    <div class="staff-card-container">
                        <StaffCard name="Jana Schildhauer" job="Assistentin des Vorstands / Qualitätsmanagerin" link="tel:0531 210 55 44" label="0531 210 55 44" image="/images/content/mitarbeiter/jana_schildhauer.png" alt="Portrait von "/>
                        
                        <StaffCard name="Robert Heiduk" job="Leitung Buchhaltung / Personal" link="tel:0531 210 55 37" label="0531 210 55 37" image="/images/content/mitarbeiter/robert_heiduk.png" alt="Portrait von "/>
                    
                        <StaffCard name="Katja Stöger" job="Debitorenbuchhaltung" color="#2f3542" link="tel:0531 210 55 15" label="0531 210 55 15" image="/images/content/mitarbeiter/missing.png" alt="Portrait von "/>
                    
                        <!-- <StaffCard name="Silke Sanner" job="Verwaltung" color="#2f3542" link="tel:0531 210 55 31" label="0531 210 55 31" image="/images/content/mitarbeiter/silke_sanner.png" alt="Portrait von "/> -->
                        <StaffCard name="Silke Sanner" job="Verwaltung" color="#2f3542" link="tel:0531 210 55 31" label="0531 210 55 31" image="/images/content/mitarbeiter/missing.png" alt="Portrait von "/>
                    
                        <StaffCard name="Meik Binkowski" job="Controlling" color="#2f3542" link="tel:0531 210 55 33" label="0531 210 55 33" image="/images/content/mitarbeiter/meik_binkowski.png" alt="Portrait von "/>
                    
                        <StaffCard name="Christian Hornig" job="Leitung Einkauf" link="tel:0531 210 55 17" label="0531 210 55 17" image="/images/content/mitarbeiter/christian_hornig.png" alt="Portrait von "/>
                    
                        <StaffCard name="Peter Schmidt" job="Disposition" color="#2f3542" link="tel:0531 210 55 19" label="0531 210 55 19" image="/images/content/mitarbeiter/peter_schmidt.png" alt="Portrait von "/>
                        <StaffCard name="Tobias Klenke" job="Disposition" color="#2f3542" link="tel:0531 210 55 21" label="0531 210 55 21" image="/images/content/mitarbeiter/tobias_klenke.png" alt="Portrait von "/>
                        <StaffCard name="Nino Storch" job="Disposition" color="#2f3542" link="tel:0531 210 55 48" label="0531 210 55 48" image="/images/content/mitarbeiter/nino_storch.png" alt="Portrait von "/>
                        <StaffCard name="Marius Hilger" job="Disposition" color="#2f3542" link="tel:0531 210 55 46" label="0531 210 55 46" image="/images/content/mitarbeiter/marius_hilger.png" alt="Portrait von "/>
                    
                        <StaffCard name="Philipp Rost" job="Leitung Vertrieb" link="tel:0531 210 55 99" label="0531 210 55 99" image="/images/content/mitarbeiter/philipp_rost.png" alt="Portrait von "/>
                    
                        <StaffCard name="Madlen Krause" job="Leitung Vertriebsinnendienst" link="tel:0531 210 55 18" label="0531 210 55 18" image="/images/content/mitarbeiter/missing.png" alt="Portrait von "/>
                    
                        <StaffCard name="Andreas Pape" job="Fachberater" color="#2f3542" link="tel:0531 210 55 91" label="0531 210 55 91" image="/images/content/mitarbeiter/andreas_pape.png" alt="Portrait von "/>
                        <StaffCard name="Marcus König" job="Fachberater" color="#2f3542" link="tel:0531 210 55 93" label="0531 210 55 93" image="/images/content/mitarbeiter/marcus_koenig.png" alt="Portrait von "/>
                        <StaffCard name="Lutz Nolte" job="Fachberater" color="#2f3542" link="tel:0531 210 55 04" label="0531 210 55 94" image="/images/content/mitarbeiter/lutz_nolte.png" alt="Portrait von "/>
                        <StaffCard name="Kenan Özden" job="Fachberater" color="#2f3542" link="tel:0531 210 55 92" label="0531 210 55 92" image="/images/content/mitarbeiter/kenan_oezden.png" alt="Portrait von "/>
                        <StaffCard name="Mathias Vetter" job="Fachberater" color="#2f3542" link="tel:0531 210 55 95" label="0531 210 55 95" image="/images/content/mitarbeiter/mathias_vetter.png" alt="Portrait von "/>
                        <StaffCard name="Jens Winkler" job="Fachberater" color="#2f3542" link="tel:0531 210 55 97" label="0531 210 55 97" image="/images/content/mitarbeiter/jens_winkler.png" alt="Portrait von "/>
                        <StaffCard name="Klaus-Dieter Hoffmann" job="Fachberater" color="#2f3542" link="tel:0531 210 55 08" label="0531 210 55 98" image="/images/content/mitarbeiter/missing.png" alt="Portrait von "/>
                        <StaffCard name="Elke Grigat" job="Fachberaterin" color="#2f3542" link="tel:0531 210 55 38" label="0531 210 55 38" image="/images/content/mitarbeiter/elke_grigat.png" alt="Portrait von "/>
                    
                        <StaffCard name="Silke Künstler" job="Vertriebsinnendienst" color="#2f3542" link="tel:0531 210 55 23" label="0531 210 55 23" image="/images/content/mitarbeiter/silke_kuenstler.png" alt="Portrait von "/>
                        <StaffCard name="Romina Pagano" job="Vertriebsinnendienst" color="#2f3542" link="tel:0531 210 55 28" label="0531 210 55 28" image="/images/content/mitarbeiter/missing.png" alt="Portrait von "/>
                        <StaffCard name="Yasmin Ruben" job="Vertriebsinnendienst" color="#2f3542" link="tel:0531 210 55 32" label="0531 210 55 32" image="/images/content/mitarbeiter/yasmin_ruben.png" alt="Portrait von "/>
                        <StaffCard name="Phil Bartelt" job="Vertriebsinnendienst" color="#2f3542" link="tel:0531 210 55 36" label="0531 210 55 36" image="/images/content/mitarbeiter/phil_bartelt.png" alt="Portrait von "/>
                    
                        <StaffCard name="Benjamin Vahle" job="Leitung Marketing & Kommunikation" link="tel:0531 210 55 16" label="0531 210 55 16" image="/images/content/mitarbeiter/benjamin_vahle.png" alt="Portrait von "/>
                    
                        <StaffCard name="Franziska Brandt" job="Mediengestalterin" color="#2f3542" link="tel:0531 210 55 51" label="0531 210 55 51" image="/images/content/mitarbeiter/franziska_brandt.png" alt="Portrait von "/>
                        <StaffCard name="Maurice Freuwört" job="Mediengestalter" color="#2f3542" link="tel:0531 210 55 73" label="0531 210 55 73" image="/images/content/mitarbeiter/maurice_freuwoert.png" alt="Portrait von "/>
                        <StaffCard name="Julia Kirschner" job="Mediengestalterin" color="#2f3542" link="tel:0531 210 55 13" label="0531 210 55 13" image="/images/content/mitarbeiter/missing.png" alt="Portrait von "/>
                        <StaffCard name="Franziska Wolff" job="Mediengestalterin" color="#2f3542" link="tel:0531 210 55 25" label="0531 210 55 25" image="/images/content/mitarbeiter/franziska_wolff.png" alt="Portrait von "/>
                        <StaffCard name="Carolin Götzner" job="Mediengestalterin" color="#2f3542" link="tel:0531 210 55 43" label="0531 210 55 43" image="/images/content/mitarbeiter/carolin_goetzner.png" alt="Portrait von "/>
                        <StaffCard name="Annika Görmann" job="Mediengestalterin" color="#2f3542" link="tel:0531 210 55 72" label="0531 210 55 72" image="/images/content/mitarbeiter/annika_goermann.png" alt="Portrait von "/>
                    
                        <StaffCard name="Harald Reckwald" job="Leitung Lager" link="tel:0531 210 55 57" label="0531 210 55 57" image="/images/content/mitarbeiter/missing.png" alt="Portrait von "/>
                    
                        <StaffCard name="Timo Welskop" job="Leitung Fuhrpark" link="tel:0531 210 55 56" label="0531 210 55 56" image="/images/content/mitarbeiter/timo_welskop.png" alt="Portrait von "/>
                        <StaffCard name="Kathrin Reviliak" job="Stlv. Leitung Fuhrpark" link="tel:0531 210 55 56" label="0531 210 55 56" image="/images/content/mitarbeiter/missing.png" alt="Portrait von "/>
                    
                        <StaffCard name="Tobias Behnstedt" job="Leitung Fleischabteilung" link="tel:0531 210 55 26" label="0531 210 55 26" image="/images/content/mitarbeiter/tobias_behnstedt.png" alt="Portrait von "/>
                        <StaffCard name="Niels Brandt" job="Leitung Fleischabteilung" link="tel:0531 210 55 27" label="0531 210 55 27" image="/images/content/mitarbeiter/niels_brandt.png" alt="Portrait von "/>
                    
                        <StaffCard name="Annette Körner" job="Leitung Werkstatt/Kundendienst" link="tel:0531 210 55 24" label="0531 210 55 24" image="/images/content/mitarbeiter/annette_koerner.png" alt="Portrait von "/>
                        <StaffCard name="Marcus Zetzsche" job="Leitung Werkstatt/Kundendienst" link="tel:0531 210 55 12" label="0531 210 55 12" image="/images/content/mitarbeiter/marcus_zetzsche.png" alt="Portrait von "/>
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