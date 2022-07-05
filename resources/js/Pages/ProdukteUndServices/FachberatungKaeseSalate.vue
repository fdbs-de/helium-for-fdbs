<template>
    <ServiceSubLayout title="Fachberatung: Käse & Salate" image="/images/content/test_banner.jpg">
        <Head>
            <title>Produkte & Services: Fachberatung Käse & Salate</title>
        </Head>

        <template #ansprechpartner>
            <StaffCard class="service-scroll-item" name="Elke Grigat" tel="38" image="/images/content/mitarbeiter/elke_grigat.png"/>
        </template>

        <p>
            Eine fachliche und fundierte Beratung - das erwartet Ihr Kunde, wenn er Ihren Betrieb betritt und
            das können Sie mit Ihrer Ausbildung und Ihrer Erfahrung auch bieten. Mittlerweile ist jedoch auch
            Käse ein fester Bestandteil des Sortiments geworden und auch hier erwartet der Kunde die gleiche
            Kompetenz wie bei Wurst- und Schinkenspezialitäten. Die Geschichte hinter dem Käse, wo kommt er
            her, wie wird er hergestellt, was macht ihn zu etwas Besonderem gibt Ihnen die Möglichkeit sich
            von Mitbewerbern klar abzuheben. Neben einer attraktiven Präsentation ist gerade dieses ausgeprägte
            "Know how" die Grundlage für erfolgreichen Verkauf.<br>
            Gerne bin ich für Sie da und unterstütze Sie durch:
        </p>
        <ul>
            <li>Beratung vor Ort</li>
            <li>Thekengestaltung</li>
            <li>Sortimentsoptimierung</li>
            <li>Verkaufsschulungen</li>
            <li>Testeinkäufe</li>
            <li>Individuelle Verkaufsaktionen</li>
        </ul>
        <p>
            Seit über 25 Jahren gehört das Thema Käse zu meinem Fachgebiet. Um Sie umfassend und kompetent beraten zu
            können, habe ich an der Fachausbildung zur Diplom-Käsesommeliere teilgenommen und mit Auszeichnung
            bestanden.
        </p>
        <p>
            Das dort vermittelte Wissen umfasst die Geschichte um Käse, über die Rohprodukte, die Herstellungsverfahren,
            Käsegruppen und deren Reifungsmöglichkeiten. Darüber hinaus sind Kenntnisse rund um die Käse dieser Welt,
            z.B. Frankreich, Italien, Schweiz, Österreich, Norwegen, England usw. erforderlich. Professionelle
            Präsentation, Schnitttechniken und Verkaufsberatungen gehören selbstverständlich ebenso in das
            Aufgabengebiet eines Sommelieres. Die Ausbildung gab mir die Möglichkeit, das Thema Käse aus den
            unterschiedlichsten Blickwinkeln zu betrachten und hat mir bei diversen Projekten, wie z. B. moderierten
            Käse-/Weinabenden und Workshops die fachliche Sicherheit verliehen.
        </p>
        <p>
            Neue Trends und ein verändertes Ernährungsverhalten haben mich vor einiger Zeit dazu verleitet, mein Wissen
            durch die Ausbildung zur Ernährungsberaterin zu erweitern. Ernährungsphysiologische Themen von Nährwerten,
            Zusatzstoffen, Diäten und Zubereitungsformen gehören seitdem zu meinem Fachgebiet und bereichern sowohl
            meine Arbeit als auch mich ganz persönlich. Diese Erfahrung und dieses Wissen gebe ich ebenfalls gerne an
            Sie weiter und unterstütze Sie in allen Fragen rund um das Thema Ernährung. Wissensvermittlung ist eine
            große Leidenschaft von mir geworden und ich bin dankbar, dass ich Ihnen in den letzten Jahren eine Vielzahl
            an Seminaren und Workshops zu den unterschiedlichsten Themen anbieten durfte. Unser aktuelles Angebot
            präsentiert sich Ihnen auf unserer Homepage.
        </p>

        <p><strong>Fragen? Wünsche? Anregungen?</strong></p>
        <p><strong>Sprechen Sie mich gerne an.</strong></p>
        <p>Ich bin gerne für Sie da!</p>

        <p>&nbsp;</p>
        
        <div class="item-wrapper flex gap-2">
            <Card class="flex-1" new-window aspect-ratio="16/9" name="Zertifikat: Someliere Elke Grigat" image="/images/content/services/some.jpg" link="/images/content/services/some.jpg" />
            <Card class="flex-1" new-window aspect-ratio="16/9" name="Zertifikat: Ernährungsberatung Elke Grigat" image="/images/content/services/zertifikat_ernaehrungsberatung.jpg" link="/images/content/services/zertifikat_ernaehrungsberatung.jpg" />
        </div>
    </ServiceSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import ServiceSubLayout from '@/Layouts/SubLayouts/Service.vue'
    import StaffCard from '@/Components/Page/StaffCard.vue'
    import Card from '@/Components/Page/Card.vue'
</script>

<style lang="sass">
    @media screen and (max-width: 600px)
        .item-wrapper
            flex-direction: column
</style>