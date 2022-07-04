<template>
    <FormSubLayout title="Kunden-Registrierung" :status="status" @submit="submit">
        <Head title="Kunden-Registrierung" />

        <span>
            Ihre Registrierung muss, nach der Prüfung Ihrer angegebenen Daten, von einem unserer Administratoren freigeschaltet werden.
            Sie erhalten dazu <b>zwei Mails</b> an die angegebene E-Mailadresse. Die Freischaltung erfolgt in der Regel <b>innerhalb eines Werktages</b>.
        </span>

        <!-- <div class="divider"></div>

        <div class="option-wrapper">
            <label class="option" role="checkbox" :aria-checked="form.is_customer" @keydown.space.enter.prevent="form.is_customer = !form.is_customer" tabindex="0">
                <input type="checkbox" v-model="form.is_customer" class="input">
                <div class="icon" aria-hidden="true">shopping_cart</div>
                <span>Ich bin Kunde</span>
            </label>

            <label class="option" role="checkbox" :aria-checked="form.is_employee" @keydown.space.enter.prevent="form.is_employee = !form.is_employee" tabindex="0">
                <input type="checkbox" v-model="form.is_employee" class="input">
                <div class="icon" aria-hidden="true">work</div>
                <span>Ich bin Mitarbeiter</span>
            </label>
        </div> -->

        <div class="divider"></div>

        <b>Angaben zu Ihrem FDBS Account</b>
        <mui-input type="email" no-border label="Email *" v-model="form.email" required autocomplete="username"/>
        <mui-input type="password" no-border show-password-score label="Passwort wählen *" v-model="form.password" required autocomplete="new-password"/>
        
        <div v-if="form.is_customer" class="divider"></div>
        
        <b v-if="form.is_customer">Angaben als Kunde</b>
        <mui-input v-if="form.is_customer" type="text" no-border label="Firma *" v-model="form.customer.company" required autocomplete="company"/>
        <mui-input v-if="form.is_customer" type="text" no-border label="Kundennummer *" v-model="form.customer.customer_id" required autocomplete="customer-id"/>
        
        <!-- <div v-if="form.is_employee" class="divider"></div>
        
        <b v-if="form.is_employee">Angaben als Mitarbeiter*in</b>
        <mui-input v-if="form.is_employee" type="text" no-border label="Vorname *" v-model="form.employee.first_name" required autocomplete="firstname"/>
        <mui-input v-if="form.is_employee" type="text" no-border label="Nachname *" v-model="form.employee.last_name" required autocomplete="lastname"/> -->

        <div class="divider"></div>

        <div class="flex center">
            <mui-toggle type="checkbox" class="checkbox" no-border v-model="form.terms">
                <template #appendLabel>
                    <span>
                        Ich habe die <a target="_blank" :href="route('datenschutz')">Datenschutzerklärung</a> und die
                        <a target="_blank" :href="route('agbs')">AGBs</a> gelesen und akzeptiere diese.
                    </span>
                </template>
            </mui-toggle>
            <div class="spacer"></div>
            <mui-button type="submit" label="Registrieren" :disabled="!isValid" :loading="form.processing"/>
        </div>

        <div class="divider"></div>

        <div class="flex center">
            <Link :href="route('login')">Sie haben bereits ein Konto?</Link>
            <div class="spacer"></div>
        </div>
    </FormSubLayout>
</template>

<script setup>
import FormSubLayout from '@/Layouts/SubLayouts/Form.vue'
import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
import zxcvbn from 'zxcvbn'
import { computed } from 'vue'

window.zxcvbn = zxcvbn

defineProps({
    status: String,
})



const isValid = computed(() => {
    if (!form.is_customer && !form.is_employee) return false

    if (form.password.length < 8) return false

    if (form.is_customer) {
        if (!form.customer.company.length) return false
        if (!form.customer.customer_id.length) return false
    }

    // if (form.is_employee) {
    //     if (!form.employee.first_name.length) return false
    //     if (!form.employee.last_name.length) return false
    // }

    if (!form.terms) return false

    return true
})



const form = useForm({
    is_customer: true,
    is_employee: false,
    email: '',
    password: '',
    customer: {
        company: '',
        customer_id: '',
    },
    employee: {
        first_name: '',
        last_name: '',
    },
    terms: false,
})

const submit = () => {
    if (!isValid.value) return

    form.post(route('registrieren'), {
        onFinish: () => form.reset('password'),
    })
}
</script>

<style lang="sass" scoped>
    .checkbox
        --mui-background: var(--color-background)

    .option-wrapper
        display: flex
        gap: var(--su)

        .option
            flex: 1
            display: flex
            align-items: center
            flex-direction: column
            background: var(--color-background-soft)
            border-radius: calc(var(--su) * .5)
            padding: var(--su)
            gap: .75rem
            cursor: pointer
            user-select: none
            transition: all 100ms ease-in-out

            &[aria-checked="true"]
                background: var(--color-primary)
                color: var(--color-background)

            .icon
                font-family: var(--font-icon)
                font-size: 2rem
                line-height: 1

            .input
                display: none

            > span
                line-height: 1
                text-align: center

</style>
