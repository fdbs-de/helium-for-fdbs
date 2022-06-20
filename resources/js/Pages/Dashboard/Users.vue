<template>
    <Head title="Dashboard: Nutzerverwaltung" />

    <DashboardSubLayout title="Nutzerverwaltung">
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
                    <div class="tag" v-for="role in user.roles" :key="user.id+'_'+role.id">{{role.name}}</div>
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

    <Popup ref="managePopup" class="user-popup">
        <div class="head flex">
            <div class="flex vertical">
                <h3>{{userForm.name || 'Kein Name'}}</h3>
                <p>
                    {{userForm.email}}
                    <small v-if="!userForm.email_verified_at">(Bestätigung ausstehend)</small>
                </p>
                <div class="flex v-center gap">
                    <div class="tag" v-for="role in userForm.roles" :key="'popup_'+role.id">{{role.name}}</div>
                </div>
            </div>
            <div class="spacer"></div>
            <mui-button label="Freigeben" v-if="!userForm.enabled_at" @click="enableUser()"/>
            <mui-button label="Sperren" variant="contained" v-else @click="disableUser()"/>
        </div>


        <div class="popup-row flex gap" v-if="userForm.customer_profile">
            <div class="flex vertical">
                <b>Firma: {{userForm.customer_profile.company}}</b>
                <span>Kundennummer: {{userForm.customer_profile.customer_id}}</span>
            </div>
            <div class="spacer"></div>
            <mui-button size="small" label="Freigeben" v-if="!userForm.customer_profile.enabled_at" @click="enableCustomer()"/>
            <mui-button size="small" variant="contained" label="Sperren" v-else @click="disableCustomer()"/>
        </div>
        <div class="popup-row flex gap h-center" v-else>
            <i>Kein Firmenkonto angelegt</i>
        </div>

        <hr>

        <div class="popup-row flex gap" v-if="userForm.employee_profile">
            <div class="flex vertical">
                <b>{{userForm.employee_profile.first_name}}</b>
                <span>{{userForm.employee_profile.last_name}}</span>
            </div>
            <div class="spacer"></div>
            <mui-button size="small" label="Freigeben" v-if="!userForm.employee_profile.enabled_at" @click="enableEmployee()"/>
            <mui-button size="small" variant="contained" label="Sperren" v-else @click="disableEmployee()"/>
        </div>
        <div class="popup-row flex gap h-center" v-else>
            <i>Kein Mitarbeiterkonto angelegt</i>
        </div>

        <hr>

        <div class="popup-row flex gap">
            <span>Benutzer Löschen</span>
            <div class="spacer"></div>
            <mui-button label="Löschen" color="error" @click="$refs.deletePopup.open()"/>
        </div>


        <div class="footer">
            <p>Konto ID: <b>{{userForm.id}}</b></p>
            <hr>
            <p>Erstellt am <b>{{$dayjs(userForm.created_at).format('DD MMMM YYYY')}}</b> um <b>{{$dayjs(userForm.created_at).format('HH:mm')}}</b></p>
            <p v-if="userForm.email_verified_at">Email bestätigt am <b>{{$dayjs(userForm.email_verified_at).format('DD MMMM YYYY')}}</b> um <b>{{$dayjs(userForm.email_verified_at).format('HH:mm')}}</b></p>
            <p v-if="userForm.enabled_at">Freigeschaltet am <b>{{$dayjs(userForm.enabled_at).format('DD MMMM YYYY')}}</b> um <b>{{$dayjs(userForm.enabled_at).format('HH:mm')}}</b></p>
        </div>
    </Popup>

    <Popup ref="deletePopup">
        <form class="confirm-popup-wrapper" @submit.prevent="deleteUser()">
            <p>Möchten Sie den Nutzer mit der Email <a>{{userForm.email}}</a> entgültig löschen?</p>
            <div class="confirm-popup-footer">
                <mui-button variant="contained" label="Abbrechen" @click="$refs.deletePopup.close()"/>
                <mui-button type="submit" variant="filled" color="error" label="Entgültig löschen"/>
            </div>
        </form>
    </Popup>
</template>

<script setup>
import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
import Popup from '@/Components/Form/Popup.vue'
import { ref, computed } from 'vue'

const props = defineProps({
    users: Array,
})



const managePopup = ref(null)
const deletePopup = ref(null)
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

const openUser = (user = null) => {
    managePopup.value.open()
    selectedUser.value = user.id
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
        deletePopup.value.close()
        selectedUser.value = null
    }
})
</script>

<style lang="sass" scoped>
    .tag
        display: flex
        align-items: center
        padding-inline: .75rem
        border-radius: 2rem
        height: 1.5rem
        font-size: .8rem
        color: var(--color-primary)
        position: relative

        &::after
            content: ''
            position: absolute
            top: 0
            left: 0
            width: 100%
            height: 100%
            background-color: currentColor
            opacity: .2
            border-radius: inherit
            pointer-events: none

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
        .head
            display: flex
            align-items: center
            padding: 1.5rem
            background: var(--color-primary)
            border-radius: .5rem .5rem 0 0
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
                margin-bottom: 1.25rem

            .tag
                color: inherit

        .popup-row
            display: flex
            align-items: center
            height: 6rem
            padding: 0 var(--su)
            margin-bottom: .5rem

            i
                opacity: .7

        .footer
            padding: .75rem var(--su)
            background: var(--color-background-soft)

            p
                margin: 0
                font-size: .8rem
</style>