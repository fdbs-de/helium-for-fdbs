<template>
    <FormSubLayout title="Registrierung" :status="status" @submit="submit" no-padding no-spacing>
        <Head title="Registrierung – FDBS Loginbereich" />

        <div class="step-container">
            <div class="controls-wrapper">
                <div class="progress-wrapper" :style="`--progress: ${step / 4 * 100}%`"></div>
            </div>

            <transition-group :name="`slide-${stepDirection}`" tag="div" class="animation-wrapper" :class="`slide-${stepDirection}`">
                <div class="step-wrapper" v-show="step === 0" key="start">
                    <span class="text-align-center padding-bottom-2">
                        Egal, ob Sie Kunde oder Mitarbeiter bei uns sind:<br>
                        <b>Ihr FDBS Account vereint alles unter einem Dach!</b>
                    </span>
                    <div class="flex-1 flex vertical gap-2 padding-top-1 v-center h-center background-soft radius-m">
                        <mui-button type="button" class="start-onboarding-button" size="large" label="Jetzt registrieren" @click="setStep(1)"/>
                        <Link :href="route('login')">Sie haben bereits ein Konto?</Link>
                    </div>
                </div>
    
                <div class="step-wrapper" v-show="step === 1" key="general">
                    <b>Allgemeine Angaben zu Ihrem neuen FDBS Account</b>
                    <mui-input type="email" label="Email *" v-model="form.email" required autocomplete="username"/>
                    <mui-input type="password" show-password-score label="Passwort wählen *" v-model="form.password" required autocomplete="new-password"/>
                    <div class="spacer"></div>
                    <div class="flex v-center">
                        <mui-button type="button" label="Zurück" variant="contained" @click="setStep(0)"/>
                        <div class="spacer"></div>
                        <mui-button type="button" label="Weiter" :disabled="!isStepOneValid" @click="setStep(2)"/>
                    </div>
                </div>
    
                <div class="step-wrapper" v-show="step === 2" key="customer">
                    <mui-toggle type="checkbox" class="checkbox" v-model="form.is_customer">
                        <template #label>
                            <span><b>Ich bin FDBS Kunde</b><br>
                            Hiermit erhalten Sie Zugriff auf die Spezifikationen</span>
                        </template>
                    </mui-toggle>
                    <template v-if="form.is_customer">
                        <mui-input type="text" label="Firma *" v-model="form.customer.company" required autocomplete="company"/>
                        <mui-input type="text" label="Kundennummer *" v-model="form.customer.customer_id" required autocomplete="customer-id"/>
                        <mui-toggle type="checkbox" class="checkbox" v-model="form.customer.newsletter">
                            <template #label>
                                Ich möchte regelmäßig über die neusten Angebote informiert werden.
                            </template>
                        </mui-toggle>
                    </template>
                    <div class="spacer"></div>
                    <div class="flex v-center">
                        <mui-button type="button" label="Zurück" variant="contained" @click="setStep(1)"/>
                        <div class="spacer"></div>
                        <mui-button type="button" :label="form.is_customer ? 'Weiter' : 'Weiter ohne Kundenprofil'" :disabled="!isStepTwoValid" @click="setStep(3)"/>
                    </div>
                </div>
    
                <div class="step-wrapper" v-show="step === 3" key="employee">
                    <mui-toggle type="checkbox" class="checkbox" v-model="form.is_employee">
                        <template #label>
                            <span><b>Ich bin bei FDBS angestellt</b><br>
                            Hiermit erhalten Sie Zugriff auf das Intranet</span>
                        </template>
                    </mui-toggle>
                    <template v-if="form.is_employee">
                        <mui-input type="text" label="Vorname *" v-model="form.employee.first_name" required autocomplete="firstname"/>
                        <mui-input type="text" label="Nachname *" v-model="form.employee.last_name" required autocomplete="lastname"/>
                    </template>
                    <div class="spacer"></div>
                    <div class="flex v-center">
                        <mui-button type="button" label="Zurück" variant="contained" @click="setStep(2)"/>
                        <div class="spacer"></div>
                        <mui-button type="button" :label="form.is_employee ? 'Weiter' : 'Weiter ohne Mitarbeiterprofil'" :disabled="!isStepThreeValid" @click="setStep(4)"/>
                    </div>
                </div>
    
                <div class="step-wrapper" v-show="step === 4" key="finish">
                    <span class="spacer text-align-center padding-1" v-if="!hasSelectedAProfile">
                        Sie müssen entweder ein <b>Kundenprofil</b> oder ein <b>Mitarbeiterprofil</b> (oder beides) anwählen und ausfüllen um sich zu registrieren.
                    </span>
                    <div v-else class="flex vertical padding-1 gap-1 background-soft radius-m">
                        <mui-toggle type="checkbox" class="checkbox" v-model="form.terms">
                            <template #label>
                                Ich habe die <a target="_blank" :href="route('datenschutz')">Datenschutzerklärung</a> und die
                                <a target="_blank" :href="route('agbs')">AGBs</a> gelesen und akzeptiere diese.
                            </template>
                        </mui-toggle>
    
                        <mui-toggle type="checkbox" class="checkbox" v-model="form.notices[0]">
                            <template #label>
                                Mir ist bewusst, dass meine Daten nach Absendung manuell durch einen Administrator
                                freigeschaltet werden. Dies passiert in der Regel <b>innerhalb eines Werktages</b>.
                            </template>
                        </mui-toggle>
    
                        <mui-toggle type="checkbox" class="checkbox" v-model="form.notices[1]">
                            <template #label>
                                Mir ist bewusst, dass ich nach Absendung <b>zwei Emails</b> an die angegebene Email-Adresse erhalten werde.
                            </template>
                        </mui-toggle>
                    </div>
                    <div class="flex v-center">
                        <mui-button type="button" label="Zurück" variant="contained" @click="setStep(3)"/>
                        <div class="spacer"></div>
                        <mui-button label="Jetzt registrieren" :disabled="!isValid" :loading="form.processing"/>
                    </div>
                </div>
            </transition-group>
        </div>
    </FormSubLayout>
