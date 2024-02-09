<template>
    <FormSubLayout title="Zweiten Faktor bestätigen" :status="status" @submit="submit">
        <Head title="Zweiten Faktor bestätigen – FDBS Loginbereich" />

        <IodInput label="Code" v-model="form.otp" required/>

        <div class="flex v-center">
            <div class="spacer"></div>
            <IodButton label="Bestätigen" :loading="form.processing"/>
        </div>
    </FormSubLayout>
</template>

<script setup>
    import FormSubLayout from '@/Layouts/SubLayouts/Form.vue'
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3'

    defineProps({
        status: String,
    })

    const form = useForm({
        otp: '',
    })

    const submit = () => {
        form.post(route('mfa.verify'))
    }
</script>

<style lang="sass" scoped>
    .checkbox
        --mui-background: var(--color-background)
</style>