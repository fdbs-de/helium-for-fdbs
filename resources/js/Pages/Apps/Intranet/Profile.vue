<template>
    <AuthenticatedLayout title="Ihr Profil">
        <div class="limiter">
            <div class="flex vertical gap-2 padding-bottom-6">
                <div class="profile-card">
                    <div class="profile-banner" :style="{backgroundImage: `url(/images/app/defaults/user_banner.png)`}"></div>
                    <div class="profile-image">
                        <img :src="user.image" :alt="user.name">
                    </div>
                    <div class="profile-info">
                        <h2>{{ user.name ?? user.email }}</h2>
                        <p v-if="user.username">@{{ user.username }}</p>
                    </div>
                </div>

                <div class="card margin-bottom-4">
                    <div class="field">
                        <span>Anzeigename</span>
                        <div><b>{{ user.name ?? '---' }}</b></div>
                    </div>
            
                    <div class="field">
                        <span>Nutzername</span>
                        <div><b>{{user.username ?? '---'}}</b></div>
                    </div>

                    <div class="field">
                        <span>Email</span>
                        <div class="flex-3 flex gap v-center">
                            <b>{{user.email ?? '---'}}</b>
                        </div>
                    </div>
            
                    <div class="field">
                        <span>Status</span>
                        <div>
                            <Tag v-if="user.enabled_at" color="green" shape="pill">Freigeschaltet</Tag>
                            <Tag v-else color="var(--color-yellow)" shape="pill">Freischaltung ausstehend</Tag>
                        </div>
                    </div>

                    <hr>

                    <div class="field" v-if="user.details && user.details.fullname">
                        <span>Name</span>
                        <div><b>{{ user.details.fullname }}</b></div>
                    </div>
                    
                    <div class="field" v-if="user.custom_account_id">
                        <span>Kundennummer</span>
                        <div><b>{{ user.custom_account_id }}</b></div>
                    </div>

                    <div class="field" v-if="user.details && user.details.company">
                        <span>Firma</span>
                        <div><b>{{ user.details.company }}</b></div>
                    </div>

                    <hr>
    
                    <div class="field">
                        <span>Passwort</span>
                        <div>
                            <IodButton type="button" label="Passwort Ändern" size="small" variant="contained" @click="$refs.changePasswordPopup.open()"/>
                        </div>
                    </div>

                    <div class="field">
                        <span>2-Faktor-Authentifizierung</span>
                        <div>
                            <IodButton type="button" label="Deaktivieren" size="small" variant="contained" v-if="user.has_mfa_enabled" @click="resetTOTP()"/>
                            <IodButton type="button" label="Aktivieren" size="small" variant="filled" v-else @click="setupTOTP()"/>
                        </div>
                    </div>

                    <hr>
            
                    <div class="field">
                        <span>Ausloggen</span>
                        <div>
                            <IodButton is="a" label="Jetzt ausloggen" size="small" variant="contained" :href="route('logout')"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>



    <Popup ref="changePasswordPopup" title="Passwort ändern">
        <form class="flex vertical gap-1 padding-1" @submit.prevent="changePassword()">
            <ValidationErrors />
            
            <IodInput type="password" label="Derzeitiges Passwort" required v-model="changePasswordForm.currentPassword"/>
            <IodInput type="password" label="Neues Passwort" show-password-score :password-score-function="zxcvbn" required v-model="changePasswordForm.newPassword"/>
            <IodButton label="Passwort Ändern"/>
        </form>
    </Popup>
    
    <Popup ref="setupTOTPPopup" title="2-Faktor-Authentifizierung">
        <form class="flex vertical gap-1 padding-1" @submit.prevent="enableTOTP()">
            <ValidationErrors />
            <div class="flex v-start gap-1">
                <div class="w-16 flex vertical gap-1">
                    <img class="w-16" :src="TOTPSetup.qr_code" alt="QR-Code" v-if="TOTPSetup.qr_code"/>
                </div>
                <div class="flex-1 flex vertical gap-1">
                    <ol>
                        <li>
                            Öffnen Sie Ihre Authentifizierungs-App und scannen Sie den QR-Code.
                        </li>
                        <li>
                            Geben Sie den 6-stelligen Code ein, der in Ihrer App angezeigt wird.
                        </li>
                        <li>
                            Bestätigen Sie die 2-Faktor-Authentifizierung.
                        </li>
                    </ol>
                    <IodInput type="text" label="Authentifizierungscode" required v-model="TOTPForm.otp">
                        <template #right>
                            <IodButton label="Bestätigen" size="small"/>
                        </template>
                    </IodInput>
                </div>
            </div>
        </form>
    </Popup>
