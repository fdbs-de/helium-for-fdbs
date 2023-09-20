<template>
    <AuthenticatedLayout title="Ihr Profil">
        <div class="limiter">
            <div class="flex vertical gap-2 padding-bottom-6">
                <StatefulAccordion title="Allgemeines" scope="auth.profile.general">
                    <div class="card margin-bottom-4">
                        <div class="field">
                            <span>Anzeigename:</span>
                            <div><b>{{ user.name ?? '---' }}</b></div>
                        </div>
                
                        <div class="field">
                            <span>Email:</span>
                            <div class="flex-3 flex gap v-center">
                                <b>{{user.email ?? '---'}}</b>
                            </div>
                        </div>
        
                        <div class="field">
                            <span>Nutzername:</span>
                            <div><b>{{user.username ?? '---'}}</b></div>
                        </div>
                
                        <div class="field">
                            <span>Status:</span>
                            <div>
                                <Tag v-if="user.enabled_at" color="green" shape="pill">Freigeschaltet</Tag>
                                <Tag v-else color="var(--color-yellow)" shape="pill">Freischaltung ausstehend</Tag>
                            </div>
                        </div>

                        <hr>
        
                        <div class="field">
                            <span>Passwort:</span>
                            <div>
                                <IodButton type="button" label="Passwort Ändern" size="small" variant="contained" @click="$refs.changePasswordPopup.open()"/>
                            </div>
                        </div>

                        <hr>
                
                        <div class="field">
                            <span>Ausloggen:</span>
                            <div>
                                <IodButton is="a" label="Jetzt ausloggen" size="small" variant="contained" :href="route('logout')"/>
                            </div>
                        </div>
                    </div>
                </StatefulAccordion>

                <StatefulAccordion title="Firmenprofil" scope="auth.profile.employee" v-if="user.profiles.employee">
                    <div class="card margin-bottom-4">
                        <div class="field">
                            <span>Vorname:</span>
                            <div><b>{{user.profiles.employee.first_name || '---'}}</b></div>
                        </div>
                
                        <div class="field">
                            <span>Nachname:</span>
                            <div><b>{{user.profiles.employee.last_name || '---'}}</b></div>
                        </div>
                    </div>
                </StatefulAccordion>

                <StatefulAccordion title="Kundenprofil" scope="auth.profile.customer" v-if="user.profiles.customer">
                    <div class="card">
                        <div class="field">
                            <span>Firma:</span>
                            <div><b>{{$page.props.auth.user.profiles.customer.company || '---'}}</b></div>
                        </div>
                
                        <div class="field">
                            <span>Kundennummer:</span>
                            <div><b>{{$page.props.auth.user.profiles.customer.customer_id || '---'}}</b></div>
                        </div>
                        
                        <div class="field">
                            <span>Kunden Newsletter:</span>
                            <div>
                                <IodToggle type="switch" :modelValue="$page.props.auth.user.settings_object['newsletter.subscribed.customer']" @update:modelValue="setNewsletter('customer', $event)"/>
                            </div>
                        </div>
                    </div>
                </StatefulAccordion>
            </div>
        </div>
    </AuthenticatedLayout>



    <Popup ref="changePasswordPopup" title="Passwort ändern">
        <ValidationErrors />

        <form class="flex vertical gap-1 padding-1" @submit.prevent="changePassword()">
            <IodInput type="password" label="Derzeitiges Passwort" required v-model="changePasswordForm.currentPassword"/>
            <IodInput type="password" label="Neues Passwort" show-password-score :password-score-function="zxcvbn" required v-model="changePasswordForm.newPassword"/>
            <IodButton label="Passwort Ändern"/>
        </form>
    </Popup>
</template>

<script setup>
    import { usePage, useForm } from '@inertiajs/inertia-vue3'
    import { ref, computed } from 'vue'
    import zxcvbn from 'zxcvbn'
    
    import AuthenticatedLayout from '@/Layouts/Authenticated.vue'
    import StatefulAccordion from '@/Components/Form/StatefulAccordion.vue'
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
            max-width: 12rem
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