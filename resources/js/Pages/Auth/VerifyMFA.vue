<template>
    <FormSubLayout title="Zweiten Faktor bestätigen" :status="status" @submit="submit">
        <Head title="Zweiten Faktor bestätigen – FDBS Loginbereich" />

        <p>
            Bitte verwenden Sie die Authentifizierungs-App, die Sie für die 2-Faktor-Authentifizierung eingerichtet haben, um
            den Bestätigungscode einzugeben.
        </p>

        <OTPInput ref="otpInput" :length="6" :dividers="[3]" v-model="form.otp" autofocus @complete="submit"/>

        <div class="flex v-center">
            <div class="spacer"></div>
            <IodButton label="Bestätigen" :loading="form.processing"/>
        </div>
    </FormSubLayout>
</template>

<script setup>
    import { ref } from 'vue'
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
    
    import FormSubLayout from '@/Layouts/SubLayouts/Form.vue'
    import OTPInput from '@/Components/Form/OTPInput.vue'



    defineProps({
        status: String,
    })

    const form = useForm({
        otp: '',
    })
    const otpInput = ref(null)

    const submit = () => {
        form.post(route('mfa.verify'), {
            onError() {
                otpInput.value.clear()
            }
        })
    }
</script>

<style lang="sass" scoped>
    .checkbox
        --mui-background: var(--color-background)
</style>