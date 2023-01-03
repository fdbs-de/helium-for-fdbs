<template>
    <Head title="Nutzer verwalten" />

    <AdminLayout :title="user.display_name || user.email" :backlink="route('dashboard.admin.users')" backlink-text="Zurück zur Übersicht">
        <div class="card flex vertical gap-1 padding-1 margin-bottom-2">
            <div class="limiter text-limiter flex vertical gap-1">
                <div class="popup-block popup-error" v-if="hasErrors">
                    <h3><b>Fehler!</b></h3>
                    <p v-for="(error, key) in errors" :key="key">{{ error }}</p>
                </div>
    
                <div class="flex gap-1 wrap v-center radius-m background-soft padding-1">
                    <div class="flex vertical spacer">
                        <b>Account</b>
                        <span>
                            {{user.email}}
                            <small v-if="!user.email_verified_at">(Bestätigung ausstehend)</small>
                        </span>
                        <span class="flex padding-top-1" v-if="user.roles.map(e => e.name).includes('Super Admin')">
                            <Tag>Super Admin</Tag>
                            <div class="spacer"></div>
                        </span>
                    </div>
                    <div class="flex gap-1 v-center">
                        <mui-button label="Freigeben" icon-left="check_circle" color="success" v-if="!user.enabled_at" @click="enableUser()"/>
                        <mui-button label="Sperren" icon-left="block" color="error" v-else @click="disableUser()"/>
                    </div>
                </div>
                
                <div class="flex gap-1 wrap v-center radius-m background-soft padding-1" v-if="user.customer_profile">
                    <div class="flex vertical spacer">
                        <b>Kundenprofil</b>
                        <span>{{user.customer_profile.company}}</span>
                        <span>{{user.customer_profile.customer_id || 'Keine Kundennummer'}}</span>
                    </div>
                    <div class="flex gap-1 v-center">
                        <mui-button label="Freigeben" icon-left="check_circle" color="success" v-if="!user.customer_profile.enabled_at" @click="enableCustomer()"/>
                        <mui-button label="Sperren" icon-left="block" color="error" v-else @click="disableCustomer()"/>
                        <!-- <mui-button label="Löschen" variant="contained" @click="$refs.deleteCustomerPopup.open()"/> -->
                    </div>
                </div>
                
                <div class="flex gap-1 wrap v-center radius-m background-soft padding-1" v-if="user.employee_profile">
                    <div class="flex vertical spacer">
                        <b>Mitarbeiterprofil</b>
                        <span>{{user.employee_profile.first_name}}</span>
                        <span>{{user.employee_profile.last_name}}</span>
                    </div>
                    <div class="flex gap-1 v-center">
                        <mui-button label="Freigeben" icon-left="check_circle" color="success" v-if="!user.employee_profile.enabled_at" @click="enableEmployee()"/>
                        <mui-button label="Sperren" icon-left="block" color="error" v-else @click="disableEmployee()"/>
                        <!-- <mui-button label="Löschen" variant="contained" @click="$refs.deleteEmployeePopup.open()"/> -->
                    </div>
                </div>

                <div class="flex gap-1 wrap vertical radius-m background-soft padding-1">
                    <b>Rollen & Berechtigungen</b>
                    <div class="flex gap-1 wrap v-center">
                        <mui-toggle border label="Admin" :modelValue="user.roles.map(e => e.name).includes('Admin')" @update:modelValue="toggleRole('Admin')"/>
                        <mui-toggle border label="Editor" :modelValue="user.roles.map(e => e.name).includes('Editor')" @update:modelValue="toggleRole('Editor')"/>
                    </div>
                </div>

                <div class="flex gap-1 wrap vertical radius-m background-soft padding-1">
                    <b>Newsletter</b>
                    <div class="flex gap-1 wrap v-center">
                        <mui-toggle type="switch" border label="Allgemeiner Newsletter" :modelValue="userSettings['newsletter.subscribed.generic']" @update:modelValue="setNewsletter('generic', $event)"/>
                        <mui-toggle type="switch" border label="Kunden Newsletter" :modelValue="userSettings['newsletter.subscribed.customer']" @update:modelValue="setNewsletter('customer', $event)"/>
                    </div>
                </div>

                <div class="flex gap-1 wrap vertical radius-m background-soft padding-1">
                    <b>Aktionen</b>
                    <div class="flex gap-1 wrap v-center">
                        <mui-button label="Nutzer Löschen" color="error" @click="$refs.deleteUserPopup.open()" />
                        <div class="spacer"></div>
                        <mui-button label="Passwort ändern" color="info" @click="$refs.changePasswordPopup.open()"/>
                    </div>
                </div>
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



    <Popup ref="changePasswordPopup" title="Passwort ändern">
        <form class="confirm-popup-wrapper" @submit.prevent="changePassword()">
            <mui-input type="password" style="width: 100%" label="Neues Passwort" no-border show-password-score v-model="changePasswordForm.newPassword"/>
            <div class="flex" style="width: 100%">
                <div class="spacer"></div>
                <mui-button type="submit" label="Passwort ändern"/>
            </div>
        </form>
    </Popup>

    <Popup ref="deleteUserPopup" title="Nutzer löschen?">
        <form class="confirm-popup-wrapper" @submit.prevent="deleteUser()">
            <p>Möchten Sie den <b>Nutzer</b> mit der Email <a>{{user.email}}</a> entgültig löschen?</p>
            <div class="confirm-popup-footer">
                <mui-button variant="contained" label="Abbrechen" @click="$refs.deleteUserPopup.close()"/>
                <mui-button type="submit" variant="filled" color="error" label="Entgültig löschen"/>
            </div>
        </form>
    </Popup>

    <Popup ref="deleteCustomerPopup" title="Kundenprofil löschen?">
        <form class="confirm-popup-wrapper" @submit.prevent="deleteCustomer()">
            <p>Möchten Sie das <b>Kundenprofil</b> des Nutzers mit der Email <a>{{user.email}}</a> entgültig löschen?</p>
            <div class="confirm-popup-footer">
                <mui-button variant="contained" label="Abbrechen" @click="$refs.deleteCustomerPopup.close()"/>
                <mui-button type="submit" variant="filled" color="error" label="Entgültig löschen"/>
            </div>
        </form>
    </Popup>

    <Popup ref="deleteEmployeePopup" title="Mitarbeiterprofil löschen?">
        <form class="confirm-popup-wrapper" @submit.prevent="deleteEmployee()">
            <p>Möchten Sie das <b>Mitarbeiterprofil</b> des Nutzers mit der Email <a>{{user.email}}</a> entgültig löschen?</p>
            <div class="confirm-popup-footer">
                <mui-button variant="contained" label="Abbrechen" @click="$refs.deleteEmployeePopup.close()"/>
                <mui-button type="submit" variant="filled" color="error" label="Entgültig löschen"/>
            </div>
        </form>
    </Popup>