</template>

<script setup>
    import { usePage, useForm } from '@inertiajs/inertia-vue3'
    import { ref, computed } from 'vue'
    import zxcvbn from 'zxcvbn'
    
    import AuthenticatedLayout from '@/Layouts/Authenticated.vue'
    import ValidationErrors from '@/Components/ValidationErrors.vue'
    import Popup from '@/Components/Form/Popup.vue'
    import Tag from '@/Components/Form/Tag.vue'



    const user = computed(() =>{
        return usePage().props.value.auth.user
    })

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



    // START: TOTP
    const setupTOTPPopup = ref(null)
    const TOTPSetup = ref({
        qr_code: null,
        secret: null,
    })
    const TOTPForm = useForm({
        otp: '',
    })

    function setupTOTP()
    {
        setupTOTPPopup.value.open()
        
        axios.put(route('mfa.totp.setup')).then(response => {
            TOTPSetup.value = response.data
        })
    }

    function enableTOTP()
    {
        TOTPForm.put(route('mfa.totp.enable'), {
            preserveScroll: true,
            onSuccess() {
                TOTPForm.reset()
                setupTOTPPopup.value.close()
            },
        })
    }

    function resetTOTP()
    {
        // confirm
        if (!confirm('Möchten Sie die 2-Faktor-Authentifizierung wirklich deaktivieren?')) {
            return
        }

        useForm().delete(route('mfa.totp.reset'), {
            preserveScroll: true,
        })
    }
    // END: TOTP



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
    .profile-card
        width: 100%
        display: flex
        flex-direction: column
        align-items: center
        text-align: center
        border-radius: var(--radius-xl)
        background: var(--color-background)
        border: 1px solid var(--color-background-soft)
        box-shadow: var(--shadow-elevation-low)
        overflow: hidden
        margin-block: 1rem 2rem

        .profile-banner
            width: 100%
            height: 12rem
            background-size: cover
            background-position: center
            background-repeat: no-repeat
            background-color: var(--color-background-soft)

        .profile-image
            width: 10rem
            height: 10rem
            margin-top: -5rem
            border-radius: 50%
            background: var(--color-background)
            position: relative

            &::before,
            &::after
                content: ''
                position: absolute
                bottom: 50%
                width: 1.5rem
                height: 1.5rem
                background: transparent
                pointer-events: none

            &::before
                right: calc(100% - 1px)
                border-radius: 0 0 var(--radius-xl) 0
                box-shadow: .75rem .75rem 0 var(--color-background)

            &::after
                left: calc(100% - 1px)
                border-radius: 0 0 0 var(--radius-xl)
                box-shadow: -.75rem .75rem 0 var(--color-background)

            img
                width: 100%
                height: 100%
                object-fit: cover
                border-radius: 50%
                border: 5px solid var(--color-background)
                position: relative
                z-index: 1

        .profile-info
            width: 100%
            display: flex
            flex-direction: column
            align-items: center
            padding-block: 1rem 2rem

            h2
                margin: 0
                font-size: 1.5rem
                font-weight: 600

            p
                margin: 0

    .card
        display: flex
        flex-direction: column
        border-radius: var(--radius-m)
        background: var(--color-background)
        border: 1px solid var(--color-border)
        padding-block: .5rem

    .field
        display: flex
        align-items: center
        gap: .5rem
        min-height: 3rem

        > span
            flex: none
            max-width: 16rem
            width: 100%
            padding: .5rem 1rem

        > div
            padding: .5rem 1rem



    @media screen and (max-width: 500px)
        .field
            flex-direction: column
            align-items: flex-start
            padding: 1rem

            > span
                width: 100%
                padding: 0

            > div
                width: 100%
                padding: 0
</style>