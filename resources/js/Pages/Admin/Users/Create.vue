<template>
    <AdminLayout :title="form.id ? 'Account bearbeiten' : 'Account erstellen'" sticky>
        <template #header-left>
            <IodButton label="Zurück" variant="contained" size="small" :loading="form.processing" is="a" :href="route('admin.users')" v-tooltip="'Zurück zur Übersicht'"/>
        </template>

        <template #header-right>
            <IodButton label="Speichern" variant="filled" size="small" :loading="form.processing" @click="saveItem()" v-tooltip.bottom="'(STRG+S zum Speichern)'"/>
        </template>

        <div class="card flex vertical gap-1 padding-block-2 margin-bottom-2">
            <form class="limiter text-limiter" @submit.prevent="saveItem()">
                <div class="flex vertical gap-4">
                    <ValidationErrors />
                    
                    <fieldset class="flex vertical gap-1">
                        <legend>Allgemeines</legend>
                        <IodInput type="text" v-model="form.username" label="Username"/>
                        <IodInput type="email" v-model="form.email" label="Email" :helper="domainMatch && !!user.email_verified_at ? 'Dieser Nutzer hat eine Domain-Email-Adresse' : null"/>
                        <IodInput type="password" label="Passwort setzen" autocomplete="new-password" no-border show-password-score :password-score-function="zxcvbn" v-model="form.password"/>
                        
                        <hr>

                        <div class="flex v-center gap-1 wrap">
                            <IodToggle class="flex-1 background-soft" label="Email verifiziert" :modelValue="!!form.email_verified_at" @update:modelValue="form.email_verified_at = $event ? new Date() : null "/>
                            <IodToggle class="flex-1 background-soft" label="Freigegeben" :modelValue="!!form.enabled_at" @update:modelValue="form.enabled_at = $event ? new Date() : null "/>
                        </div>
                        
                        <Alert type="warning" title="Email ist nicht verifiziert" v-if="!!form.enabled_at && !user.email_verified_at">
                            <p>
                                Der Nutzer hat seine Email noch nicht bestätigt.<br>
                                Vorsicht bei der Freischaltung – es kann sich um einen <b>Bot oder Spam-Account</b> handeln!
                            </p>
                        </Alert>
                    </fieldset>
                    


                    <fieldset class="flex vertical gap-1">
                        <legend>
                            <IodToggle type="switch" label="Kundenprofil" v-model="form.profiles.customer.has_customer_profile"/>
                        </legend>

                        <template v-if="form.profiles.customer.has_customer_profile">
                            <IodInput v-model="form.profiles.customer.company" label="Firmenname" />
                            <IodInput v-model="form.profiles.customer.customer_id" label="Kundennummer" />
                        </template>

                        <span class="flex v-center h-center h-4" v-else>
                            Kein Kundenprofil angelegt
                        </span>
                    </fieldset>
    

                    
                    <fieldset class="flex vertical gap-1">
                        <legend>
                            <IodToggle type="switch" label="Mitarbeiterprofil" v-model="form.profiles.employee.has_employee_profile"/>
                        </legend>

                        <template v-if="form.profiles.employee.has_employee_profile">
                            <IodInput v-model="form.profiles.employee.first_name" label="Vorname" />
                            <IodInput v-model="form.profiles.employee.last_name" label="Nachname" />
                        </template>

                        <span class="flex v-center h-center h-4" v-else>
                            Kein Mitarbeiterprofil angelegt
                        </span>
                    </fieldset>
    
                    <fieldset class="flex vertical gap-1">
                        <legend>Rollen</legend>
                        <div class="flex gap-1 wrap">
                            <IodToggle class="background-soft"
                                v-for="role in roles"
                                :key="role.id"
                                :label="role.name"
                                :modelValue="form.roles.includes(role.id)"
                                @update:modelValue="toggleRole(role.id)"
                            />
                        </div>
                    </fieldset>
    
                    <fieldset class="flex vertical gap-1">
                        <legend>Benachrichtigungen</legend>
                        <IodToggle class="background-soft" label="Allgemeiner Newsletter" v-model="form.newsletter.generic"/>
                        <IodToggle class="background-soft" label="Kunden Newsletter" v-model="form.newsletter.customer"/>
                    </fieldset>
    
                    <fieldset class="flex vertical gap-1">
                        <legend>Info</legend>
                        <span>
                            Kennt uns durch:<br>
                            <b v-if="user.settings_object.referal">{{user.settings_object.referal.join(', ')}}</b>
                            <i v-else>Nicht Angegeben</i>
                        </span>
                    </fieldset>
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
    import { useForm, usePage } from '@inertiajs/inertia-vue3'
    import hotkeys from 'hotkeys-js'
    import { computed, watch } from 'vue'
    import zxcvbn from 'zxcvbn'

    import AdminLayout from '@/Layouts/Admin.vue'
    import Alert from '@/Components/Alert.vue'
    import ValidationErrors from '@/Components/ValidationErrors.vue'



    hotkeys('ctrl+s', (event, handler) => { event.preventDefault(); saveItem() })



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
        let siteDomain = usePage()?.props?.value?.settings['site.domain'] || null

        if (!siteDomain) return false

        return props.user?.email?.endsWith('@' + siteDomain)
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