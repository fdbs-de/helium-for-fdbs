<template>
    <FormSubLayout title="Passwort vergessen" :status="status" @submit="submit">
        <Head title="Passwort vergessen" />

        <span>
            <b>Sie haben Ihr Passwort vergessen? Kein Problem!</b><br>
            Geben Sie uns einfach Ihre E-Mail-Adresse und wir werden Ihnen einen Link zum Zurücksetzen Ihres Passworts schicken.
        </span>

        <div class="divider"></div>

        <mui-input type="email" label="Email" v-model="form.email" required autocomplete="username"/>

        <div class="flex center">
            <div class="spacer"></div>
            <mui-button label="Passwort wiederherstellen" :loading="form.processing"/>
        </div>
    </FormSubLayout>
</template>

<script setup>
import FormSubLayout from '@/Layouts/SubLayouts/Form.vue'
import { Head, useForm } from '@inertiajs/inertia-vue3'

defineProps({
    status: String,
})

const form = useForm({
    email: '',
})

const submit = () => {
    form.post(route('password.email'))
}
</script>