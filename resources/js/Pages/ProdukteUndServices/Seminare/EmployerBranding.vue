<template>
    <TextSubLayout title="Workshop Employer Branding – Wie werde ich als Arbeitgeber sichtbar?" image="/images/content/seminare/employer-branding/employer_branding_header_563275363.webp" color="var(--color-primary)" has-small-limiter>
        <Head>
            <title>Workshop Employer Branding – Wie werde ich als Arbeitgeber sichtbar? – FDBS Seminare</title>
        </Head>

        <Alert title="Wichtiges im Überblick:">
            <div class="head-grid">
                <span>Datum:</span>
                <span><b>10. Juli 2023</b></span>
                
                <span style="line-height: 1.4">Uhrzeit:</span>
                <span style="line-height: 1.4"><b>10:00 - ca. 16:00</b><br><small>(inkl. Pausenzeiten)</small></span>

                <span>Referenten:</span>
                <span><b>Maja Kirsch, Benjamin Vahle</b></span>
                
                <span>Seminargebühren:</span>
                <span>
                    <Tag shape="pill" color="var(--color-green)"><b>99,00 €</b></Tag>
                </span>

                <span>Teilnehmerzahl:</span>
                <span>
                    <Tag shape="pill" color="var(--color-red)"><b>begrenzt</b></Tag>
                </span>
            </div>
        </Alert>
        <p>&nbsp;</p>

        <p>
            Qualifizierte und motivierte Mitarbeitende für sich zu gewinnen, ist umso erfolgreicher, je sichtbarer Sie als
            Arbeitgeber sind. Machen Sie sich zur Marke! Erfahren Sie in diesem Seminar Möglichkeiten, sich authentisch und
            unverwechselbar auf dem Markt zu präsentieren. Lassen Sie sich von unseren Referenten Maja Kirsch und Benjamin Vahle,
            an diesem Tag mit Praxiserfahrung und fachlichem Knowhow inspirieren.
        </p>
        <p>
            Eine wichtige Grundlage basiert darauf, die eigene Zielgruppe zu kennen und diese als Arbeitgeber mit einer ehrlichen
            und zielgruppengerechten Ansprache über alle Kanäle hinweg zu überzeugen. Hierzu leisten Employer Branding und
            Arbeitgebermarketing einen zentralen Beitrag.
        </p>
        <h3>Was erwartet Sie in diesem Seminar?</h3>
        <p>
            <ul>
                <li>Recruiting – aktuelle Trends und Herausforderungen</li>
                <li>Was macht eine gute Arbeitgebermarke aus?</li>
                <li>Zielklarheit herstellen: Wen suche ich eigentlich?</li>
                <li>Interne Aktivierung und Verankerung der Arbeitgebermarke</li>
                <li>Do‘s und Don‘ts für eine optimale Einführung der Arbeitgebermarke</li>
                <li>Welche Medien und welche Maßnahmen machen Sinn?</li>
                <li>Umsetzung der Arbeitgebermarke in Recruiting Kanälen wie Website, Social Media, Stellenbörsen, Messen, Active Sourcing etc.</li>
                <li>Chancen und Risiken von Bewerbungsportalen</li>
            </ul>
        </p>
        <p>
            Gerne begleiten wir Sie auch nach diesem Impulsseminar bei der Gestaltung Ihrer eigenen Arbeitgebermarke.
        </p>
        <p>&nbsp;</p>

        <h3>Zielgruppe</h3>
        <p>
            <ul>
                <li>Employer Branding ist Chefsache!</li>
                <li>Mitarbeiter im Personalbereich</li>
            </ul>
        </p>
        <p>&nbsp;</p>

        <template v-if="form">
            <h3>Anmeldung</h3>
            <fieldset>
                <FrontendForm :form="form"/>
            </fieldset>
        </template>
        <template v-else>
            <Alert title="Anmeldung nicht mehr möglich!" type="warning">
                <span class="margin-bottom-1">Die Anmeldung für dieses Seminar ist leider nicht mehr möglich.</span>
            </Alert>
        </template>

        <p>&nbsp;</p>
        <h3>Über die Referenten</h3>
        <Alert title="Maja Kirsch">
            <p>HR-Managerin beim FDBS Braunschweig</p>
            <p>
                <img src="/images/content/seminare/employer-branding/maja_kirsch.webp" alt="Maja Kirsch Portrait" class="radius-s margin-right-2" width="140" style="float: left">
                <b>Über 15 Jahre Berufserfahrung als:</b>
                <ul>
                    <li>Führungskraft in Hotellerie, Gastronomie sowie im Fach- und Großhandel: zahlreiche Stationen in der gehobenen Hotellerie & Spitzengastronomie</li>
                    <li>Category & nationales Key Account Management</li>
                    <li>Zustellgrosshandel</li>
                    <li>Vertriebsleitung Wein – und Spirituosenbranche</li>
                    <li>Alchimedus® Master für systemische Personal – und Organisationsentwicklung</li>
                    <li>Hotelbetriebswirtin, Handelsfachwirtin mit Schwerpunkt Personal & Vertrieb</li>
                    <li>Zertifizierter Jugend – und Familiencoach</li>
                    <li>seit 2008 Dozentin für Schulungen von Führungskräften,Mitarbeitern und Auszubildenden</li>
                </ul>
            </p>
        </Alert>
        <p>&nbsp;</p>
        <Alert title="Benjamin Vahle">
            <p>Head of Marketing beim FDBS Braunschweig.</p>
            <p>
                <img src="/images/content/seminare/employer-branding/benjamin_vahle.webp" alt="Benjamin Vahle Portrait" class="radius-s margin-right-2" width="140" style="float: left">
                <b>Über 16 Jahre Berufserfahrung im Bereich Marketing und Werbung und 6 Jahre Berufserfahrung im sozialen Bereich:</b>
                <ul>
                    <li>unter anderem Tätigkeit in der Erwachsenenbildung</li>
                    <li>Selbstständigkeit im Bereich Marketing und Kommunikation</li>
                    <li>kontinuierliche Weiterentwicklung des Marketing-Teams und der Marketing-Abteilung, sowie Erweiterung des Angebots für den FDBS und dessen Kunden.</li>
                    <li>Freie Mitarbeit und Fortbildung im Fotostudio einer studierten Fotografin</li>
                    <li>Teilnahme an vielfältigen Fortbildungen und Seminaren, unter anderem: „Öffentlichkeitsarbeit: PR-Konzepte entwickeln“, „Corporate Design Strategien“, „PHP / MYSQL Workshops“, Cleverprinting Schulung „Next Generation Publishing“, Google Zukunftswerk-statt „Grundlagen des Online-Marketings“, nebenberufliches Fernstudium „Online-Marketing“</li>
                </ul>
            </p>
        </Alert>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import Alert from '@/Components/Alert.vue'
    import Tag from '@/Components/Form/Tag.vue'
    import FrontendForm from '@/Components/Apps/Forms/Frontend/Form.vue'
    
    defineProps({
        form: Object,
    })
</script>

<style lang="sass" scoped>
    .head-grid
        display: grid
        gap: 1rem
        grid-template-columns: auto 1fr
</style>