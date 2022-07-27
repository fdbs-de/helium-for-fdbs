<template>
    <Head title="Profil" />

    <DashboardSubLayout title="Ihr Profil">
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
                        <Tag v-if="$page.props.auth.user.enabled_at" color="green" icon="check_circle">Freischaltet</Tag>
                        <Tag v-else color="yellow" icon="cancel">Freigeschaltung ausstehend</Tag>
                    </div>
                </div>
            </div>



            <div class="group" v-if="$page.props.auth.user.customer_profile">
                <h2>Kundenprofil</h2>

                <div class="flex v-center gap">
                    <span class="flex-1">Firma:</span>
                    <div class="flex-3 flex gap v-center">
                        <b v-if="$page.props.auth.user.customer_profile.company">{{$page.props.auth.user.customer_profile.company}}</b>
                        <i v-else>Keine Firma angegeben</i>
                    </div>
                </div>

                <div class="flex v-center gap">
                    <span class="flex-1">Kundennummer:</span>
                    <div class="flex-3 flex gap v-center">
                        <b v-if="$page.props.auth.user.customer_profile.customer_id">{{$page.props.auth.user.customer_profile.customer_id}}</b>
                        <i v-else>Keine Kundennummer angegeben</i>
                    </div>
                </div>

                <div class="flex v-center gap">
                    <span class="flex-1">Status:</span>
                    <div class="flex-3 flex gap v-center">
                        <Tag v-if="$page.props.auth.user.customer_profile.enabled_at" color="green" icon="check_circle">Freischaltet</Tag>
                        <Tag v-else color="yellow" icon="cancel">Freigeschaltung ausstehend</Tag>
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
                        <!-- <mui-button type="button" label="Abmelden" size="small" variant="contained"/> -->
                        <Link class="simple-button" :href="route('logout')" method="post" as="button">Abmelden</Link>
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
</script>

<style lang="sass" scoped>
    .profile-wrapper
        padding: var(--su)
        display: flex
        flex-direction: column
        gap: .5rem

        .group
            display: contents
</style>