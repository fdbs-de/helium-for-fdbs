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
        <Benefits />
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import SpecCard from '@/Components/Page/SpecCard.vue'
    import Benefits from '@/Components/Page/Karriere/Benefits.vue'
</script>