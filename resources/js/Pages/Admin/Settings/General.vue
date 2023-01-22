<template>
    <Head title="Allgemeine Einstellungen" />

    <AdminLayout title="Allgemeine Einstellungen">
        <div class="card flex vertical gap-1 padding-block-2">
            <form class="limiter text-limiter flex vertical gap-1" @submit.prevent="updateSettings()">
                <div class="popup-block popup-error" v-if="hasErrors">
                    <h3><b>Fehler!</b></h3>
                    <p v-for="(error, key) in errors" :key="key">{{ error }}</p>
                </div>

                <mui-input v-model="form.site.name" label="Seitenname" />
                <mui-input v-model="form.site.slogan" label="Slogan" />
                <mui-input v-model="form.site.domain" label="Domain" placeholder="example.com" />
                <mui-input type="textarea" v-model="form.site.description" label="Seitenbeschreibung" />

                <select v-model="form.site.language">
                    <option value="de">Deutsch</option>
                    <option value="en">English</option>
                </select>
                
                <mui-button label="Einstellungen Speichern" size="large" :loading="form.processing"/>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
    import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { ref, computed, watch } from 'vue'

    import AdminLayout from '@/Layouts/Admin.vue'

    const props = defineProps({
        settings: Object,
    })



    const form = useForm({
        site: {
            name: '',
            slogan: '',
            domain: '',
            description: '',
            language: 'de',
        },
    })



    const openItem = () => {
        form.site.domain = props?.settings['site.domain'] || ''
        form.site.name = props?.settings['site.name'] || ''
        form.site.slogan = props?.settings['site.slogan'] || ''
        form.site.description = props?.settings['site.description'] || ''
        form.site.language = props?.settings['site.language'] || 'de'
    }

    watch((props) => props?.settings, () => {
        openItem(props?.settings)
    },{
        immediate: true,
        deep: true
    })

    const updateSettings = () => {
        form.patch(route('admin.settings.update.general'), {
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
</style>