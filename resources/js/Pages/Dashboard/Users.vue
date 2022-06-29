<template>
    <Head title="Dashboard: Nutzerverwaltung" />

    <DashboardSubLayout title="Nutzerverwaltung">
        <template #head>
            <!-- file input that accepts json -->
            <input ref="importInput" type="file" accept=".json" @change="importUsersFromJSON($event.target.files[0])" />
        </template>

        <div class="grid">
            <div class="row">
                <b>Name</b>
                <b>Email</b>
                <b>Rollen</b>
                <b>Eigenschaften</b>
            </div>
            
            <div class="row" v-for="user in users" :key="user.id" @click="openUser(user)">
                <span v-if="user.name">{{user.name}}</span>
                <i v-else>Kein Name angegeben</i>

                <span>{{user.email}}</span>

                <span class="flex center gap">
                    <Tag v-for="role in user.roles" :key="user.id+'_'+role.id">{{role.name}}</Tag>
                </span>

                <span class="flex center gap">
                    <div class="icon" :class="{'active': user.email_verified_at}">mail</div>
                    <div class="icon" :class="{'active': user.enabled_at}">check_circle</div>
                    <div class="icon" :class="{'active': (user.customer_profile || {}).enabled_at, 'notified': user.customer_profile}">shopping_cart</div>
                    <div class="icon" :class="{'active': (user.employee_profile || {}).enabled_at, 'notified': user.employee_profile}">work</div>
                </span>
            </div>
        </div>
    </DashboardSubLayout>

    <Popup ref="managePopup" class="user-popup" background-color="var(--color-background-soft)">
        <div class="popup-block popup-error" v-if="hasErrors">
            <h3><b>Fehler!</b></h3>
            <p v-for="(error, key) in errors" :key="key">{{ error }}</p>
        </div>


        <div class="popup-block popup-head">
            <div class="popup-row ">
                <div class="flex vertical spacer">
                    <h3>{{userForm.name || 'Kein Name'}}</h3>
                    <p>
                        {{userForm.email}}
                        <small v-if="!userForm.email_verified_at">(Bestätigung ausstehend)</small>
                    </p>
                </div>
                <div class="button-group">
                    <mui-button label="Freigeben" v-if="!userForm.enabled_at" @click="enableUser()"/>
                    <mui-button label="Sperren" v-else @click="disableUser()"/>
                    <mui-button label="Löschen" size="small" variant="contained" @click="$refs.deleteUserPopup.open()"/>
                </div>
            </div>
        </div>


        <div class="popup-block popup-tags">
            <div class="popup-row">
                <Tag class="tag active" v-if="userForm.roles.map(e => e.name).includes('Super Admin')">Super Admin</Tag>
                <Tag class="tag clickable" :class="{'active': userForm.roles.map(e => e.name).includes('Admin')}" @click="toggleRole('Admin')">Admin</Tag>
                <Tag class="tag clickable" :class="{'active': userForm.roles.map(e => e.name).includes('Editor')}" @click="toggleRole('Editor')">Editor</Tag>
            </div>
        </div>


        <div class="popup-block" v-if="userForm.customer_profile">
            <div class="popup-row fixed-height">
                <div class="flex vertical spacer">
                    <b>Firma: {{userForm.customer_profile.company}}</b>
                    <span>Kundennummer: {{userForm.customer_profile.customer_id || 'Keine Kundennummer'}}</span>
                </div>
                <div class="button-group">
                    <mui-button label="Freigeben" v-if="!userForm.customer_profile.enabled_at" @click="enableCustomer()"/>
                    <mui-button label="Sperren" v-else @click="disableCustomer()"/>
                    <mui-button label="Löschen" size="small" variant="contained" @click="$refs.deleteCustomerPopup.open()"/>
                </div>
            </div>
        </div>
        <div class="popup-block" v-else>
            <div class="popup-row fixed-height">
                <i class="spacer">Kein Firmenkonto angelegt</i>
                <mui-button label="Anlegen" size="small" variant="text" disabled/>
            </div>
        </div>


        <div class="popup-block" v-if="userForm.employee_profile">
            <div class="popup-row fixed-height">
                <div class="flex vertical spacer">
                    <b>{{userForm.employee_profile.first_name}}</b>
                    <span>{{userForm.employee_profile.last_name}}</span>
                </div>
                <div class="button-group">
                    <mui-button label="Freigeben" v-if="!userForm.employee_profile.enabled_at" @click="enableEmployee()"/>
                    <mui-button label="Sperren" v-else @click="disableEmployee()"/>
                    <mui-button label="Löschen" size="small" variant="contained" @click="$refs.deleteEmployeePopup.open()"/>
                </div>
            </div>
        </div>
        <div class="popup-block" v-else>
            <div class="popup-row fixed-height">
                <i class="spacer">Kein Mitarbeiterkonto angelegt</i>
                <mui-button label="Anlegen" size="small" variant="text" disabled/>
            </div>
        </div>


        <div class="popup-block popup-footer">
            <p>Konto ID: <b>{{userForm.id}}</b></p>
            <p>Erstellt am <b>{{$dayjs(userForm.created_at).format('DD MMMM YYYY')}}</b> um <b>{{$dayjs(userForm.created_at).format('HH:mm')}}</b></p>
            <p v-if="userForm.email_verified_at">Email bestätigt am <b>{{$dayjs(userForm.email_verified_at).format('DD MMMM YYYY')}}</b> um <b>{{$dayjs(userForm.email_verified_at).format('HH:mm')}}</b></p>
            <p v-if="userForm.enabled_at">Freigeschaltet am <b>{{$dayjs(userForm.enabled_at).format('DD MMMM YYYY')}}</b> um <b>{{$dayjs(userForm.enabled_at).format('HH:mm')}}</b></p>
        </div>
    </Popup>

    <Popup ref="deleteUserPopup">
        <form class="confirm-popup-wrapper" @submit.prevent="deleteUser()">
            <p>Möchten Sie den <b>Nutzer</b> mit der Email <a>{{userForm.email}}</a> entgültig löschen?</p>
            <div class="confirm-popup-footer">
                <mui-button variant="contained" label="Abbrechen" @click="$refs.deleteUserPopup.close()"/>
                <mui-button type="submit" variant="filled" color="error" label="Entgültig löschen"/>
            </div>
        </form>
    </Popup>

    <Popup ref="deleteCustomerPopup">
        <form class="confirm-popup-wrapper" @submit.prevent="deleteCustomer()">
            <p>Möchten Sie das <b>Kundenprofil</b> des Nutzers mit der Email <a>{{userForm.email}}</a> entgültig löschen?</p>
            <div class="confirm-popup-footer">
                <mui-button variant="contained" label="Abbrechen" @click="$refs.deleteCustomerPopup.close()"/>
                <mui-button type="submit" variant="filled" color="error" label="Entgültig löschen"/>
            </div>
        </form>
    </Popup>

    <Popup ref="deleteEmployeePopup">
        <form class="confirm-popup-wrapper" @submit.prevent="deleteEmployee()">
            <p>Möchten Sie das <b>Mitarbeiterprofil</b> des Nutzers mit der Email <a>{{userForm.email}}</a> entgültig löschen?</p>
            <div class="confirm-popup-footer">
                <mui-button variant="contained" label="Abbrechen" @click="$refs.deleteEmployeePopup.close()"/>
                <mui-button type="submit" variant="filled" color="error" label="Entgültig löschen"/>
            </div>
        </form>
    </Popup>
