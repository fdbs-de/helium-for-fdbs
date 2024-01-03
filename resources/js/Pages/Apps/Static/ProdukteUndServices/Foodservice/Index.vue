<template>
    <TextSubLayout title="Unser Foodservice" image="/images/content/banner/foodservice_365702048_356901877_454625888.webp">
        <Head>
            <title>Produkte & Services: Foodservice – FDBS</title>
        </Head>

        <!-- <h2 class="w-100" style="text-align: center;">Unsere Leistungen im Überblick</h2>

        <div class="keyfacts">
            <div class="placeholder-c2"></div>
            <div class="fact-card">
                <div class="icon font-icon">kebab_dining</div>
                <h3>Fleisch</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">favorite</div>
                <h3>Obst & Gemüse</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">microwave_gen</div>
                <h3>Convenience Food</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">local_pizza</div>
                <h3>Käse</h3>
            </div>
            <div class="fact-card">
                <div class="icon font-icon">sell</div>
                <h3>Unsere Marken</h3>
            </div>
        </div>

        <div class="limiter text-limiter">
            <img src="/images/content/customerservice/service_393833200.png" alt="Service" class="content-image">
            <h2>Fleisch</h2>
            <p>
            </p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>

            <img src="/images/content/customerservice/service_393833200.png" alt="Service" class="content-image">
            <h2>Unsere Marken</h2>
            <p>
            </p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>

            <img src="/images/content/customerservice/service_393833200.png" alt="Service" class="content-image">
            <h2>Convenience Food</h2>
            <p>
            </p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            
            <img src="/images/content/customerservice/service_393833200.png" alt="Service" class="content-image">
            <h2>Obst & Gemüse</h2>
            <p>
            </p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>

            <img src="/images/content/customerservice/service_393833200.png" alt="Service" class="content-image">
            <h2>Käse</h2>
            <p>
            </p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
        </div> -->

        <!-- <div class="limiter">            
            <h2 class="text-align-center">Unser Team</h2>
            <div class="grid">
                <StaffCard
                    v-for="employee in departments.find(e => e.id === 'vertriebsinnendienst').employees"
                    :key="employee.name"
                    :name="employee.name"
                    :job="employee.job"
                    :leader="employee.leader"
                    :tel="employee.tel"
                    :image="employee.image || '/images/content/mitarbeiter/missing.png'"
                    :overlay="employee.overlay"/>
            </div>
        </div> -->
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import departments from '@/Pages/Apps/Static/Kontakt.json'
    
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import StaffCard from '@/Components/Page/StaffCard.vue'
</script>

<style lang="sass" scoped>
    .keyfacts
        display: grid
        grid-template-columns: 1fr 1fr 1fr
        grid-auto-rows: 4rem
        grid-gap: 3rem
        padding-inline: 6rem
        padding-block: 3rem 10rem

        --color-local-primary: #e00047
        --color-local-primary-shade: #e0004730

    .placeholder-c2
        grid-column: 2
        grid-row: 1

    .fact-card
        background: var(--color-background)
        border-radius: var(--radius-l)
        padding: 1.5rem
        display: flex
        flex-direction: column
        align-items: center
        justify-content: center
        grid-row: span 2
        gap: 1.5rem
        border: 1px solid var(--color-background-soft)
        box-shadow: var(--shadow-elevation-low)
        transition: all 0.2s ease-in-out

        &:hover
            box-shadow: var(--shadow-elevation-medium)

        .icon
            font-size: 4rem
            line-height: 1
            color: var(--color-local-primary)
            filter: drop-shadow(0.07em 0.07em 0px var(--color-local-primary-shade))

        h3
            font-size: 1.3rem
            margin: 0
            text-align: center

    @media only screen and (max-width: 1100px)
        .keyfacts
            padding-inline: 0rem

    @media only screen and (max-width: 900px)
        .keyfacts
            grid-template-columns: 1fr 1fr

    @media only screen and (max-width: 600px)
        .keyfacts
            grid-template-columns: 1fr !important
            grid-auto-rows: auto
            gap: 2rem
            padding-bottom: 4rem

            .fact-card
                grid-row: auto

                .icon
                    font-size: 3rem

                h3
                    font-size: 1.1rem

            .placeholder-c2
                display: none
</style>

<style lang="sass" scoped>
    .grid
        display: grid
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr))
        gap: 2rem

    .card
        background: var(--color-background)
        border-radius: var(--radius-m)
        box-shadow: var(--shadow-elevation-low)
</style>