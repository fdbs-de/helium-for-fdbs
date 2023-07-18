<template>
    <Head title="Profil" />

    <DashboardSubLayout title="Übersicht">
        <div class="card notification" v-if="$page.props.auth.user.profiles.employee && isInviteStillValid && !$page.props.auth.user.settings_object['invite.employee.sommerfest']">
            <div class="wrapper">
                <div class="flex vertical gap-1 w-100 flex-1">
                    <h2>Unser Sommerfest</h2>
                    <p>Nimm an unserem Sommerfest teil. Anmeldeschluss ist der 01.09.</p>
                </div>
    
                <div class="flex vertical gap-1 w-100">
                    <mui-button class="w-100 button" type="button" size="large" icon-left="thumb_down" color="error" label="Nicht teilnehmen" @click="setInvite('sommerfest', 'no')"/>
                    <mui-button class="w-100 button" type="button" size="large" icon-left="thumb_up" color="info" label="Teilnehmen" @click="setInvite('sommerfest', 'yes')"/>
                </div>
            </div>
        </div>

        <div class="welcome-wrapper">
            <h1 class="margin-top-0">Hey! 👋</h1>
            <p>
                Herzlich willkommen im neuen Loginbereich vom FDBS.<br>
                Im Loginbereich können Sie auf die Spezi-Datenbank zugreifen,<br>
                Informationen im Intranet nachlesen, unsere aktuellsten Angebote durchstöbern und vieles mehr.
            </p>
        </div>

        <template v-if="$page.props.auth.user.profiles.employee && isInviteStillValid">
            <small v-if="$page.props.auth.user.settings_object['invite.employee.sommerfest'] == 'yes'">
                Du hast dich für unser Sommerfest angemeldet.
                <Link href="#" @click.prevent="setInvite('sommerfest', 'no')">Stornieren</Link>.
            </small>
    
            <small v-if="$page.props.auth.user.settings_object['invite.employee.sommerfest'] == 'no'">
                Du möchtest nicht zurzeit nicht an unserem Sommerfest teilnehmen.
                <Link href="#" @click.prevent="setInvite('sommerfest', 'yes')">Jetzt teilnehmen</Link>.
            </small>
        </template>
    </DashboardSubLayout>
</template>

<script setup>
    import { Link, Head, useForm } from '@inertiajs/inertia-vue3'
    import { computed } from 'vue'
    import dayjs from 'dayjs'
    
    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'



    // START: Invite
    const setInvite = (invite, value) => {
        useForm({
            invite,
            value,
        }).put(route('dashboard.invite.update'))
    }

    // Show invite until 1. of September 2023
    const isInviteStillValid = computed(() => {
        return dayjs().isBefore('2023-09-01')
    })
    // END: Invite
</script>

<style lang="sass" scoped>
    .card
        background: var(--color-background)
        border-radius: var(--radius-m)
        box-shadow: var(--shadow-elevation-medium)

        &.notification
            border-radius: var(--radius-l)
            overflow: hidden
            display: flex
            align-items: center
            flex-wrap: wrap
            gap: 2rem
            background: var(--color-background)
            background-image: url('/images/content/sommerfest.jpg')
            background-size: cover
            background-position: center
            background-repeat: no-repeat
            margin-bottom: 2rem

            .wrapper
                flex: 1
                display: flex
                flex-direction: column
                gap: 2rem
                max-width: 400px
                width: 100%
                min-height: 520px
                padding: 2rem
                background: #00000040
                backdrop-filter: blur(20px)
                border-right: 1px solid #00000040

            h2
                font-size: 2rem
                font-weight: 500
                margin: 0
                color: var(--color-background)

            p
                margin: 0
                color: var(--color-background-soft)

            .button
                white-space: nowrap

    .welcome-wrapper
        margin-bottom: 2rem
        padding: 2rem
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-xl)

        h1
            font-size: 4rem
            margin: 0
            font-weight: 700

    

    @media only screen and (max-width: 500px)
        .card
            &.notification
                flex-direction: column
                align-items: stretch

                .wrapper
                    border-right: none
                    border-top: 1px solid #00000040
                    padding: 2rem
                    max-width: 100%
                    min-height: 0
                    flex: 1
                    margin-top: 200px
</style>