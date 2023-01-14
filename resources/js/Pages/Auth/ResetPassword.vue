<template>
    <FormSubLayout title="Passwort zurücksetzen" @submit="submit">
        <Head title="Passwort zurücksetzen – FDBS Loginbereich" />

        <mui-input type="email" label="Email *" v-model="form.email" required autocomplete="username"/>
        <mui-input type="password" label="Passwort *" v-model="form.password" show-password-score required autocomplete="new-password"/>

        <div class="flex center">
            <div class="spacer"></div>
            <mui-button label="Passwort zurücksetzen" :loading="form.processing"/>
        </div>
    </FormSubLayout>
</template>

<script setup>
    import FormSubLayout from '@/Layouts/SubLayouts/Form.vue'
    import { Head, useForm } from '@inertiajs/inertia-vue3'
    import zxcvbn from 'zxcvbn'
    
    window.zxcvbn = zxcvbn

    const props = defineProps({
        email: String,
        token: String,
    })

    const form = useForm({
        token: props.token,
        email: props.email,
        password: '',
    })

    const submit = () => {
        form.post(route('password.update'), {
            onFinish: () => form.reset('password', 'password_confirmation'),
        })
    }
</script>
