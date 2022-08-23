<template>
    <Head>
        <title>FDBS als Arbeitgeber</title>
    </Head>

    <TextSubLayout title="FDBS als Arbeitgeber">
        <div class="limiter text-limiter" style="padding: 0">
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Magni ut quas velit beatae, atque repellat iste facilis necessitatibus officiis!
                Qui nemo omnis voluptates illum architecto eum minus at earum velit!
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Magni ut quas velit beatae, atque repellat iste facilis necessitatibus officiis!
                Qui nemo omnis voluptates illum architecto eum minus at earum velit!
            </p>
        </div>
        <div class="flex wrap gap-3 margin-block-8 v-center">
            <SpecCard class="flex-1" spec="100+" subtitle="Mitarbeiter"/>
            <SpecCard class="flex-1" spec="650+" subtitle="Kunden"/>
            <SpecCard class="flex-1" spec="15.000+" subtitle="Artikel"/>
            <SpecCard class="flex-1" spec="namhafte" subtitle="Lieferanten & Partner"/>
        </div>
        <div class="limiter text-limiter">
            <h2>Zufriedenheit schafft Motivation</h2>
            <p>FDBS bietet seinen Mitarbeitern weit mehr als ein gutes Gehalt. Bei uns wird Ihnen ein moderner Arbeitsplatz in lichtdurchfluteten Räumen zur Verfügung gestellt. Sie arbeiten in einem Team mit freundlichen und motivierten Kollegen und erhalten die Möglichkeit, sich nach Ihren Fähigkeiten individuell zu entwickeln.</p>
            <p>FDBS fördert seine Mitarbeiter mit individuellen Fort- und Weiterbildungsmaßen. So kann jeder Mitarbeiter seine Talente entfalten und sein Können ausbauen.</p>
            <p>Die flachen Hierarchien ermöglichen kurze Entscheidungswege. Diese Organisationsstruktur schafft die Voraussetzung für viele Freiräume der Mitarbeiter. Zudem werden die Eigeninitiative und -verantwortung der Mitarbeiter gefördert.</p>
            <p>Durch das angenehme Betriebsklima können sich die Mitarbeiter mit unserem Unternehmen identifizieren. Das trägt neben den anderen Faktoren maßgeblich zur Motivation bei.</p>
        </div>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import SpecCard from '@/Components/Page/SpecCard.vue'
</script>