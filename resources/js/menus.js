export const mainMenu = [
    { id: 'home', label: 'Home', href: route('home'), children: [] },
    { id: 'blog', label: 'Blog', href: route('blog'), children: [] },
    { id: 'philosophie', label: 'Philosophie', href: route('philosophie'), children: [] },
    { id: 'produkte-und-services', label: 'Produkte & Services', href: route('produkte-und-services'), children: [
        { id: 'angebote', label: 'Aktuelle Angebote', href: route('ps.angebote'), children: [] },
        { id: 'foodservice', label: 'Foodservice', href: route('ps.foodservice'), children: [
            { id: 'mehrwegpflicht', label: 'Mehrwegpflicht ab 2023', href: route('ps.mehrwegpflicht'), children: [] },
        ]},
        { id: 'unsere-marken', label: 'Unsere Marken', href: route('ps.marken'), children: [
            { id: 'eichenhof', label: 'Eichenhof', href: route('ps.marken.eichenhof'), children: [] },
            { id: 'il-campese', label: 'Il Campese', href: route('ps.marken.il-campese'), children: [] },
            { id: 'maxi-france', label: 'Maxi France', href: route('ps.marken.maxi-france'), children: [] },
        ]},
        // { id: 'mkbs', label: 'Marketing & Kommunikation', href: route('mkbs'), children: [
        //     { id: 'mkbs.web', label: 'Web Entwicklung', href: route('mkbs.web'), children: [] },
        //     { id: 'mkbs.social-media', label: 'Social Media Marketing', href: route('mkbs.social-media'), children: [] },
        //     { id: 'mkbs.print', label: 'Print Design', href: route('mkbs.print'), children: [] },
        //     { id: 'mkbs.online', label: 'Online Marketing', href: route('mkbs.online'), children: [] },
        //     // { id: 'mkbs.digital', label: 'Digital Marketing', href: route('mkbs.digital'), children: [] },
        //     // { id: 'mkbs.adwork', label: 'Verkaufsförderung', href: route('mkbs.adwork'), children: [] },
        // ]},
        { id: 'marketing-und-kommunikation', label: 'Marketing & Kommunikation', href: route('ps.marketing-und-kommunikation'), children: [] },
        { id: 'fachberatung-kaese-und-salate', label: 'Fachberatung: Käse & Salate', href: route('ps.fachberatung-kaese-und-salate'), children: [] },
        { id: 'technischer-kundendienst', label: 'Technischer Kundendienst', href: route('ps.technischer-kundendienst'), children: [] },
        { id: 'seminare', label: 'Seminare', href: route('seminare'), children: [
            // { id: 'seminare.grillseminar', label: 'Grillseminar', href: route('seminare.grillseminar'), children: [] },
            // { id: 'seminare.kreativworkshop', label: 'Kreativworkshop', href: route('seminare.kreativworkshop'), children: [] },
            { id: 'seminare.catering', label: 'Catering', href: route('seminare.catering'), children: [] },
            { id: 'seminare.employer-branding', label: 'Employer Branding', href: route('seminare.employer-branding'), children: [] },
            // { id: 'seminare.kaeseworkshop', label: 'Käseworkshop', href: route('seminare.kaeseworkshop'), children: [] },
        ] },
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