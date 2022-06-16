<template>
    <TextSubLayout title="Unsere Stellenangebote">
        <Head>
            <title>Ihre Karriere bei FDBS</title>
        </Head>

        <div class="wrapper">
            <JobCard name="Assistentin(en) der Vertriebsleitung" image="/images/karriere/vertrieb_124242186.jpeg" link="/images/karriere/Assistent_Vertrieb.pdf" />
            <JobCard name="Lagerleiter / Logistikleiter" image="/images/karriere/lagerlogistik_315564208.jpeg" link="/images/karriere/Lagerleiter.pdf" />
            <JobCard name="LKW-Fahrer" image="/images/karriere/kraftfahrer_275535330.jpeg" link="/images/karriere/Kraftfahrer.pdf" />
            <JobCard name="Vertriebsmitarbeiter für Gastronomie & Hotellerie im Außendienst" image="/images/karriere/vertrieb_124242186.jpeg" link="/images/karriere/Vertriebsaussendienst.pdf" />
            <JobCard name="Fachkraft für Lagerlogistik" image="/images/karriere/lagerlogistik_315564208.jpeg" link="/images/karriere/Fachkraft_Lagerlogistik.pdf" />
            <JobCard name="Metallbauer als Servicetechniker" image="/images/karriere/mechatronik_50771204.jpg" link="/images/karriere/Metallbauer.pdf" />
            <JobCard name="Elektromonteur als Servicetechniker" image="/images/karriere/elektromeister_251700495.jpeg" link="/images/karriere/Elektromonteur.pdf" />
            <JobCard name="Mediengestalter" image="/images/karriere/marketing_299897089.jpeg" link="/images/karriere/Mediengestalter.pdf" />
            <JobCard name="Gestaltungstechnischer Assistent" image="/images/karriere/marketing_299897089.jpeg" link="/images/karriere/GTA.pdf" />
            <JobCard name="Lagermitarbeiter / Kommissionierer" image="/images/karriere/Kommissionierer_357276619.jpeg" link="/images/karriere/Kommissionierer.pdf" />
        </div>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import JobCard from '@/Components/Page/JobCard.vue'
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