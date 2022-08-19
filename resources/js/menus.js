export const mainMenu = [
    { id: 'home', label: 'Home', href: route('home'), children: [] },
    { id: 'philosophie', label: 'Philosophie', href: route('philosophie'), children: [] },
    { id: 'projekte-und-services', label: 'Produkte & Services', href: route('produkte-und-services'), children: [
        { id: 'angebote', label: 'Aktuelle Angebote', href: route('ps.angebote'), children: [] },
        { id: 'foodservice', label: 'Foodservice', href: route('ps.foodservice'), children: [] },
        { id: 'unsere-marken', label: 'Unsere Marken', href: route('ps.marken'), children: [
            { id: 'eichenhof', label: 'Eichenhof', href: route('ps.marken.eichenhof'), children: [] },
            { id: 'il-campese', label: 'Il Campese', href: route('ps.marken.il-campese'), children: [] },
            { id: 'maxi-france', label: 'Maxi France', href: route('ps.marken.maxi-france'), children: [] },
        ]},
        { id: 'fachberatung-kaese-und-salate', label: 'Fachberatung: Käse & Salate', href: route('ps.fachberatung-kaese-und-salate'), children: [] },
        { id: 'marketing-und-kommunikation', label: 'Marketing & Kommunikation', href: route('ps.marketing-und-kommunikation'), children: [] },
        { id: 'technischer-kundendienst', label: 'Technischer Kundendienst', href: route('ps.technischer-kundendienst'), children: [] },
        { id: 'seminare', label: 'Seminare', href: route('ps.seminare'), children: [] },
    ]},
    { id: 'karriere', label: 'Karriere', href: route('karriere'), children: [
        // { id: 'stellenangebote', label: 'Stellenangebote', href: route('karriere.stellenangebote'), children: [] },
        // { id: 'studium-ausbildung', label: 'Studium & Ausbildung', href: route('karriere.studium-und-ausbildung'), children: [] },
        // { id: 'fdbs-als-arbeitgeber', label: 'FDBS als Arbeitgeber', href: route('karriere.fdbs-als-arbeitgeber'), children: [] },

    ]},
    { id: 'kontakt', label: 'Kontakt & Ansprechpartner', href: route('kontakt'), children: [] },
]



export const legalMenu = [
    { id: 'impressum', label: 'Impressum', href: route('impressum'), children: [] },
    { id: 'datenschutz', label: 'Datenschutz', href: route('datenschutz'), children: [] },
    { id: 'agbs', label: 'AGBs', href: route('agbs'), children: [] },
    { id: 'video-info', label: 'Info Videoüberwachung', href: route('video-info'), children: [] },
]

export const aboutMenu = [
    { id: 'about-philosophie', label: 'Philosophie', href: route('philosophie'), children: [] },
    { id: 'about-karriere', label: 'Karriere', href: route('karriere'), children: [] },
    { id: 'about-kontakt', label: 'Kontakt', href: route('kontakt'), children: [] },
]