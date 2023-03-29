<template>
    <AdminLayout title="Globale Einstellungen">
        <div class="card flex vertical gap-1 padding-block-2">
            <form class="limiter text-limiter flex vertical gap-1" @submit.prevent="generateMediaCache()">
                <ValidationErrors />

                <mui-toggle class="checkbox" v-model="form.disclaimer">
                    <template #label>
                        <span style="line-height: 1.75;">
                            Ich habe verstanden, dass das erneuern des Medien Cache Metadaten
                            wie die Beschreibung oder den Alt-Text einzelner Dateien zurücksetzen kann.
                        </span>
                    </template>
                </mui-toggle>

                <mui-button label="Medien Cache erneuern" size="large" :disabled="!form.disclaimer" :loading="form.processing"/>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
    import { useForm } from '@inertiajs/inertia-vue3'

    import AdminLayout from '@/Layouts/Admin.vue'
    import ValidationErrors from '@/Components/ValidationErrors.vue'



    const props = defineProps({
        settings: Object,
        page: String,
    })



    const form = useForm({
        disclaimer: false,
    })
    
    const generateMediaCache = async () => {
        form.patch(route('admin.media.generate.cache'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset('disclaimer')
            },
        })
    }
</script>

<style lang="sass" scoped>
    .card
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-m)
</style>