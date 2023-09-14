<template>
    <AdminLayout title="Seiten Einstellungen">
        <div class="card flex vertical gap-1 padding-block-2">
            <form class="limiter text-limiter" @submit.prevent="update()">
                <div class="flex gap-1 vertical">
                    <ValidationErrors />
                    
                    <select v-model="form.apps_pages_root_type">
                        <option value="static">Statische Seite</option>
                        <option value="redirect">Weiterleitung</option>
                        <option value="route">Route Seite</option>
                    </select>
    
                    <IodInput v-model="form.apps_pages_root_link" label="Slug/URL/Route-Name" />
                    
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



    const props = defineProps({
        settings: Object,
        page: String,
    })



    const form = useForm({
        apps_pages_root_type: props.settings['apps.pages.root.type'] || 'static',
        apps_pages_root_link: props.settings['apps.pages.root.link'] || '',
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
</style>