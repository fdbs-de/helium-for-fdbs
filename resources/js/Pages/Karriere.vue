<template>
    <TextSubLayout title="Unsere Stellenangebote">
        <Head>
            <title>Ihre Karriere bei FDBS</title>
        </Head>

        <div class="wrapper">
            <Card cover new-window aspect-ratio="16/9" primary-tag="Vollzeit" :tags="['m/w/d']"
                name="Mitarbeiter(in) im Vertriebsinnendienst"
                image="/images/karriere/Innendienst_308824031.jpg"
                link="/downloads/karriere/Vertriebsinnendienst.pdf"/>

            <Card cover new-window aspect-ratio="16/9" primary-tag="Vollzeit" :tags="['m/w/d']"
                name="LKW-Fahrer"
                image="/images/karriere/kraftfahrer_275535330.jpeg"
                link="/downloads/karriere/Kraftfahrer.pdf"/>
                
            <Card cover new-window aspect-ratio="16/9" primary-tag="Vollzeit" :tags="['m/w/d']"
                name="Vertriebsmitarbeiter für Gastronomie & Hotellerie im Außendienst"
                image="/images/karriere/vertrieb_124242186.jpeg"
                link="/downloads/karriere/Vertriebsaussendienst.pdf"/>
                
            <Card cover new-window aspect-ratio="16/9" primary-tag="Vollzeit" :tags="['m/w/d']"
                name="Fachkraft für Lagerlogistik"
                image="/images/karriere/lagerlogistik_315564208.jpeg"
                link="/downloads/karriere/Fachkraft_Lagerlogistik.pdf"/>
                
            <Card cover new-window aspect-ratio="16/9" primary-tag="Vollzeit" :tags="['m/w/d']"
                name="Metallbauer als Servicetechniker"
                image="/images/karriere/mechatronik_50771204.jpg"
                link="/downloads/karriere/Metallbauer.pdf"/>
                
            <Card cover new-window aspect-ratio="16/9" primary-tag="Vollzeit" :tags="['m/w/d']"
                name="Elektromonteur als Servicetechniker"
                image="/images/karriere/elektromeister_251700495.jpeg"
                link="/downloads/karriere/Elektromonteur.pdf"/>
                
            <!-- <Card cover new-window aspect-ratio="16/9" primary-tag="Vollzeit" :tags="['m/w/d']"
                name="Mediengestalter"
                image="/images/karriere/marketing_299897089.jpeg"
                link="/downloads/karriere/Mediengestalter.pdf"/>
                
            <Card cover new-window aspect-ratio="16/9" primary-tag="Vollzeit" :tags="['m/w/d']"
                name="Gestaltungstechnischer Assistent"
                image="/images/karriere/marketing_299897089.jpeg"
                link="/downloads/karriere/GTA.pdf"/> -->
                
            <Card cover new-window aspect-ratio="16/9" primary-tag="Vollzeit" :tags="['m/w/d', 'Spätschicht']"
                name="Lagermitarbeiter / Kommissionierer"
                image="/images/karriere/Kommissionierer_357276619.jpeg"
                link="/downloads/karriere/Kommissionierer_Spaetschicht.pdf"/>
                
        </div>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import Card from '@/Components/Page/Card.vue'
</script>

<style lang="sass" scoped>
    .wrapper
        display: grid !important
        grid-template-columns: repeat(3, 1fr)
        gap: 3rem



    @media only screen and (max-width: 1000px)
        .wrapper
            grid-template-columns: repeat(2, 1fr)



    @media only screen and (max-width: 700px)
        .wrapper
            grid-template-columns: repeat(1, 1fr)
</style>