</template>

<script setup>
    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
    import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3'
    import Popup from '@/Components/Form/Popup.vue'
    import Tag from '@/Components/Form/Tag.vue'
    import { ref, computed } from 'vue'

    const props = defineProps({
        users: Array,
    })



    const managePopup = ref(null)
    const deleteUserPopup = ref(null)
    const deleteCustomerPopup = ref(null)
    const deleteEmployeePopup = ref(null)
    const importInput = ref(null)

    const selectedUser = ref(null)
    const userForm = computed(() => {
        let user = props.users.find(user => user.id === selectedUser.value) || null

        return {
            id: user?.id || null,
            name: user?.name || '',
            email: user?.email || '',
            enabled_at: user?.enabled_at || null,
            email_verified_at: user?.email_verified_at || null,
            customer_profile: user?.customer_profile || null,
            employee_profile: user?.employee_profile || null,
            roles: user?.roles || [],
            created_at: user?.created_at || null,
        }
    })



    const errors = computed(() => usePage().props.value.errors)
    const hasErrors = computed(() => Object.keys(errors.value).length > 0)

    const openUser = (user = null) => {
        managePopup.value.open()
        selectedUser.value = user.id
    }

    const toggleRole = (role) => {
        let action = userForm.value.roles.map(e => e.name).includes(role) ? 'revoke' : 'assign'

        if (action === 'assign') useForm({role}).put(route('dashboard.admin.users.role.assign', { user: userForm.value.id }))
        if (action === 'revoke') useForm({role}).put(route('dashboard.admin.users.role.revoke', { user: userForm.value.id }))
    }

    const enableUser = () => useForm().put(route('dashboard.admin.users.enable', { user: userForm.value.id }))
    const enableCustomer = () => useForm().put(route('dashboard.admin.users.enable.customer', { user: userForm.value.id }))
    const enableEmployee = () => useForm().put(route('dashboard.admin.users.enable.employee', { user: userForm.value.id }))

    const disableUser = () => useForm().put(route('dashboard.admin.users.disable', { user: userForm.value.id }))
    const disableCustomer = () => useForm().put(route('dashboard.admin.users.disable.customer', { user: userForm.value.id }))
    const disableEmployee = () => useForm().put(route('dashboard.admin.users.disable.employee', { user: userForm.value.id }))

    const deleteUser = () => useForm().delete(route('dashboard.admin.users.destroy', { user: userForm.value.id }), {
        onSuccess() {
            managePopup.value.close()
            deleteUserPopup.value.close()
            selectedUser.value = null
        }
    })

    const deleteCustomer = () => useForm().delete(route('dashboard.admin.users.destroy.customer', { user: userForm.value.id }), {
        onSuccess() {
            deleteCustomerPopup.value.close()
        }
    })

    const deleteEmployee = () => useForm().delete(route('dashboard.admin.users.destroy.employee', { user: userForm.value.id }), {
        onSuccess() {
            deleteEmployeePopup.value.close()
        }
    })



    const importUsersFromJSON = (file) => {
        if (!file) return

        const reader = new FileReader()
        reader.readAsText(file)

        reader.onload = () => {
            const users = JSON.parse(reader.result)
            importInput.value = null
            useForm({users}).post(route('dashboard.admin.users.import'), {
                onSuccess() {
                    console.log(`Successfully imported ${users.length} users`)
                }
            })
        }
    }
</script>

<style lang="sass" scoped>
    .grid
        display: grid
        align-items: center
        grid-template-columns: minmax(170px, 2fr) minmax(200px, 3fr) minmax(200px, 3fr) 150px
        grid-auto-rows: 2.5rem
        gap: 0 var(--su)
        width: 100%
        padding: 1rem
        overflow-x: auto

        .row
            display: contents
            cursor: pointer

            > span
                overflow: hidden
                text-overflow: ellipsis
                white-space: nowrap

            .icon
                font-family: var(--font-icon)
                font-size: 1.5rem
                line-height: 1
                color: var(--color-text)
                user-select: none

                &.notified
                    color: var(--color-warning)

                &.active
                    color: var(--color-primary)

            &:hover
                background: var(--color-background-soft)

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