<template>
    <FormSubLayout title="Anmeldung" :status="status" @submit="submit">
        <Head title="Anmeldung – FDBS Loginbereich" />

        <mui-input type="email" label="Email" v-model="form.email" required autocomplete="username"/>
        <mui-input type="password" label="Passwort" v-model="form.password" required autocomplete="current-password"/>

        <div class="flex center">
            <mui-toggle type="checkbox" class="checkbox" label="Angemeldet bleiben" v-model="form.remember"/>
            <div class="spacer"></div>
            <mui-button label="Anmelden" :loading="form.processing"/>
        </div>

        <div class="divider"></div>

        <div class="flex center gap">
            <Link :href="route('registrieren')">Noch kein Konto?</Link>
            <Link v-if="canResetPassword" :href="route('password.request')">Passwort vergessen?</Link>
        </div>
    </FormSubLayout>
</template>

<script setup>
    import FormSubLayout from '@/Layouts/SubLayouts/Form.vue'
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3'

    defineProps({
        canResetPassword: Boolean,
        status: String,
    })

    const form = useForm({
        email: '',
        password: '',
        remember: false
    })

    const submit = () => {
        form.post(route('login'), {
            onFinish: () => form.reset('password'),
        })
    }
</script>

<style lang="sass" scoped>
    .checkbox
        --mui-background: var(--color-background)
</style>