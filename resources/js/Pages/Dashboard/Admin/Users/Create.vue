<template>
    <Head title="Nutzer verwalten" />

    <AdminLayout :title="user.name" :backlink="route('dashboard.admin.users')" backlink-text="Zurück zur Übersicht">
        <div class="card flex vertical gap-1 padding-1 margin-bottom-2">
            <div class="flex v-center gap-1">
                <mui-button label="Freigeben" icon-left="check_circle" color="success" v-if="!user.is_enabled" />
                <mui-button label="Sperren" icon-left="block" color="error" v-else />
                <div class="spacer"></div>
                <mui-button class="header-button" v-if="form.id" label="Nutzer Speichern" :loading="form.processing" @click="saveItem()"/>
                <mui-button class="header-button" v-else label="Nutzer erstellen" :loading="form.processing" @click="saveItem()"/>
            </div>

            <div class="limiter text-limiter flex vertical gap-2">
                <div class="popup-block popup-error" v-if="hasErrors">
                    <h3><b>Fehler!</b></h3>
                    <p v-for="(error, key) in errors" :key="key">{{ error }}</p>
                </div>

                <fieldset class="flex vertical gap-1">
                    <legend>Allgemeines</legend>
                    <mui-input v-model="user.name" disabled label="Anzeigename"/>
                    <mui-input type="email" v-model="form.email" label="Email">
                        <template #right>
                            <IconButton icon="check_circle" :class="{'active': form.email_verified_at}"/>
                        </template>
                    </mui-input>
                    <mui-input type="password" label="Passwort" no-border show-password-score v-model="form.password"/>
                </fieldset>
                
                <fieldset class="flex vertical gap-1">
                    <legend>Kundenprofil</legend>
                    <mui-input v-model="form.profiles.customer.company" label="Firmenname" />
                    <mui-input v-model="form.profiles.customer.customer_id" label="Kundennummer" />
                </fieldset>

                <fieldset class="flex vertical gap-1">
                    <legend>Mitarbeiterprofil</legend>
                    <mui-input v-model="form.profiles.employee.first_name" label="Vorname" />
                    <mui-input v-model="form.profiles.employee.last_name" label="Nachname" />
                </fieldset>

                <fieldset class="flex vertical gap-1">
                    <legend>Berechtigungen</legend>
                    <mui-toggle v-for="role in roles" :key="role.id" :label="role.name" :modelValue="form.roles.includes(role.name)"/>
                </fieldset>

                <fieldset class="flex vertical gap-1">
                    <legend>Newsletter</legend>
                    <mui-toggle type="switch" label="Allgemeiner Newsletter" @v-model="form.newsletter.generic"/>
                    <mui-toggle type="switch" label="Kunden Newsletter" @v-model="form.newsletter.customer"/>
                </fieldset>
            </div>
        </div>
        
        <div class="flex v-center gap-1 border-top padding-top-1">
            <small>
                UserID
                <b>{{user.id}}</b>
            </small>

            <small v-tooltip="$dayjs(user.created_at).format('DD.MM.YYYY - HH:mm')">
                Erstellt
                <b>{{$dayjs(user.created_at).format('DD.MM.YYYY')}}</b>
            </small>

            <small v-tooltip="$dayjs(user.email_verified_at).format('DD.MM.YYYY - HH:mm')" v-if="user.email_verified_at">
                Bestätigt
                <b>{{$dayjs(user.email_verified_at).format('DD.MM.YYYY')}}</b>
            </small>

            <small v-tooltip="$dayjs(user.enabled_at).format('DD.MM.YYYY - HH:mm')" v-if="user.enabled_at">
                Freigegeben
                <b>{{$dayjs(user.enabled_at).format('DD.MM.YYYY')}}</b>
            </small>
        </div>
    </AdminLayout>
</template>

