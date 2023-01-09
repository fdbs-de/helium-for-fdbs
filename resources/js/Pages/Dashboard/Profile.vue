<template>
    <Head title="Profil" />

    <DashboardSubLayout title="Profil" area="Loginbereich">
        <div class="profile-wrapper">
            <div class="group">
                <h2>Konto</h2>
                <div class="flex v-center gap">
                    <span class="flex-1">Name:</span>
                    <div class="flex-3 flex gap v-center">
                        <b v-if="$page.props.auth.user.name">{{$page.props.auth.user.name}}</b>
                        <i v-else>Kein Kontoname angegeben</i>
                    </div>
                </div>
    
                <div class="flex v-center gap">
                    <span class="flex-1">Email:</span>
                    <div class="flex-3 flex gap v-center">
                        <b>{{$page.props.auth.user.email}}</b>
                    </div>
                </div>
    
                <div class="flex v-center gap">
                    <span class="flex-1">Status:</span>
                    <div class="flex-3 flex gap v-center">
                        <Tag v-if="$page.props.auth.user.enabled_at" color="green" icon="check_circle">Freigeschaltet</Tag>
                        <Tag v-else color="yellow" icon="cancel">Freischaltung ausstehend</Tag>
                    </div>
                </div>
            </div>



            <div class="group" v-if="$page.props.auth.user.profiles.customer">
                <h2>Kundenprofil</h2>

                <div class="flex v-center gap">
                    <span class="flex-1">Firma:</span>
                    <div class="flex-3 flex gap v-center">
                        <b>{{$page.props.auth.user.profiles.customer.company || '---'}}</b>
                    </div>
                </div>

                <div class="flex v-center gap">
                    <span class="flex-1">Kundennummer:</span>
                    <div class="flex-3 flex gap v-center">
                        <b>{{$page.props.auth.user.profiles.customer.customer_id || '---'}}</b>
                    </div>
                </div>
                
                <div class="flex v-center gap">
                    <span class="flex-1">Kunden Newsletter:</span>
                    <div class="flex-3 flex gap v-center">
                        <mui-toggle type="switch" :modelValue="$page.props.auth.user.settings_object['newsletter.subscribed.customer']" @update:modelValue="setNewsletter('customer', $event)"/>
                    </div>
                </div>
            </div>



            <div class="group" v-if="$page.props.auth.user.profiles.employee">
                <h2>Mitarbeiterprofil</h2>

                <div class="flex v-center gap">
                    <span class="flex-1">Vorname:</span>
                    <div class="flex-3 flex gap v-center">
                        <b>{{$page.props.auth.user.profiles.employee.first_name || '---'}}</b>
                    </div>
                </div>

                <div class="flex v-center gap">
                    <span class="flex-1">Nachname:</span>
                    <div class="flex-3 flex gap v-center">
                        <b>{{$page.props.auth.user.profiles.employee.last_name || '---'}}</b>
                    </div>
                </div>
            </div>



            <div class="group">
                <h2>Einstellungen</h2>
                <div class="flex v-center gap">
                    <span class="flex-1">Passwort:</span>
                    <div class="flex-3 flex gap v-center">
                        <mui-button type="button" label="Passwort Ändern" size="small" variant="contained" @click="$refs.changePasswordPopup.open()"/>
                    </div>
                </div>

                <div class="flex v-center gap">
                    <span class="flex-1">Abmelden:</span>
                    <div class="flex-3 flex gap v-center">
                        <mui-button as="a" :href="route('logout')" label="Abmelden" size="small" variant="contained"/>
                    </div>
                </div>
            </div>
        </div>
    </DashboardSubLayout>

    <Popup ref="changePasswordPopup" title="Passwort ändern">
        <div class="popup-block popup-error" v-if="hasErrors">
            <h3><b>Fehler!</b></h3>
            <p v-for="(error, key) in errors" :key="key">{{ error }}</p>
        </div>

        <form class="flex vertical gap-1 padding-1" @submit.prevent="changePassword()">
            <mui-input type="password" no-border label="Derzeitiges Passwort" required v-model="changePasswordForm.currentPassword"/>
            <mui-input type="password" no-border label="Neues Passwort" show-password-score required v-model="changePasswordForm.newPassword"/>
            <mui-button label="Passwort Ändern"/>
        </form>
    </Popup>
</template>

<script setup>
    import Tag from '@/Components/Form/Tag.vue'
    import Popup from '@/Components/Form/Popup.vue'
    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'

    import { Head, Link, usePage, useForm } from '@inertiajs/inertia-vue3'
    import { ref, computed } from 'vue'
    import zxcvbn from 'zxcvbn'

    window.zxcvbn = zxcvbn



    const errors = computed(() => usePage().props.value.errors)
    const hasErrors = computed(() => Object.keys(errors.value).length > 0)



    // START: Change Password
    const changePasswordPopup = ref(null)

    const changePasswordForm = useForm({
        currentPassword: '',
        newPassword: '',
    })

    const changePassword = () => {
        changePasswordForm.put(route('dashboard.profile.change-password'), {
            onSuccess() {
                changePasswordForm.reset()
                changePasswordPopup.value.close()
            },
        })
    }
    // END: Change Password



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
    .profile-wrapper
        display: flex
        flex-direction: column
        gap: 1rem

        .group
            padding: 1rem
            display: flex
            flex-direction: column
            gap: .5rem
            border-radius: var(--radius-m)
            background: var(--color-background)
            box-shadow: var(--shadow-elevation-low)

            h2
                margin: 0
</style>