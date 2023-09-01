<template>
    <TextSubLayout title="CI / Styleguide" has-small-limiter>
        <Head>
            <title>CI / Styleguide – FDBS</title>
        </Head>

        <h2>Logos & Icons</h2>
        <div class="flex gap-2 wrap margin-bottom-6">
            <div class="flex-3 card image-card">
                <div class="heading">
                    <div class="title">FDBS Logo</div>
                </div>
                <div class="image-container">
                    <img src="/images/content/ci/logo_spacing.png" class="image">
                </div>
            </div>

            <div class="flex-2 card image-card">
                <div class="heading">
                    <div class="title">FDBS Icon</div>
                </div>
                <div class="image-container">
                    <img src="/images/content/ci/icon_spacing.png" class="image">
                </div>
            </div>
        </div>

        <h3>Schutzzone</h3>
        <div class="flex gap-2 wrap margin-bottom-6">
            <div class="flex-3 card image-card">
                <div class="image-container margin-top-1">
                    <img src="/images/content/ci/logo_spacing_markings.png" class="image">
                </div>
                <div class="note">
                    Die Schutzzone beträgt um das Logo herum
                    immer die Hälfte der Versalhöhe.
                    Der Objektrahmen ist entsprechend angelegt
                    und beizubehalten und <b>nicht</b> zu verändern!
                </div>
            </div>

            <div class="flex-2 card image-card">
                <div class="image-container margin-top-1">
                    <img src="/images/content/ci/icon_spacing_markings.png" class="image">
                </div>
                <div class="note">
                    Die Schutzzone um das Icon
                    beträgt 1/4 der Logobreite.
                    Der Objektrahmen ist auch
                    hier beizubehalten.
                </div>
            </div>
        </div>



        <h3>Claim</h3>
        <div class="flex gap-2 wrap margin-bottom-6">
            <div class="flex-2 card image-card">
                <div class="image-container margin-top-1">
                    <img src="/images/content/ci/claim_spacing_markings.png" class="image">
                </div>
                <div class="note">
                    Wird der Claim neben dem Logo eingesetzt,
                    ist dieses an die Schutzzone angrenzend und auf
                    Höhe der Schriftlinie zu platzieren.
                    Die Schriftgröße wird so gewählt, dass der
                    Schriftzug der Breite des Logos inkl. Icon
                    entspricht.
                </div>
            </div>
        </div>



        <h3>Positionierung</h3>
        <div class="flex gap-2 wrap margin-bottom-6">
            <div class="flex-2 card image-card">
                <div class="image-container ar-3-2 margin-top-1">
                    <img src="/images/content/ci/positioning.png" class="image">
                </div>
                <div class="note">
                    Das Logo wird, sofern nicht anders besprochen, immer oben links platziert.
                    Hierbei wird die Schutzzone beibehalten.
                    Bei Geschäftsdrucksachen gilt eine Schutzzone von einer ganzen
                    Versalhöhe links und oben.
                </div>
            </div>
        </div>


        
        <p>&nbsp;</p>
        <h2>Farbwerte & Farbverwendung</h2>
        <div class="flex gap-2">
            <div class="card flex-1 color-card">
                <div class="heading">
                    <div class="title">FDBS Rot</div>
                    <div class="subtitle">HKS 23 K</div>
                </div>
                <div class="color" style="background: #E00047;"></div>
                <div class="note">
                    FDBS Rot kann als Text-, Überschrift- und Flächenfarbe verwendet werden.<br>
                    Bei der Verwendung als Flächenfarbe ist die Schriftfarbe weiß.
                </div>
                <div class="copy-row">
                    <div class="label">CMYK</div>
                    <div class="value">0 100 70 0</div>
                    <IconButton icon="content_copy" @click="copy('0 100 70 0')"/>
                </div>
                <div class="copy-row">
                    <div class="label">HEX</div>
                    <div class="value">#E00047</div>
                    <IconButton icon="content_copy" @click="copy('#E00047')"/>
                </div>
                <div class="copy-row">
                    <div class="label">RGB</div>
                    <div class="value">224 0 71</div>
                    <IconButton icon="content_copy" @click="copy('224 0 71')"/>
                </div>
                <div class="copy-row">
                    <div class="label">RAL</div>
                    <div class="value">3020</div>
                    <IconButton icon="content_copy" @click="copy('3020')"/>
                </div>
                <div class="copy-row">
                    <div class="label">Pantone</div>
                    <div class="value">192 C</div>
                    <IconButton icon="content_copy" @click="copy('192 C')"/>
                </div>
                <div class="copy-row">
                    <div class="label">ORACAL</div>
                    <div class="value">8500-017</div>
                    <IconButton icon="content_copy" @click="copy('8500-017')"/>
                </div>
                <div class="copy-row">
                    <div class="label">MACAL</div>
                    <div class="value">9859-142 Regal Red</div>
                    <IconButton icon="content_copy" @click="copy('9859-142 Regal Red')"/>
                </div>
            </div>

            <div class="card flex-1 color-card">
                <div class="heading">
                    <div class="title">Schieferstein Grau</div>
                    <div class="subtitle">HKS 93 K</div>
                </div>
                <div class="color" style="background: #364040;"></div>
                <div class="note">
                    Schieferstein Grau kann als Text- und Überschriftfarbe verwendet werden.<br>
                    <b>Die Verwendung als Flächenfarbe ist nicht gestattet.</b>
                </div>
                <div class="copy-row">
                    <div class="label">CMYK</div>
                    <div class="value">25 0 10 80</div>
                    <IconButton icon="content_copy" @click="copy('25 0 10 80')"/>
                </div>
                <div class="copy-row">
                    <div class="label">HEX</div>
                    <div class="value">#364040</div>
                    <IconButton icon="content_copy" @click="copy('#364040')"/>
                </div>
                <div class="copy-row">
                    <div class="label">RGB</div>
                    <div class="value">54 64 64</div>
                    <IconButton icon="content_copy" @click="copy('54 64 64')"/>
                </div>
                <div class="copy-row">
                    <div class="label">RAL</div>
                    <div class="value">7024</div>
                    <IconButton icon="content_copy" @click="copy('7024')"/>
                </div>
                <div class="copy-row">
                    <div class="label">Pantone</div>
                    <div class="value">Cool Gray 11 C</div>
                    <IconButton icon="content_copy" @click="copy('Cool Gray 11 C')"/>
                </div>
                <div class="copy-row">
                    <div class="label">ORACAL</div>
                    <div class="value">–</div>
                </div>
                <div class="copy-row">
                    <div class="label">MACAL</div>
                    <div class="value">9889-117 Mystic Grey</div>
                    <IconButton icon="content_copy" @click="copy('9889-117 Mystic Grey')"/>
                </div>
            </div>
        </div>

        
        <p>&nbsp;</p>
        <h2>Schriften</h2>
        <h3 class="margin-top-2 margin-bottom-0">Überschrift » <b>Sofia Pro</b></h3>
        <div class="flex vertical background-soft padding-1 radius-m margin-top-1 color-heading">
            <span style="font-family: 'Sofia Pro'; font-weight: 400;">Franz jagt im komplett verwahrlosten Taxi quer durch Bayern</span>
            <hr>
            <small>Sofia Pro – Regular (400)</small>
        </div>
        <div class="flex vertical background-soft padding-1 radius-m margin-top-1 color-heading">
            <span style="font-family: 'Sofia Pro'; font-weight: 600;">Franz jagt im komplett verwahrlosten Taxi quer durch Bayern</span>
            <hr>
            <small>Sofia Pro – Semi Bold (600)</small>
        </div>
        <div class="flex vertical background-soft padding-1 radius-m margin-block-1 color-heading">
            <span style="font-family: 'Sofia Pro'; font-weight: 700;">Franz jagt im komplett verwahrlosten Taxi quer durch Bayern</span>
            <hr>
            <small>Sofia Pro – Bold (700)</small>
        </div>
        <span>
            In den Office Anwendungen (Excel, Word, etc.) wird die lizenzfreie Schriftart <a href="https://fonts.google.com/specimen/Poppins" target="_blank"><b>Poppins</b></a> verwendet.
        </span>

        <h3 class="margin-top-6 margin-bottom-0">Fließtext » <b>Proxima Nova</b></h3>
        <div class="flex vertical background-soft padding-1 radius-m margin-top-1 color-heading">
            <span style="font-family: 'Proxima Nova'; font-weight: 400;">Franz jagt im komplett verwahrlosten Taxi quer durch Bayern</span>
            <hr>
            <small>Proxima Nova – Regular (400)</small>
        </div>
        <div class="flex vertical background-soft padding-1 radius-m margin-block-1 color-heading">
            <span style="font-family: 'Proxima Nova'; font-weight: 700;">Franz jagt im komplett verwahrlosten Taxi quer durch Bayern</span>
            <hr>
            <small>Proxima Nova – Bold (700)</small>
        </div>
        <span>
            In den Office Anwendungen (Excel, Word, etc.) wird die lizenzfreie Schriftart <a href="https://fonts.google.com/specimen/Inter" target="_blank"><b>Inter</b></a> verwendet.
        </span>
        
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'

    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import IconButton from '@/Components/Apps/Pages/IconButton.vue'



    // START: Copy to Clipboard
    const copy = (text) => {
        navigator.clipboard.writeText(text)
    }
    // END: Copy to Clipboard