<script setup>
    import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { ref, computed, watch } from 'vue'
    import zxcvbn from 'zxcvbn'

    import AdminLayout from '@/Layouts/Admin.vue'
    import Switcher from '@/Components/Form/Switcher.vue'
    import IconButton from '@/Components/Form/IconButton.vue'

    window.zxcvbn = zxcvbn

    const props = defineProps({
        user: Object,
        roles: Array,
    })



    const form = useForm({
        id: null,
        email: '',
        password: '',
        enabled_at: null,
        email_verified_at: null,
        profiles: {
            customer: {
                has_customer_profile: false,
                company: '',
                customer_id: '',
            },
            employee: {
                has_employee_profile: false,
                first_name: '',
                last_name: '',
            },
        },
        roles: [],
        newsletter: {
            generic: false,
            customer: false,
        }
    })



    const openItem = () => {
        form.id = props.user.id
        form.email = props.user.email
        form.password = ''
        form.enabled_at = props.user.enabled_at
        form.email_verified_at = props.user.email_verified_at

        form.profiles.customer.has_customer_profile = !!props.user.profiles.customer
        form.profiles.customer.company = props.user.profiles?.customer?.company || ''
        form.profiles.customer.customer_id = props.user.profiles?.customer?.customer_id || ''

        form.profiles.employee.has_employee_profile = !!props.user.profiles.employee
        form.profiles.employee.first_name = props.user.profiles?.employee?.first_name || ''
        form.profiles.employee.last_name = props.user.profiles?.employee?.first_name || ''

        form.roles = props.user.roles?.map(e => e.name)

        form.newsletter.generic = props.user.settings_object['newsletter.subscribed.generic'] || false
        form.newsletter.customer = props.user.settings_object['newsletter.subscribed.customer'] || false
    }

    watch((props) => props?.user, () => {
        openItem(props?.user)
    },{
        immediate: true,
        deep: true
    })


    
    
    // START: Error Handling
    const errors = computed(() => usePage().props.value.errors)
    const hasErrors = computed(() => Object.keys(errors.value).length > 0)
    // END: Error Handling
</script>

<style lang="sass" scoped>
    .card
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-m)

    .user-popup
        .popup-row
            display: flex
            align-items: center
            width: 100%
            gap: var(--su)

            &.fixed-height
                min-height: 5rem

            .spacer
                flex: 1

            i
                opacity: .7

        .button-group
            display: flex
            flex-direction: column
            gap: 2px

            > button
                width: 100%
                border-radius: .2rem

                &:first-child
                    border-top-left-radius: .5rem
                    border-top-right-radius: .5rem

                &:last-child
                    border-bottom-left-radius: .5rem
                    border-bottom-right-radius: .5rem

        .popup-block
            display: flex
            flex-direction: column
            padding: var(--su)
            border-radius: .2rem
            background: var(--color-background)
            margin-bottom: 3px

            &.popup-error
                padding: var(--su)
                background: var(--color-red)
                color: var(--color-background)
                border-radius: .5rem
                margin-bottom: var(--su)

                h3,
                p
                    color: inherit
                    margin: 0

            &.popup-head
                padding: var(--su)
                background: var(--color-primary)
                border-radius: .5rem .5rem .2rem .2rem
                color: var(--color-background)

                --primary: var(--color-background)
                --primary-contrast: var(--color-primary)

                h3,
                p
                    width: 100%
                    overflow: hidden
                    text-overflow: ellipsis
                    white-space: nowrap
                    margin: 0
                    color: inherit

                p
                    opacity: .8

            &.popup-tags
                background: var(--color-background-soft)

                .tag
                    padding: 0 1rem
                    border-radius: 30px
                    height: 30px
                    background: var(--color-background)
                    box-shadow: var(--shadow-elevation-low)

                    &.clickable
                        cursor: pointer

                    &::after
                        opacity: 0

                    &.clickable:hover::after
                        opacity: .1

                    &.active
                        background: var(--color-primary)
                        color: var(--color-background)

            &.popup-footer
                padding: .75rem var(--su)
                background: var(--color-background)
                border-radius: .2rem .2rem .5rem .5rem
                margin-bottom: 0

                p
                    margin: 0
                    font-size: .8rem
</style>