</template>

<script setup>
    import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { ref, computed } from 'vue'
    import zxcvbn from 'zxcvbn'

    import AdminLayout from '@/Layouts/Admin.vue'
    import Switcher from '@/Components/Form/Switcher.vue'
    import IconButton from '@/Components/Form/IconButton.vue'
    import Popup from '@/Components/Form/Popup.vue'
    import Tag from '@/Components/Form/Tag.vue'

    window.zxcvbn = zxcvbn

    const props = defineProps({
        user: Object,
    })



    const userSettings = computed(() => {
        return props.user.settings.reduce((acc, cur) => {
            acc[cur.key] = cur.value
            return acc
        }, {})
    })



    const deleteUserPopup = ref(null)
    const deleteCustomerPopup = ref(null)
    const deleteEmployeePopup = ref(null)



    const errors = computed(() => usePage().props.value.errors)
    const hasErrors = computed(() => Object.keys(errors.value).length > 0)

    const toggleRole = (role) => {
        let action = props.user.roles.map(e => e.name).includes(role) ? 'revoke' : 'assign'

        if (action === 'assign') useForm({role}).put(route('dashboard.admin.users.role.assign', { user: props.user.id }))
        if (action === 'revoke') useForm({role}).put(route('dashboard.admin.users.role.revoke', { user: props.user.id }))
    }

    const enableUser = () => useForm().put(route('dashboard.admin.users.enable', { user: props.user.id }))
    const enableCustomer = () => useForm().put(route('dashboard.admin.users.enable.customer', { user: props.user.id }))
    const enableEmployee = () => useForm().put(route('dashboard.admin.users.enable.employee', { user: props.user.id }))

    const disableUser = () => useForm().put(route('dashboard.admin.users.disable', { user: props.user.id }))
    const disableCustomer = () => useForm().put(route('dashboard.admin.users.disable.customer', { user: props.user.id }))
    const disableEmployee = () => useForm().put(route('dashboard.admin.users.disable.employee', { user: props.user.id }))



    const changePasswordPopup = ref(null)
    const changePasswordForm = useForm({
        newPassword: '',
    })

    const changePassword = () => {
        changePasswordForm.put(route('dashboard.admin.users.change-password', { user: props.user.id }), {
            onSuccess() {
                changePasswordPopup.value.close()
                changePasswordForm.reset()
            }
        })
    }

    const setNewsletter = (newsletter, value) => {
        useForm({
            newsletter,
            value,
        }).put(route('admin.newsletter.update', { user: props.user.id }))
    }

    const deleteUser = () => useForm().delete(route('dashboard.admin.users.destroy', { user: props.user.id }), {
        onSuccess() {
            deleteUserPopup.value.close()
        }
    })

    const deleteCustomer = () => useForm().delete(route('dashboard.admin.users.destroy.customer', { user: props.user.id }), {
        onSuccess() {
            deleteCustomerPopup.value.close()
        }
    })

    const deleteEmployee = () => useForm().delete(route('dashboard.admin.users.destroy.employee', { user: props.user.id }), {
        onSuccess() {
            deleteEmployeePopup.value.close()
        }
    })
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