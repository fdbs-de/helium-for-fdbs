<template>
    <GuestLayout>
        <Head>
            <title>Kontakt</title>
        </Head>

        <main>
            <section id="hero-section">
                <h1>Kontakt</h1>
            </section>

            <section id="form-section">
                <form @submit.prevent>
                    <h2 class="no-margin">Kontaktformular</h2>

                    <ValidationErrors />

                    <mui-input type="text" no-border label="Ihr Name" required autocomplete="name"/>
                    <mui-input type="email" no-border label="Ihre Email" required autocomplete="email"/>
                    <mui-input type="textarea" class="textarea" no-border label="Nachricht" required autocomplete="message"/>

                    <div class="flex center">
                        <mui-toggle type="checkbox" class="checkbox" no-border>
                            <template #appendLabel>
                                <span>
                                    Ich habe die <a target="_blank" :href="route('datenschutz')">Datenschutzerklärung</a> gelesen und akzeptiere diese.
                                </span>
                            </template>
                        </mui-toggle>
                        <div class="spacer"></div>
                        <mui-button type="submit" label="Absenden" :loading="false"/>
                    </div>
                </form>
            </section>

            <section id="content-section">
                <div class="limiter">
                </div>
            </section>
        </main>
    </GuestLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3'
import GuestLayout from '@/Layouts/Guest.vue'
import ValidationErrors from '@/Components/ValidationErrors.vue'
</script>

<style lang="sass" scoped>
    #hero-section
        display: flex
        align-items: center
        justify-content: center
        margin-top: var(--height-header)
        padding-bottom: var(--height-header)
        height: calc(350px + var(--height-header))
        background: var(--color-background-soft)

        h1
            color: var(--color-primary)

    #form-section
        form
            width: 100%
            max-width: 500px
            margin: 0 auto var(--height-header)
            transform: translateY(calc(-1 * var(--height-header)))
            padding: calc(var(--su) * 2)
            gap: calc(var(--su) * 2)
            background: var(--color-background)
            border-radius: calc(var(--su) * .75)
            box-shadow: var(--shadow-elevation-low)
            display: flex
            flex-direction: column

            --mui-background: var(--color-background-soft)

            .checkbox
                --mui-background: var(--color-background)

            .textarea
                --base-height: 10rem

    @media only screen and (max-width: 500px)
        #hero-section
            padding-bottom: 0
            height: 250px

        #form-section
            form
                border-radius: 0
                box-shadow: none
                margin-bottom: calc(var(--su) * 2)
                transform: none
                padding-inline: var(--su)
                gap: calc(var(--su) * 1.25)
</style>