</script>

<style lang="sass" scoped>
    .card
        background: var(--color-background)
        border-radius: var(--radius-m)
        box-shadow: var(--shadow-elevation-low)
        border: 1px solid var(--color-background-soft)
        overflow: hidden

        .heading
            padding: 1rem
            color: var(--color-text)
            font-family: var(--font-heading)

            .title
                font-size: 1.2rem
                font-weight: 600

            .subtitle
                font-size: 1rem
                font-weight: 400

        .note
            padding: 1rem
            border-top: 1px solid var(--color-background-soft)

        .copy-row
            font-size: .8rem
            border-top: 1px solid var(--color-background-soft)
            display: flex
            align-items: center
            padding: 0 1rem
            height: 3.5rem
            gap: 1rem

            .label
                width: 80px

            .value
                flex: 1
                font-weight: 600

        &.color-card
            .color
                width: 100%
                aspect-ratio: 2/1
                border-top: 1px solid var(--color-background-soft)

        &.image-card
            .image-container
                height: 200px
                width: 100%
                padding: 1rem
                display: flex
                align-items: center
                justify-content: center
                background: var(--color-background-soft)
                border-top: 1px solid var(--color-background-soft)
                overflow: hidden

                &.ar-3-2
                    aspect-ratio: 3/2
                    height: auto

                .image
                    max-height: 100%
                    max-width: 100%
                    object-fit: contain
                    background: var(--color-background)
</style>