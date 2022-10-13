<template>
    <ServiceSubLayout title="Technischer Kundendienst">
        <Head>
            <title>Produkte & Services: Technischer Kundendienst</title>
        </Head>

        <template #ansprechpartner>
            <StaffCard class="service-scroll-item" name="Annette Körner" job="Leitung" leader tel="24" image="/images/content/mitarbeiter/annette_koerner.png" overlay="/images/content/mitarbeiter/annette_koerner_zeichnung.png"/>
            <StaffCard class="service-scroll-item" name="Marcus Zetzsche" job="Stv. Leitung" leader tel="12" image="/images/content/mitarbeiter/marcus_zetzsche.png" overlay="/images/content/mitarbeiter/marcus_zetzsche_zeichnung.png"/>
            <StaffCard class="service-scroll-item" name="Sabine Barnert" tel="76" image="/images/content/mitarbeiter/sabine_barnert.png" overlay="/images/content/mitarbeiter/sabine_barnert_zeichnung.png"/>
            <StaffCard class="service-scroll-item" name="André Hoffmann" tel="41" image="/images/content/mitarbeiter/missing.png"/>
            <StaffCard class="service-scroll-item" name="Holger Kleinert" tel="14" image="/images/content/mitarbeiter/missing.png"/>
            <StaffCard class="service-scroll-item" name="Wiebke Peter" tel="75" image="/images/content/mitarbeiter/wiebke_peter.png" overlay="/images/content/mitarbeiter/wiebke_peter_zeichnung.png"/>
        </template>

        <p><strong>Reparatur und Durchsicht</strong></p>
        <ul>
            <li>Hand- und Druckluft-Clipper (Poly- und Technoclipper)</li>
            <li>Kombidämpfer (Rational-Convotherm-Unox-Wiesheu)</li>
            <li>Tisch- und Standvacuumgeräte (Röscher-Komet-Multivac-Boss)</li>
            <li>Rauchanlagen (Fessmann und Bastra)</li>
            <li>Kesselanlagen (Fessmann-Bastra-Brökelmann)</li>
            <li>Bandsägen (EFA-Freund-Kolbe-Mado-Bizerba)</li>
            <li>Allesschneider/Gemüseschneider (Treif-Alexander Solia)</li>
            <li>Fleischwölfe (K+G-Seydelmann-Mado-Kolbe-Rex Düker)</li>
            <li>Kutter (K+G-Seydelmann-Kilia-Rex Düker)</li>
            <li>Füllmaschinen (Frey)</li>
            <li>Pökelinjektoren (Günther-Hawerkamp)</li>
            <li>Menger und Poltermaschinen (Stork+Herrmann-Röscher-Günther)</li>
            <li>Dosen Verschließmaschinen (Lanico-Stiller)</li>
            <li>Spülmaschinen (Hobart)</li>
            <li>Betäubungsanlagen (Baumann)</li>
        </ul>
        <p><strong>Service</strong></p>
        <ul>
            <li>Elektroschweißarbeiten</li>
            <li>Elektronikarbeiten</li>
            <li>Rohrreinigung</li>
            <li>Rissprüfung von Kuttermessern</li>
            <li>Schleifarbeiten auf modernen Schleifmaschinen (Handmesser, Kuttermesser, Wolfscheiben)</li>
            <li>Vorführung von Schaumreinigung in Ihrem Betrieb</li>
            <li>Hackblock- und Schneidbrettbegradigung</li>
            <li>Installation von Wasserfilteranlagen (Brita Filter)</li>
        </ul>
        <p><strong>Haben Sie noch Fragen?</strong></p>
        <p><strong>Bitte sprechen Sie uns an.</strong></p>
        <p>Wir sind gerne für Sie da!</p>
        <p>&nbsp;</p>
    </ServiceSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import ServiceSubLayout from '@/Layouts/SubLayouts/Service.vue'
    import StaffCard from '@/Components/Page/StaffCard.vue'
</script>