<template>
    <AdminLayout title="Rechtliche Einstellungen">
        <div class="card flex vertical gap-1 padding-block-2">
            <form class="limiter text-limiter" @submit.prevent="update()">
                <div class="flex vertical gap-1">
                    <ValidationErrors />
                    
                    <TextEditor class="text-editor" label="Disclaimer unter dem Impressum" v-model="form.legal_disclaimer"/>
                
                    <IodButton label="Einstellungen Speichern" size="large" :loading="form.processing"/>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
    import { useForm } from '@inertiajs/inertia-vue3'

    import AdminLayout from '@/Layouts/Admin.vue'
    import ValidationErrors from '@/Components/ValidationErrors.vue'
    import TextEditor from '@/Components/Form/TextEditor.vue'

    

    const props = defineProps({
        settings: Object,
        page: String,
    })



    const form = useForm({
        legal_disclaimer: props.settings['legal.disclaimer'] || '',
        legal_privacy: props.settings['legal.privacy'] || '',
    })

    const update = () => {
        form.patch(route('admin.settings.update', props.page), { preserveScroll: true, })
    }
</script>

<style lang="sass" scoped>
    .card
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-m)

    .text-editor
        min-height: 25rem
</style>