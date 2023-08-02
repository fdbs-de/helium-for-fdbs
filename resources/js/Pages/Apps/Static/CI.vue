<template>
    <TextSubLayout title="CI / Styleguide" has-small-limiter>
        <Head>
            <title>CI / Styleguide – FDBS</title>
        </Head>

        <h2>Logos & Icons</h2>
        <h3>Schutzzone</h3>
        <p>
            Die Schutzzone beträgt um das Logo herum
            immer die Hälfte der Versalhöhe.
            Der Objektrahmen ist entsprechend angelegt
            und beizubehalten und nicht zu verändern!
        </p>
        <p>
            Die Schutzzone um das Icon
            beträgt 1/4 der Logobreite.
            Der Objektrahmen ist auch
            hier beizubehalten.
        </p>
        <h3>Claim</h3>
        <p>
            Wird der Claim neben dem Logo eingesetzt,
            ist dieses an die Schutzzone angrenzend und auf
            Höhe der Schriftlinie zu platzieren.
            Die Schriftgröße wird so gewählt, dass der
            Schriftzug der Breite des Logos inkl. Icon
            entspricht.
        </p>
        <h3>Positionierung</h3>
        <p>
            Das Logo wird, sofern nicht anders besprochen, immer oben links platziert.
            Hierbei wird die Schutzzone beibehalten.
            Bei Geschäftsdrucksachen gilt eine Schutzzone von einer ganzen
            Versalhöhe links und oben.
        </p>

        
        <p>&nbsp;</p>
        <h2>Farbwerte & Farbverwendung</h2>

        
        <p>&nbsp;</p>
        <h2>Schriften</h2>
        <h3>Überschrift » <b>Sofia Pro</b></h3>
        <p>
            <b>Beispieltext</b><br>
            <span style="color: var(--color-heading); font-family: 'Sofia Pro'">Franz jagt im komplett verwahrlosten Taxi quer durch Bayern</span>
        </p>

        <h3>Fließtext » <b>Proxima Nova</b></h3>
        <p>
            <b>Beispieltext</b><br>
            <span style="color: var(--color-text); font-family: 'Proxima Nova'">Franz jagt im komplett verwahrlosten Taxi quer durch Bayern</span>
        </p>
        
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
</script>