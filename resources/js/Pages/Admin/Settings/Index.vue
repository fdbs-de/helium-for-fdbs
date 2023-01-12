<template>
    <Head title="Globale Einstellungen" />

    <AdminLayout title="Globale Einstellungen">
        <div class="card flex vertical gap-1 padding-block-2">
            <form class="limiter text-limiter flex vertical gap-4" @submit.prevent="updateSettings()">
                <div class="popup-block popup-error" v-if="hasErrors">
                    <h3><b>Fehler!</b></h3>
                    <p v-for="(error, key) in errors" :key="key">{{ error }}</p>
                </div>

                <fieldset class="flex vertical gap-1">
                    <legend>Seiten Einstellungen</legend>
                
                    <mui-input v-model="form.site.name" label="Seitenname" />
                    <mui-input v-model="form.site.slogan" label="Slogan" />
                    <mui-input v-model="form.site.domain" label="Domain" placeholder="example.com" />
                    <mui-input type="textarea" v-model="form.site.description" label="Seitenbeschreibung" />

                    <select v-model="form.site.language">
                        <option value="de">Deutsch</option>
                        <option value="en">English</option>
                    </select>
                </fieldset>

                <fieldset class="flex vertical gap-1">
                    <legend>Rechtliches</legend>
                
                    <TextEditor class="text-editor" label="Disclaimer unter dem Impressum" v-model="form.legal.disclaimer"/>
                </fieldset>

                <fieldset class="flex vertical gap-1">
                    <legend>Apps aktivieren</legend>

                    <mui-toggle class="checkbox" type="switch" v-model="form.apps.blog">
                        <template #label>
                            <b>Blog</b><br>
                            <span>Die Blog-App erlaubt es, Blog-Beiträge auf der Website zu veröffentlichen.</span>
                        </template>
                    </mui-toggle>

                    <mui-toggle class="checkbox" type="switch" v-model="form.apps.jobs">
                        <template #label>
                            <b>Jobs</b><br>
                            <span>Die Jobs-App erlaubt es, Stellenangebote auf der Website zu veröffentlichen.</span>
                        </template>
                    </mui-toggle>

                    <mui-toggle class="checkbox" type="switch" v-model="form.apps.intranet">
                        <template #label>
                            <b>Intranet</b><br>
                            <span>Die Intranet-App erlaubt es, einen internen Bereich für Mitarbeiter einzurichten.</span>
                        </template>
                    </mui-toggle>

                    <mui-toggle class="checkbox" type="switch" v-model="form.apps.wiki">
                        <template #label>
                            <b>Wiki</b><br>
                            <span>Die Wiki-App erlaubt es, eine interne Wissensdatenbank einzurichten.</span>
                        </template>
                    </mui-toggle>
                </fieldset>

                <div class="flex v-center gap-1">
                    <div class="spacer"></div>
                    <mui-button label="Einstellungen Speichern" size="large" :loading="form.processing"/>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
    import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { ref, computed, watch } from 'vue'

    import AdminLayout from '@/Layouts/Admin.vue'
    import Switcher from '@/Components/Form/Switcher.vue'
    import IconButton from '@/Components/Form/IconButton.vue'
    import TextEditor from '@/Components/Form/TextEditor.vue'

    const props = defineProps({
        settings: Array,
    })



    const form = useForm({
        apps: {
            blog: false,
            jobs: false,
            intranet: false,
            wiki: false,
        },
        site: {
            name: '',
            slogan: '',
            domain: '',
            description: '',
            language: 'de',
        },
        legal: {
            disclaimer: '',
            privacy: '',
        }
    })



    const openItem = () => {
        form.apps.blog = props?.settings['apps.enabled.blog'] || false
        form.apps.jobs = props?.settings['apps.enabled.jobs'] || false
        form.apps.intranet = props?.settings['apps.enabled.intranet'] || false
        form.apps.wiki = props?.settings['apps.enabled.wiki'] || false
        
        form.site.domain = props?.settings['site.domain'] || ''
        form.site.name = props?.settings['site.name'] || ''
        form.site.slogan = props?.settings['site.slogan'] || ''
        form.site.description = props?.settings['site.description'] || ''
        form.site.language = props?.settings['site.language'] || 'de'

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