<template>
    <section class="fdbs-services" id="services" :style="{padding, backgroundColor}">
        <component class="he-text-section-limiter" :is="LimiterManifest.component" :size="size">
            <h2>Unsere Services</h2>
            <div class="grid">
                <div class="service-card" :class="{'highlight': card.highlight}" v-for="card in cards">
                    <IodIcon :icon="card.icon" />
                    <h3>{{ card.title }}</h3>
                    <p>{{ card.text }}</p>
                    <IodButton is="a" :label="card.button" :href="card.link"/>
                </div>
            </div>
        </component>
    </section>
</template>

<script setup>
    import { ref } from 'vue'
    import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'
    
    
    
    defineProps({
        size: String,
        padding: String,
        backgroundColor: String,
    })

    const cards = ref([
        {
            highlight: true,
            icon: 'handshake',
            title: 'Karriere',
            text: 'Wir suchen dich! Hier Findest du unsere aktuellen Stellenangebote.',
            button: 'Job finden',
            link: '/karriere',
        },
        {
            highlight: false,
            icon: 'verified',
            title: 'Aktuelle Angebote',
            text: 'Finden Sie unsere aktuellen Monats- und Grillangebot ganz einfach zum Download.',
            button: 'Zu den Angebote',
            link: '/angebote',
        },
        {
            highlight: false,
            icon: 'school',
            title: 'Seminare',
            text: 'Sehen Sie sich unser breites Angebot an Seminaren und Workshops an.',
            button: 'Mehr erfahren',
            link: '/produkte-und-services/seminare',
        },
        {
            highlight: false,
            icon: 'restaurant',
            title: 'Foodservice',
            text: 'Wir bieten Ihnen ein breites Sortiment an Food- und Non-Food-Produkten.',
            button: 'Mehr erfahren',
            link: '/produkte-und-services/foodservice',
        },
        {
            highlight: false,
            icon: 'style',
            title: 'Unsere Marken',
            text: 'Unsere Marken bieten Ihnen höchste Qualität und ein breites Sortiment.',
            button: 'Mehr erfahren',
            link: '/produkte-und-services/marken',
        },
        {
            highlight: false,
            icon: 'local_pizza',
            title: 'Käse und Salate',
            text: 'Wir bieten Ihnen ein breites Sortiment an Käse- und Salatprodukten.',
            button: 'Mehr erfahren',
            link: '/produkte-und-services/fachberatung-kaese-und-salate',
        },
    ])
</script>

<style lang="sass" scoped>
    .fdbs-services
        h2
            font-size: clamp(2rem, 10vw, 3.5rem)
            text-align: center
            font-weight: 600
            margin-block: 0 4rem

        .grid
            display: grid
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr))
            gap: 4rem

        .service-card
            display: flex
            flex-direction: column
            align-items: stretch
            gap: 2rem
            padding: 2rem
            border-radius: var(--radius-l)
            border: 1px solid var(--color-border)
            text-align: center

            &.highlight
                border-color: var(--color-primary)
                box-shadow: var(--shadow-elevation-medium)
                background: var(--color-primary)
                color: var(--color-on-primary)

                .iod-icon
                    color: inherit
                    filter: drop-shadow(4px 4px 0 #ffffff40)

                h3
                    color: inherit

                .iod-button
                    --local-color-background: var(--color-on-primary)
                    --local-color-text: var(--color-primary)

            .iod-icon
                font-size: 4rem
                color: var(--color-primary)
                margin: 1rem auto
                filter: drop-shadow(4px 4px 0 #e0004730)
            
            h3
                margin: 0
                font-weight: 600
                color: var(--color-primary)

            p
                margin: 0
                flex: 1
</style>