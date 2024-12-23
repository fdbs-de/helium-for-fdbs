export const mainMenu = [
    { id: 'home', label: 'Home', href: '/', children: [] },
    { id: 'blog', label: 'Blog', href: route('blog'), children: [] },
    { id: 'philosophie', label: 'Philosophie', href: route('philosophie'), children: [
        { id: 'philosophie.nachhaltigkeit', label: 'Nachhaltigkeit', href: route('nachhaltigkeit'), children: [] },
    ] },
    { id: 'produkte-und-services', label: 'Produkte & Services', href: route('produkte-und-services'), children: [
        { id: 'angebote', label: 'Aktuelle Angebote', href: route('ps.angebote'), children: [] },
        { id: 'foodservice', label: 'Foodservice', href: route('ps.foodservice'), children: [
            { id: 'foodservice.aktuelles', label: 'Top Aktuelles', href: route('ps.marken.eichenhof'), children: [] },
            { id: 'tierhaltungskennzeichnung', label: 'Tierhaltungskennzeichnung', href: route('ps.tierhaltungskennzeichnung'), children: [] },
            { id: 'mehrwegpflicht', label: 'Mehrwegpflicht', href: route('ps.mehrwegpflicht'), children: [] },
        ]},
        { id: 'unsere-marken', label: 'Unsere Marken', href: route('ps.marken'), children: [
            { id: 'eichenhof', label: 'Eichenhof', href: route('ps.marken.eichenhof'), children: [] },
            { id: 'il-campese', label: 'Il Campese', href: route('ps.marken.il-campese'), children: [] },
            { id: 'maxi-france', label: 'Maxi France', href: route('ps.marken.maxi-france'), children: [] },
        ]},
        { id: 'mkbs', label: 'Marketing & Kommunikation', href: route('mkbs'), children: [
            // { id: 'mkbs.aktuelles', label: 'Top Aktuelles', href: route('mkbs.aktuelles'), children: [] },
            { id: 'mkbs.recruiting', label: 'Recruiting', href: route('mkbs.recruiting'), children: [] },
            { id: 'mkbs.web', label: 'Web Entwicklung', href: route('mkbs.web'), children: [] },
            { id: 'mkbs.social-media', label: 'Social Media Marketing', href: route('mkbs.social-media'), children: [] },
            { id: 'mkbs.print', label: 'Print Design', href: route('mkbs.print'), children: [] },
            { id: 'mkbs.crossmedia', label: 'Crossmedia Marketing', href: route('mkbs.crossmedia'), children: [] },
        ]},
        // { id: 'fachberatung-kaese-und-salate', label: 'Fachberatung: Käse & Salate', href: route('ps.fachberatung-kaese-und-salate'), children: [] },
        { id: 'technischer-kundendienst', label: 'Technischer Kundendienst', href: route('ps.technischer-kundendienst'), children: [
            { id: 'technischer-kundendienst.aktuelles', label: 'Top Aktuelles', href: route('ps.technischer-kundendienst.aktuelles'), children: [] },
        ] },
        // { id: 'seminare', label: 'Seminare', href: route('seminare'), children: [
        //     // { id: 'seminare.grillseminar', label: 'Grillseminar', href: route('seminare.grillseminar'), children: [] },
        //     // { id: 'seminare.kreativworkshop', label: 'Kreativworkshop', href: route('seminare.kreativworkshop'), children: [] },
        //     // { id: 'seminare.kaeseworkshop', label: 'Käseworkshop', href: route('seminare.kaeseworkshop'), children: [] },
        //     // { id: 'seminare.catering', label: 'Catering', href: route('seminare.catering'), children: [] },
        //     // { id: 'seminare.employer-branding', label: 'Employer Branding', href: route('seminare.employer-branding'), children: [] },
        // ] },
        // { id: 'messeanmeldung', label: 'Messeanmeldung 2023', href: route('fair'), children: [] },
    ]},
    { id: 'karriere', label: 'Karriere', href: route('karriere'), children: [] },
    { id: 'kontakt', label: 'Kontakt & Ansprechpartner', href: route('kontakt'), children: [] },
]



export const legalMenu = [
    { id: 'impressum', label: 'Impressum', href: route('impressum'), children: [] },
    { id: 'datenschutz', label: 'Datenschutz', href: route('datenschutz'), children: [] },
    { id: 'agbs', label: 'AGBs', href: route('agbs'), children: [] },
    { id: 'video-info', label: 'Info Videoüberwachung', href: route('video-info'), children: [] },
    { id: 'gewinnspiel-teilnahmebedingungen', label: 'Gewinnspiel Teilnahmebedingungen', href: route('gewinnspiel-teilnahmebedingungen'), children: [] },
]

export const aboutMenu = [
    { id: 'about-philosophie', label: 'Philosophie', href: route('philosophie'), children: [] },
    { id: 'about-karriere', label: 'Karriere', href: route('karriere'), children: [] },
    { id: 'about-kontakt', label: 'Kontakt', href: route('kontakt'), children: [] },
]