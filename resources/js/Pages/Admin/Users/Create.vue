<template>
    <Head title="Nutzer verwalten" />

    <AdminLayout :title="user.name" :backlink="route('admin.users')" backlink-text="Zurück zur Übersicht">
        <div class="card flex vertical gap-1 padding-block-2 margin-bottom-2">
            <form class="limiter text-limiter" @submit.prevent="saveItem()">
                <div class="flex vertical gap-4">
                    <div class="popup-block popup-error" v-if="hasErrors">
                        <h3><b>Fehler!</b></h3>
                        <p v-for="(error, key) in errors" :key="key">{{ error }}</p>
                    </div>
                    
                    <fieldset class="flex vertical gap-1">
                        <legend>Allgemeines</legend>
                        <mui-input type="text" v-model="form.username" label="Username"/>
                        <mui-input type="email" v-model="form.email" label="Email"/>
                        <mui-toggle class="checkbox" label="Email freigeschaltet" style="background: var(--color-background-soft)" :modelValue="!!form.email_verified_at" @update:modelValue="form.email_verified_at = $event ? new Date() : null "/>
                        <mui-toggle class="checkbox" style="background: var(--color-background-soft)" :modelValue="!!form.enabled_at" @update:modelValue="form.enabled_at = $event ? new Date() : null ">
                            <template #label>
                                <span>Nutzer freigeschaltet</span><br>
                                <small class="text-green" v-if="domainMatch && !!user.email_verified_at">(Dieser Nutzer hat eine Domain-Email-Adresse)</small>
                            </template>
                        </mui-toggle>
                        
                        <Alert type="warning" title="Email ist nicht verifiziert" v-if="!!form.enabled_at && !user.email_verified_at">
                            <p>
                                Der Nutzer hat seine Email noch nicht bestätigt.<br>
                                Vorsicht bei der Freischaltung – es kann sich um einen <b>Bot oder Spam-Account</b> handeln!
                            </p>
                        </Alert>
    
                        <hr>
                        
                        <mui-input type="password" label="Passwort setzen" no-border show-password-score autocomplete="new-password" v-model="form.password"/>
                    </fieldset>
                    
                    <fieldset class="flex vertical gap-1">
                        <legend>
                            <mui-toggle type="switch" label="Kundenprofil" border v-model="form.profiles.customer.has_customer_profile"/>
                        </legend>
                        <template v-if="form.profiles.customer.has_customer_profile">
                            <mui-input v-model="form.profiles.customer.company" label="Firmenname" />
                            <mui-input v-model="form.profiles.customer.customer_id" label="Kundennummer" />
                        </template>
                        <span class="flex v-center h-center h-4" v-else>
                            Kein Kundenprofil angelegt
                        </span>
                    </fieldset>
    
                    
                    <fieldset class="flex vertical gap-1">
                        <legend>
                            <mui-toggle type="switch" label="Mitarbeiterprofil" border v-model="form.profiles.employee.has_employee_profile"/>
                        </legend>
                        <template v-if="form.profiles.employee.has_employee_profile">
                            <mui-input v-model="form.profiles.employee.first_name" label="Vorname" />
                            <mui-input v-model="form.profiles.employee.last_name" label="Nachname" />
                        </template>
                        <span class="flex v-center h-center h-4" v-else>
                            Kein Mitarbeiterprofil angelegt
                        </span>
                    </fieldset>
    
                    <fieldset class="flex vertical gap-1">
                        <legend>Rollen</legend>
                        <!-- <mui-input type="text" icon-left="search" label="Suchen" />
                        <hr> -->
                        <div class="flex gap-1 wrap">
                            <mui-toggle
                                v-for="role in roles"
                                style="background: var(--color-background-soft)"
                                :key="role.id"
                                :label="role.name"
                                :modelValue="form.roles.includes(role.id)"
                                @update:modelValue="toggleRole(role.id)"
                            />
                        </div>
                    </fieldset>
    
                    <fieldset class="flex vertical gap-1">
                        <legend>Benachrichtigungen</legend>
                        <mui-toggle class="checkbox" label="Allgemeiner Newsletter" style="background: var(--color-background-soft)" @v-model="form.newsletter.generic"/>
                        <mui-toggle class="checkbox" label="Kunden Newsletter" style="background: var(--color-background-soft)" @v-model="form.newsletter.customer"/>
                    </fieldset>
    
                    <fieldset class="flex vertical gap-1">
                        <legend>Info</legend>
                        <span>
                            Kennt uns durch:<br>
                            <b v-if="user.settings_object.referal">{{user.settings_object.referal.join(', ')}}</b>
                            <i v-else>Nicht Angegeben</i>
                        </span>
                    </fieldset>
    
                    <div class="flex v-center gap-1">
                        <div class="spacer"></div>
                        <mui-button class="header-button" v-if="form.id" label="Nutzer Speichern" size="large" :loading="form.processing"/>
                        <mui-button class="header-button" v-else label="Nutzer erstellen" size="large" :loading="form.processing"/>
                    </div>
                </div>
            </form>
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
    import Alert from '@/Components/Alert.vue'

    window.zxcvbn = zxcvbn

    const props = defineProps({
        user: Object,
        roles: Array,
        settings: Object,
    })



    const form = useForm({
        id: null,
        email: '',
        username: '',
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

    const domainMatch = computed(() => {
        if (!props.settings['site.domain']) return false

        return props.user?.email?.endsWith('@' + props.settings['site.domain'])
    })



    const openItem = () => {
        form.id = props.user.id
        form.email = props.user.email || ''
        form.username = props.user.username || ''
        form.password = ''
        form.enabled_at = props.user.enabled_at
        form.email_verified_at = props.user.email_verified_at

        form.profiles.customer.has_customer_profile = !!props.user.profiles.customer
        form.profiles.customer.company = props.user.profiles?.customer?.company || ''
        form.profiles.customer.customer_id = props.user.profiles?.customer?.customer_id || ''

        form.profiles.employee.has_employee_profile = !!props.user.profiles.employee
        form.profiles.employee.first_name = props.user.profiles?.employee?.first_name || ''
        form.profiles.employee.last_name = props.user.profiles?.employee?.last_name || ''

        form.roles = props.user.roles?.map(e => e.id)

        form.newsletter.generic = props.user.settings_object['newsletter.subscribed.generic'] || false
        form.newsletter.customer = props.user.settings_object['newsletter.subscribed.customer'] || false
    }

    watch((props) => props?.user, () => {
        openItem(props?.user)
    },{ immediate: true, deep: true })



    const toggleRole = (role) => {
        if (form.roles.includes(role))
        {
            form.roles = form.roles.filter(e => e !== role)
        }
        else
        {
            form.roles.push(role)
        }
    }



    const saveItem = () => {
        form.id ? updateItem() : storeItem()
    }

    const storeItem = () => {
        form.post(route('admin.users.store'), {
            preserveScroll: true,
            onSuccess: (data) => {
                openItem(data?.props?.post)
            },
        })
    }

    const updateItem = () => {
        form.put(route('admin.users.update', form.id), {
            preserveScroll: true,
            onSuccess: (data) => {
                openItem(data?.props?.post)
            },
        })
    }


    
    
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
            gap: 1rem

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
            padding: 1rem
            border-radius: .2rem
            background: var(--color-background)
            margin-bottom: 3px

            &.popup-error
                padding: 1rem
                background: var(--color-red)
                color: var(--color-background)
                border-radius: .5rem
                margin-bottom: 1rem

                h3,
                p
                    color: inherit
                    margin: 0

            &.popup-head
                padding: 1rem
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
                padding: .75rem 1rem
                background: var(--color-background)
                border-radius: .2rem .2rem .5rem .5rem
                margin-bottom: 0

                p
                    margin: 0
                    font-size: .8rem
</style>