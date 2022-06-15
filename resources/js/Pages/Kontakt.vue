<template>
    <GuestLayout>
        <Head>
            <title>Kontakt</title>
        </Head>

        <main>
            <section id="hero-section">
                <h1>Kontakt</h1>
            </section>

            <section id="form-section">
                <div class="limiter wrapper">
                    <div class="card">
                        <h2 class="no-margin">Anfart</h2>
                    </div>
                    <form class="card" @submit.prevent>
                        <h2 class="no-margin">Kontaktformular</h2>
    
                        <ValidationErrors />
    
                        <mui-input type="text" no-border label="Ihr Name" required autocomplete="name"/>
                        <mui-input type="email" no-border label="Ihre Email" required autocomplete="email"/>
                        <mui-input type="textarea" class="textarea" no-border label="Nachricht" required autocomplete="message"/>
    
                        <div class="flex center">
                            <mui-toggle type="checkbox" class="checkbox" no-border>
                                <template #appendLabel>
                                    <span>
                                        Ich habe die <a target="_blank" :href="route('datenschutz')">Datenschutzerklärung</a> gelesen und akzeptiere diese.
                                    </span>
                                </template>
                            </mui-toggle>
                            <div class="spacer"></div>
                            <mui-button type="submit" label="Absenden" :loading="false"/>
                        </div>
                    </form>
                </div>
            </section>

            <section id="content-section">
                <div class="limiter">
                    <h2>Der Vorstand</h2>

                    <div class="staff-card-container">
                        <StaffCard name="Zentrale" link="tel:0531 210 55 0" label="0531 210 55 0" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                        <StaffCard name="Sebastian Gerlach" job="Vorstand" label="(geschäftsführend)" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                        <StaffCard name="Jens Löser" job="Vorstand" label="(geschäftsführend)" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                        <StaffCard name="Jens Neubauer" job="Vorstand" label="(ehrenamtlich)" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                    </div>

                    <h2>Ansprechpartner</h2>
                    
                    <div class="staff-card-container">
                        <StaffCard name="Jana Schildhauer" job="Assistentin des Vorstands / Qualitätsmanagerin" color="#2f3542" link="tel:0531 210 55 44" label="0531 210 55 44" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                        
                        <StaffCard name="Robert Heiduk" job="Leitung Buchhaltung / Personal" color="#2f3542" link="tel:0531 210 55 37" label="0531 210 55 37" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                    
                        <StaffCard name="Katja Stöger" job="Debitorenbuchhaltung" color="#2f3542" link="tel:0531 210 55 15" label="0531 210 55 15" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                    
                        <StaffCard name="Silke Sanner" job="Verwaltung" color="#2f3542" link="tel:0531 210 55 31" label="0531 210 55 31" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                    
                        <StaffCard name="Meik Binkowski" job="Controlling" color="#2f3542" link="tel:0531 210 55 33" label="0531 210 55 33" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                    
                        <StaffCard name="Christian Hornig" job="Leitung Einkauf" link="tel:0531 210 55 17" label="0531 210 55 17" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                    
                        <StaffCard name="Peter Schmidt" job="Disposition" color="#2f3542" link="tel:0531 210 55 19" label="0531 210 55 19" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                        <StaffCard name="Tobias Klenke" job="Disposition" color="#2f3542" link="tel:0531 210 55 21" label="0531 210 55 21" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                        <StaffCard name="Nino Storch" job="Disposition" color="#2f3542" link="tel:0531 210 55 48" label="0531 210 55 48" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                        <StaffCard name="Marius Hilger" job="Disposition" color="#2f3542" link="tel:0531 210 55 46" label="0531 210 55 46" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                    
                        <StaffCard name="Philipp Rost" job="Leitung Vertrieb" link="tel:0531 210 55 99" label="0531 210 55 99" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                    
                        <StaffCard name="Madlen Krause" job="Leitung Vertriebsinnendienst" link="tel:0531 210 55 18" label="0531 210 55 18" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                    
                        <StaffCard name="Andreas Pape" job="Fachberater/-innen" color="#2f3542" link="tel:0531 210 55 91" label="0531 210 55 91" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                        <StaffCard name="Marcus König" job="Fachberater/-innen" color="#2f3542" link="tel:0531 210 55 93" label="0531 210 55 93" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                        <StaffCard name="Lutz Nolte" job="Fachberater/-innen" color="#2f3542" link="tel:0531 210 55 04" label="0531 210 55 94" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                        <StaffCard name="Kenan Özden" job="Fachberater/-innen" color="#2f3542" link="tel:0531 210 55 92" label="0531 210 55 92" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                        <StaffCard name="Matthias Vetter" job="Fachberater/-innen" color="#2f3542" link="tel:0531 210 55 95" label="0531 210 55 95" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                        <StaffCard name="Jens Winkler" job="Fachberater/-innen" color="#2f3542" link="tel:0531 210 55 97" label="0531 210 55 97" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                        <StaffCard name="Klaus-Dieter Hoffmann" job="Fachberater/-innen" color="#2f3542" link="tel:0531 210 55 08" label="0531 210 55 98" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                        <StaffCard name="Elke Grigat" job="Fachberater/-innen" color="#2f3542" link="tel:0531 210 55 38" label="0531 210 55 38" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                    
                        <StaffCard name="Silke Künstler" job="Vertriebsinnendienst" color="#2f3542" link="tel:0531 210 55 23" label="0531 210 55 23" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                        <StaffCard name="Romina Pagano" job="Vertriebsinnendienst" color="#2f3542" link="tel:0531 210 55 28" label="0531 210 55 28" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                        <StaffCard name="Yasmin Ruben" job="Vertriebsinnendienst" color="#2f3542" link="tel:0531 210 55 32" label="0531 210 55 32" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                        <StaffCard name="Phil Bartelt" job="Vertriebsinnendienst" color="#2f3542" link="tel:0531 210 55 36" label="0531 210 55 36" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                    
                        <StaffCard name="Benjamin Vahle" job="Leitung Marketing & Kommunikation" link="tel:0531 210 55 16" label="0531 210 55 16" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                    
                        <StaffCard name="Franziska Brandt" job="Mediengestalter/-innen" color="#2f3542" link="tel:0531 210 55 51" label="0531 210 55 51" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                        <StaffCard name="Maurice Freuwört" job="Mediengestalter/-innen" color="#2f3542" link="tel:0531 210 55 73" label="0531 210 55 73" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                        <StaffCard name="Franziska Wolff" job="Mediengestalter/-innen" color="#2f3542" link="tel:0531 210 55 25" label="0531 210 55 25" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                        <StaffCard name="Carolin Götzner" job="Mediengestalter/-innen" color="#2f3542" link="tel:0531 210 55 43" label="0531 210 55 43" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                        <StaffCard name="Annika Görmann" job="Mediengestalter/-innen" color="#2f3542" link="tel:0531 210 55 72" label="0531 210 55 72" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                    
                        <StaffCard name="Harald Reckwald" job="Leitung Lager" link="tel:0531 210 55 57" label="0531 210 55 57" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                    
                        <StaffCard name="Timo Welskop" job="Leitung Fuhrpark" link="tel:0531 210 55 56" label="0531 210 55 56" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                    
                        <StaffCard name="Tobias Behnstedt" job="Leitung Fleischabteilung" link="tel:0531 210 55 26" label="0531 210 55 26" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                        <StaffCard name="Niels Brandt" job="Leitung Fleischabteilung" link="tel:0531 210 55 27" label="0531 210 55 27" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                    
                        <StaffCard name="Annette Körner" job="Leitung Werkstatt/Kundendienst" link="tel:0531 210 55 24" label="0531 210 55 24" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                        <StaffCard name="Marcus Zetzsche" job="Leitung Werkstatt/Kundendienst" link="tel:0531 210 55 12" label="0531 210 55 12" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                    
                        <StaffCard name="Karsten Strothmann" job="Fachberater Geräte/Maschinen" color="#2f3542" link="tel:0531 210 55 41" label="0531 210 55 41" image="/images/content/test_pfp.jpg" overlay="/images/content/test_pfp_overlay.jpg" alt=""/>
                    </div>
                </div>
            </section>
        </main>
    </GuestLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import GuestLayout from '@/Layouts/Guest.vue'
    import ValidationErrors from '@/Components/ValidationErrors.vue'
    import StaffCard from '@/Components/Page/StaffCard.vue'
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
            gap: calc(var(--su) * 2)

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
            grid-template-columns: repeat(4, 1fr)
            gap: 2rem
            margin-bottom: 4rem



    @media only screen and (max-width: 1000px)
        #content-section
            .staff-card-container
                grid-template-columns: repeat(3, 1fr)



    @media only screen and (max-width: 700px)
        #content-section
            .staff-card-container
                grid-template-columns: repeat(2, 1fr)



    @media only screen and (max-width: 500px)
        #hero-section
            padding-bottom: 0
            height: 250px

        #form-section
            .wrapper
                flex-direction: column
                margin-bottom: calc(var(--su) * 2)
                padding-inline: var(--su)
                gap: calc(var(--su) * 1.25)
                transform: none

                .card
                    border-radius: 0
                    box-shadow: none
                    padding-inline: 0

        #content-section
            .staff-card-container
                grid-template-columns: repeat(1, 1fr)
</style>