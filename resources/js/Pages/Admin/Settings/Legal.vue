<template>
    <Head title="Rechtliche Einstellungen" />

    <AdminLayout title="Rechtliche Einstellungen">
        <div class="card flex vertical gap-1 padding-block-2">
            <form class="limiter text-limiter flex vertical gap-1" @submit.prevent="updateSettings()">
                <div class="popup-block popup-error" v-if="hasErrors">
                    <h3><b>Fehler!</b></h3>
                    <p v-for="(error, key) in errors" :key="key">{{ error }}</p>
                </div>
                
                <TextEditor class="text-editor" label="Disclaimer unter dem Impressum" v-model="form.legal.disclaimer"/>
            
                <mui-button label="Einstellungen Speichern" size="large" :loading="form.processing"/>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
    import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { ref, computed, watch } from 'vue'

    import AdminLayout from '@/Layouts/Admin.vue'
    import TextEditor from '@/Components/Form/TextEditor.vue'

    const props = defineProps({
        settings: Object,
    })



    const form = useForm({
        legal: {
            disclaimer: '',
            privacy: '',
        }
    })



    const openItem = () => {
        form.legal.disclaimer = props?.settings['legal.disclaimer'] || ''
    }

    watch((props) => props?.settings, () => {
        openItem(props?.settings)
    },{
        immediate: true,
        deep: true
    })

    const updateSettings = () => {
        form.patch(route('admin.settings.update'), {
            onSuccess: (data) => {
                // openItem(data?.props?.post)
            },
        })
    }


    
    
    // START: Error Handling
    const errors = computed(() => usePage().props.value.errors)
    const hasErrors = computed(() => Object.keys(errors.value).length > 0)
    // END: Error Handling
</script>

<style lang="sass" scoped>
    .card
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-m)

    .text-editor
        min-height: 25rem
</style>