</template>

<script setup>
    import FormSubLayout from '@/Layouts/SubLayouts/Form.vue'
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
    import zxcvbn from 'zxcvbn'
    import { ref, computed, watch } from 'vue'

    window.zxcvbn = zxcvbn

    defineProps({
        status: String,
    })



    const step = ref(0)

    const setStep = (i) => {
        step.value = i
    }

    const stepDirection = ref('right')
    
    watch(step, (newStep, oldStep) => {
        stepDirection.value = (newStep > oldStep) ? 'left' : 'right'
    })



    const isStepOneValid = computed(() => {
        if (!form.email || !form.password) return false
        if (form.password.length < 8) return false
        
        return true
    })

    const isStepTwoValid = computed(() => {
        if (form.is_customer)
        {
            if (!form.customer.company.length) return false
            if (!form.customer.customer_id.length) return false
        }
        
        return true
    })

    const isStepThreeValid = computed(() => {
        if (form.is_employee)
        {
            if (!form.employee.first_name.length) return false
            if (!form.employee.last_name.length) return false
        }
        
        return true
    })

    const isStepFourValid = computed(() => {
        if (!form.terms) return false
        if (!form.notices[0]) return false
        if (!form.notices[1]) return false
        
        return true
    })

    const hasSelectedAProfile = computed(() => {
        if (!form.is_customer && !form.is_employee) return false

        return true
    })

    const isValid = computed(() => {
        if (!isStepOneValid.value) return false
        if (!isStepTwoValid.value) return false
        if (!isStepThreeValid.value) return false
        if (!isStepFourValid.value) return false
        if (!hasSelectedAProfile.value) return false
        
        return true
    })



    const form = useForm({
        is_customer: false,
        is_employee: false,
        email: '',
        password: '',
        customer: {
            company: '',
            customer_id: '',
            newsletter: false,
        },
        employee: {
            first_name: '',
            last_name: '',
        },
        terms: false,
        notices: [false, false],
    })

    const submit = () => {
        if (!isValid.value) return

        form.post(route('registrieren'), {
            onFinish: () => form.reset('password'),
        })
    }
</script>

<style lang="sass" scoped>

    .slide-left-move,
    .slide-right-move,
    .slide-left-enter-active,
    .slide-right-enter-active,
    .slide-left-leave-active,
    .slide-right-leave-active
        transition: all 0.5s ease

    .slide-left-enter-from,
    .slide-right-leave-to
        transform: translate(100%, 0) !important

    .slide-right-enter-from,
    .slide-left-leave-to
        transform: translate(-100%, 0) !important

    .slide-left-leave-active,
    .slide-right-leave-active
        position: absolute



    .checkbox
        --mui-background: var(--color-background)

    .step-container
        .controls-wrapper
            height: var(--height-header)
            display: flex
            justify-content: center
            align-items: center
            gap: 1rem

            .progress-wrapper
                height: 6px
                width: 100px
                border-radius: 100px
                background: var(--color-background-soft)
                position: relative
                overflow: hidden

                &::after
                    content: ''
                    position: absolute
                    top: 0
                    left: 0
                    width: var(--progress)
                    height: 100%
                    border-radius: 100px
                    background: var(--color-primary)
                    transition: width 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94)

        .animation-wrapper
            position: relative
            overflow: hidden

        .step-wrapper
            width: 100%
            min-height: 20rem
            display: flex
            flex-direction: column
            padding: 1rem
            gap: 1rem
            top: 0
            left: 0
</style>
