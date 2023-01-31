<template>
    <TextSubLayout title="Bewerben als LKW Fahrer" image="/images/content/banner/karriere_513169496_482949832.webp" has-small-limiter>
        <Head>
            <title>Als LKW Fahrer bewerben – FDBS Karriere</title>
        </Head>

        <form class="form" @submit.prevent="submit">
            <div class="form-step" @click="sendClick('funnel-has-experience', form.hasExperience)">
                <h2 class="question">Hast du bereits Erfahrung als LKW Fahrer? *</h2>
                <div class="options">
                    <button type="button" :class="{'active': form.hasExperience === 'Nein'}" @click="form.hasExperience = 'Nein'">Nein</button>
                    <button type="button" :class="{'active': form.hasExperience === 'Ja'}" @click="form.hasExperience = 'Ja'">Ja</button>
                </div>
            </div>
    
            <div class="form-step" v-show="form.hasExperience" @click="sendClick('funnel-drivers-license', form.driversLicense)">
                <h2 class="question">Welchen Führerschein hast du? *</h2>
                <div class="options">
                    <button type="button" :class="{'active': form.driversLicense === 'keinen'}" @click="form.driversLicense = 'keinen'">keinen</button>
                    <button type="button" :class="{'active': form.driversLicense === 'C'}" @click="form.driversLicense = 'C'">C</button>
                </div>
                
                <div class="options">
                    <button type="button" :class="{'active': form.driversLicense === 'CE'}" @click="form.driversLicense = 'CE'">CE</button>
                    <button type="button" :class="{'active': form.driversLicense === 'C und CE'}" @click="form.driversLicense = 'C und CE'">C und CE</button>
                </div>
            </div>

            <div class="form-step" v-show="isDriversLicenseValid && form.driversLicense" @click="sendClick('funnel-has-modul-95', form.hasModul95)">
                <h2 class="question">Besitzt du eine gültige Modul 95 Qualifizierung? *</h2>
                <div class="options">
                    <button type="button" :class="{'active': form.hasModul95 === 'Nein'}" @click="form.hasModul95 = 'Nein'">Nein</button>
                    <button type="button" :class="{'active': form.hasModul95 === 'Ja'}" @click="form.hasModul95 = 'Ja'">Ja</button>
                </div>
            </div>
    
            <div class="form-step" v-show="isDriversLicenseValid && form.hasModul95" @click="sendClick('funnel-experience-as-driver', form.experienceAsDriver)">
                <h2 class="question">Wie viele Jahre Berufserfahrung kannst du vorweisen? *</h2>
                <div class="options">
                    <button type="button" :class="{'active': form.experienceAsDriver === 'keine'}" @click="form.experienceAsDriver = 'keine'">keine</button>
                    <button type="button" :class="{'active': form.experienceAsDriver === '1 bis 5 Jahre'}" @click="form.experienceAsDriver = '1 bis 5 Jahre'">1 bis 5 Jahre</button>
                </div>
                
                <div class="options">
                    <button type="button" :class="{'active': form.experienceAsDriver === '5 bis 10 Jahre'}" @click="form.experienceAsDriver = '5 bis 10 Jahre'">5 bis 10 Jahre</button>
                    <button type="button" :class="{'active': form.experienceAsDriver === 'mehr als 10 Jahre'}" @click="form.experienceAsDriver = 'mehr als 10 Jahre'">mehr als 10 Jahre</button>
                </div>
            </div>
    
            <div class="form-step" v-show="isDriversLicenseValid && form.experienceAsDriver" @click="sendClick('funnel-experience-in-language', form.experienceInLanguage)">
                <h2 class="question">Wie sind deine Deutschkenntnisse? *</h2>
                <div class="options">
                    <button type="button" :class="{'active': form.experienceInLanguage === 'nicht so gut'}" @click="form.experienceInLanguage = 'nicht so gut'">nicht so gut</button>
                    <button type="button" :class="{'active': form.experienceInLanguage === 'Okay'}" @click="form.experienceInLanguage = 'Okay'">Okay</button>
                </div>
                
                <div class="options">
                    <button type="button" :class="{'active': form.experienceInLanguage === 'Gut'}" @click="form.experienceInLanguage = 'Gut'">Gut</button>
                    <button type="button" :class="{ 'active': form.experienceInLanguage === 'Muttersprache'}" @click="form.experienceInLanguage = 'Muttersprache'">Muttersprache</button>
                </div>
            </div>
    
            <div class="form-step" v-show="isDriversLicenseValid && form.experienceInLanguage">
                <h2 class="question">Dein Gehaltswunsch (brutto) (optional)</h2>
                <div class="options">
                    <mui-input class="flex-1" border v-model="form.salary" label="Gehaltswunsch"/>
                </div>
                <h2 class="question">Frühestmögliches Eintrittsdatum *</h2>
                <div class="options">
                    <mui-input class="flex-1" border required v-model="form.startDate" label="Eintrittsdatum *" @update:modelValue="sendClick('funnel-start-date')"/>
                </div>
            </div>
    
            <div class="form-step" v-show="isDriversLicenseValid && form.startDate">
                <h2 class="question">Wie können wir dich am besten für ein Gespräch erreichen?</h2>
                <mui-input border required v-model="form.name" label="Name *"/>
                <mui-input border v-model="form.email" label="Email"/>
                <mui-input border required v-model="form.phone" label="Telefonnummer *"/>
                <mui-input class="flex-1" border required v-model="form.zip" label="Postleitzahl *" />
                <div></div>
                <mui-toggle class="checkbox" border required v-model="form.gdpr">
                    <template #label>
                        <span>Ich habe die <a :href="route('datenschutz')" target="_blank">Datenschutzerklärung</a> gelesen und akzeptiere diese *</span>
                    </template>
                </mui-toggle>
                <mui-button type="submit" size="large" :disabled="!isValid">Bewerbung jetzt Absenden</mui-button>
            </div>

            <small>* Diese Felder musst du verpflichtend ausfüllen</small>

            <div class="form-step error" v-show="!isDriversLicenseValid">
                <h2 class="question">Leider können wir dir keine Stelle anbieten</h2>
                <p>Wir suchen zurzeit ausschließlich Fahrer, die über eine gültige Fahrerlaubnis verfügen.</p>
            </div>
        </form>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
    import { computed } from 'vue'

    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'

    const form = useForm({
        hasExperience: null,
        driversLicense: null,
        hasModul95: null,
        experienceAsDriver: null,
        experienceInLanguage: null,
        zip: '',
        salary: '',
        startDate: '',
        name: '',
        email: '',
        phone: '',
        gdpr: false,
    })

    const isDriversLicenseValid = computed(() => {
        return form.driversLicense === 'keinen' ? false : true
    })

    const isValid = computed(() => {
        if (!form.hasExperience) return false
        if (!form.driversLicense) return false
        if (!form.hasModul95) return false
        if (!form.experienceAsDriver) return false
        if (!form.experienceInLanguage) return false
        if (!form.zip) return false
        if (!form.startDate) return false
        if (!form.name) return false
        if (!form.phone) return false
        if (form.gdpr !== true) return false

        return true
    })

    const submit = () => {
        sendClick('funnel-submit', 'start')

        form.post(route('karriere.funnel.lkw-fahrer.store'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset()
                sendClick('funnel-submit', 'success')
            },
            onError: () => {
                sendClick('funnel-submit', 'error')
            },
        })
    }



    const sendClick = (objectString, type = '') => {
        
        const _etracker = window._etracker
        
        if (!_etracker) return
        
        console.log(objectString, type)

        _etracker.sendEvent(new et_ClickEvent(objectString, type))
    }
</script>

<style lang="sass" scoped>
    .form
        display: flex
        flex-direction: column
        gap: 2rem

    .form-step
        display: flex
        flex-direction: column
        gap: 1rem
        padding: 1rem
        background: var(--color-background-soft)
        border-radius: var(--radius-m)

        &.error
            border: 1px solid var(--color-error)

            .question
                color: var(--color-error)
                margin-bottom: 0

            > p
                margin-top: 0

        .question
            font-size: 1.5rem
            font-weight: 500
            text-align: center

        > p
            text-align: center

        .options
            display: flex
            gap: 1rem

            button
                flex: 1
                display: flex
                flex-direction: column
                align-items: center
                justify-content: center
                padding: 1rem
                border-radius: var(--radius-m)
                background: var(--color-background-soft)
                border: 1px solid var(--color-border)
                color: var(--color-text)
                font-size: 1.25rem
                font-weight: 500
                cursor: pointer
                user-select: none

                &:hover
                    background: var(--color-background)
                &.active
                    background: var(--color-primary)
                    border: 1px solid var(--color-background)
                    color: var(--color-background)
</style>