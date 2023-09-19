<template>
    <DashboardSubLayout title="Angebote">
        <div class="card notification" v-if="!$page.props.auth.user.settings_object['newsletter.subscribed.customer']">
            <div class="text">
                <h2>Unser Kunden Newsletter</h2>
                <p>Bekommen Sie unsere aktuellen Angebote direkt in Ihr Email-Postfach</p>
            </div>
            
            <mui-button class="button" label="Kostenfrei abonnieren" @click="setNewsletter('customer', true)"/>
        </div>
        
        <DownloadManager class="card" media-id="248" layout="grid"/>

        <small class="margin-top-3" v-if="$page.props.auth.user.settings_object['newsletter.subscribed.customer']">
            Sie sind für unseren Kunden Newsletter angemeldet.
            Sie können ihn <Link :href="route('dashboard.profile')" @click.prevent="setNewsletter('customer', false)">hier abbestellen</Link>.
        </small>
    </DashboardSubLayout>
</template>

<script setup>
    import { Link, useForm } from '@inertiajs/inertia-vue3'

    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
    import DownloadManager from '@/Pages/Apps/Pages/Partials/DownloadManager.vue'



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
        border-radius: var(--radius-m)
        border: 1px solid var(--color-border)

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
</style>