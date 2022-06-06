<template>
    <FormSubLayout title="Kunden-Registrierung" :status="status" @submit="submit">
        <Head title="Kunden-Registrierung" />

        <span>
            Ihre Registrierung muss, nach der Prüfung Ihrer angegebenen Daten, von einem unserer Administratoren freigeschaltet werden.
            Sie erhalten dazu <b>zwei Mails</b> an die angegebene E-Mailadresse. Die Freischaltung erfolgt in der Regel <b>innerhalb eines Werktages</b>.
        </span>

        <div class="divider"></div>

        <mui-input type="text" no-border label="Name oder Firma" v-model="form.name" required autocomplete="name"/>
        <mui-input type="text" no-border label="Kundennummer" v-model="form.customer_id" required autocomplete="customer-id"/>
        <mui-input type="email" no-border label="Email" v-model="form.email" required autocomplete="username"/>
        <mui-input type="password" no-border label="Passwort vergeben" v-model="form.password" required autocomplete="new-password"/>

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
            <mui-button type="submit" label="Registrieren" :loading="form.processing"/>
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

const form = useForm({
    name: '',
    customer_id: '',
    email: '',
    password: '',
    terms: false,
})

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password'),
    })
}
</script>

<style lang="sass" scoped>
    .checkbox
        --mui-background: var(--color-background)
</style>
