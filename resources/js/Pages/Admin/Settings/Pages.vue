<template>
    <AdminLayout title="Seiten Einstellungen">
        <div class="card flex vertical gap-1 padding-block-2">
            <form class="limiter text-limiter" @submit.prevent="update()">
                <div class="flex gap-1 vertical">
                    <ValidationErrors />
    
                    <IodInput v-model="form.site_name" label="Seitenname" />
                    <IodInput v-model="form.site_slogan" label="Slogan" />
                    <IodInput v-model="form.site_domain" label="Domain" placeholder="example.com" />
                    <IodInput v-model="form.site_description" label="Seitenbeschreibung" />
    
                    <select v-model="form.site_language">
                        <option value="de">Deutsch</option>
                        <option value="en">English</option>
                    </select>
                    
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
        site_name: props.settings['site.name'] || '',
        site_slogan: props.settings['site.slogan'] || '',
        site_domain: props.settings['site.domain'] || '',
        site_description: props.settings['site.description'] || '',
        site_language: props.settings['site.language'] || 'de',
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