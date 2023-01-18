<template>
    <Head>
        <title>FDBS als Arbeitgeber – FDBS Karriere</title>
    </Head>

    <TextSubLayout title="FDBS als Arbeitgeber" image="/images/content/banner/karriere_513169496_482949832.webp">
        <div class="limiter text-limiter" style="padding: 0">
            <p>
                Stell dir ein Unternehmen vor, in dem deine Arbeit wirklich von Bedeutung ist.
                Ein Ort, an dem du dich nicht nur weiterentwickeln und neue Fähigkeiten erlernen kannst, sondern auch den Kunden hilfst,
                Ihr Geschäft auf das nächste Level zu heben. Das ist FDBS.
                Wir sind ein modernes Unternehmen in der Foodbranche mit dem Ziel, unseren Kunden den bestmöglichen Rundum-Service zu
                bieten.<br><br>
                Dafür stellen wir sicher, dass unseren Mitarbeitern attraktive Arbeitsbedingungen und -perspektiven geboten werden. Wenn
                du also deinen Beitrag leisten möchtest, dann bist du bei uns genau richtig!
                Bewirb dich jetzt und werde Teil eines motivierten, freundlichen Teams! Habe Spaß bei der Arbeit und profitiere von
                einem attraktiven Gehalt und vielen Benefits.<br><br>
            </p>
            <div class="text-align-center">
                <mui-button as="a" :href="route('karriere.stellenangebote')" label="Zu unseren Stellenangeboten"/>
            </div>
        </div>
        
        <div class="flex wrap gap-3 margin-block-8 v-center">
            <SpecCard class="flex-1" animated :spec="100" suffix="+" subtitle="Mitarbeiter"/>
            <SpecCard class="flex-1" animated :spec="650" suffix="+" subtitle="Kunden"/>
            <SpecCard class="flex-1" animated :spec="15000" suffix="+" subtitle="Artikel"/>
            <SpecCard class="flex-1" spec="namhafte" subtitle="Lieferanten & Partner"/>
        </div>

        <Benefits />
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import SpecCard from '@/Components/Page/SpecCard.vue'
    import Benefits from '@/Components/Page/Karriere/Benefits.vue'
</script>