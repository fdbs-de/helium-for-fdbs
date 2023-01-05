<template>
    <Head title="Unsere aktuellen Angebote" />

    <DashboardSubLayout title="Angebote" area="Kundenbereich">
        <div class="card notification" v-if="!$page.props.auth.user.settings_object['newsletter.subscribed.customer']">
            <div class="text">
                <h2>Unser Kunden Newsletter</h2>
                <p>
                    Bekommen Sie unsere aktuellen Angebote direkt in Ihr Email-Postfach
                </p>
            </div>
            
            <mui-button class="button" label="Kostenfrei abonnieren" @click="setNewsletter('customer', true)"/>
        </div>

        <div class="grid">
            <Card v-for="angebot in angebote" new-window
                :key="angebot.id"
                :name="angebot.name"
                :alt="angebot.cover_alt"
                :cover="angebot.cover_size === 'cover'"
                :image="route('docs.cover', angebot.slug)"
                :link="route('docs', angebot.slug)"
            />
        </div>

        <small class="margin-top-3" v-if="$page.props.auth.user.settings_object['newsletter.subscribed.customer']">
            Sie sind für unseren Kunden Newsletter angemeldet.
            Sie können ihn <Link :href="route('dashboard.profile')" @click.prevent="setNewsletter('customer', false)">hier abbestellen</Link>.
        </small>
    </DashboardSubLayout>
</template>

<script setup>
    import { Head, Link, usePage, useForm } from '@inertiajs/inertia-vue3'
    import { computed } from 'vue'

    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
    import Card from '@/Components/Page/Card.vue'

    defineProps({
        angebote: Array,
    })



    // START: Newsletter
    const setNewsletter = (newsletter, value) => {
        useForm({
            newsletter,
            value,
        }).put(route('dashboard.newsletter.update'))
    }
    // END: Newsletter
</script>

<style lang="sass" scoped>
    .card
        background: var(--color-background)
        border-radius: var(--radius-m)
        box-shadow: var(--shadow-elevation-low)

        &.notification
            border-radius: var(--radius-l)
            display: flex
            align-items: center
            flex-wrap: wrap
            gap: 2rem
            background: var(--color-background)
            padding: 2rem
            margin-bottom: 2rem
            border: 3px solid var(--color-info)

            .text
                flex: 1
                display: flex
                flex-direction: column
                gap: .5rem
                min-width: 260px

                h2
                    font-size: 1.5rem
                    font-weight: 500
                    margin: 0
                    color: var(--color-info)

                p
                    margin: 0

            .button
                white-space: nowrap
                --primary: var(--color-info) !important
                --primary-contrast: var(--color-background) !important

    .grid
        display: grid
        gap: 1rem
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr))
</style>