export const mainmenu = [
    { id: 'home', label: 'Home', href: route('home'), icon: null, children: [] },
    { id: 'philosophie', label: 'Philosophie', href: route('philosophie'), icon: null, children: [] },
    {
        label: 'Produkte & Services',
        href: route('produkte-und-services'),
        icon: null,
        children: [
            { id: 'foodservice', label: 'Foodservice', href: route('foodservice'), icon: null, children: [] },
            { id: 'unsere-marken', label: 'Unsere Marken', href: route('unsere-marken'), icon: null, children: [] },
            { id: 'fachberatung-kaese-und-salate', label: 'Fachberatung Käse & Salate', href: route('fachberatung-kaese-und-salate'), icon: null, children: [] },
            { id: 'marketing-und-kommunikation', label: 'Marketing & Kommunikation', href: route('marketing-und-kommunikation'), icon: null, children: [] },
            { id: 'technischer-kundendienst', label: 'Technischer Kundendienst', href: route('technischer-kundendienst'), icon: null, children: [] },
            { id: 'seminare', label: 'Seminare', href: route('seminare'), icon: null, children: [] },
        ],
    },
    { id: 'karriere', label: 'Karriere', href: route('karriere'), icon: null, children: [] },
    { id: 'kontakt', label: 'Kontakt', href: route('kontakt'), icon: null, children: [] },
]