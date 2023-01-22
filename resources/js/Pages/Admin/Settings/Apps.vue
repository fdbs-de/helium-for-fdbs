<template>
    <Head title="App Einstellungen" />

    <AdminLayout title="App Einstellungen">
        <div class="popup-block popup-error" v-if="hasErrors">
            <h3><b>Fehler!</b></h3>
            <p v-for="(error, key) in errors" :key="key">{{ error }}</p>
        </div>

        <div class="grid">
            <Card cover image="/images/app/applications/app_cover_blog.png" name="Blog" color="var(--color-app-blog-on-light)">
                <span>Die Blog-App erlaubt es, Blog-Beiträge auf der Website zu veröffentlichen.</span>
                <mui-button class="w-100" label="Aktivieren" size="large" v-if="form.apps.blog === false" @click="updateSettings('blog', true)"/>
                <mui-button class="w-100" label="Deaktivieren" size="large" variant="contained" color="error" v-if="form.apps.blog === true" @click="updateSettings('blog', false)"/>
            </Card>

            <Card cover image="/images/app/applications/app_cover_jobs.png" name="Jobs" color="var(--color-app-jobs-on-light)">
                <span>Die Jobs-App erlaubt es, Stellenangebote auf der Website zu veröffentlichen.</span>
                <mui-button class="w-100" label="Aktivieren" size="large" v-if="form.apps.jobs === false" @click="updateSettings('jobs', true)"/>
                <mui-button class="w-100" label="Deaktivieren" size="large" variant="contained" color="error" v-if="form.apps.jobs === true" @click="updateSettings('jobs', false)"/>
            </Card>

            <Card cover image="/images/app/applications/app_cover_intranet.png" name="Intranet" color="var(--color-app-intranet-on-light)">
                <span>Die Intranet-App erlaubt es, einen internen Bereich für Mitarbeiter einzurichten.</span>
                <mui-button class="w-100" label="Aktivieren" size="large" v-if="form.apps.intranet === false" @click="updateSettings('intranet', true)"/>
                <mui-button class="w-100" label="Deaktivieren" size="large" variant="contained" color="error" v-if="form.apps.intranet === true" @click="updateSettings('intranet', false)"/>
            </Card>
            
            <Card cover image="/images/app/applications/app_cover_wiki.png" name="Wiki" color="var(--color-app-wiki-on-light)">
                <span>Die Wiki-App erlaubt es, eine interne Wissensdatenbank einzurichten.</span>
                <mui-button class="w-100" label="Aktivieren" size="large" v-if="form.apps.wiki === false" @click="updateSettings('wiki', true)"/>
                <mui-button class="w-100" label="Deaktivieren" size="large" variant="contained" color="error" v-if="form.apps.wiki === true" @click="updateSettings('wiki', false)"/>
            </Card>
        </div>
    </AdminLayout>
</template>

<script setup>
    import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { ref, computed, watch } from 'vue'

    import AdminLayout from '@/Layouts/Admin.vue'
    import Card from '@/Components/Page/Card.vue'

    const props = defineProps({
        settings: Object,
    })



    const form = useForm({
        apps: {
            blog: false,
            jobs: false,
            intranet: false,
            wiki: false,
        },
    })



    const openItem = () => {
        form.apps.blog = props?.settings['apps.enabled.blog'] || false
        form.apps.jobs = props?.settings['apps.enabled.jobs'] || false
        form.apps.intranet = props?.settings['apps.enabled.intranet'] || false
        form.apps.wiki = props?.settings['apps.enabled.wiki'] || false
    }

    watch((props) => props?.settings, () => {
        openItem(props?.settings)
    },{
        immediate: true,
        deep: true
    })

    const updateSettings = (app, state) => {
        form.apps[app] = state
        
        form.patch(route('admin.settings.update.apps'), {
            preserveScroll: true,
        })
    }


    
    
    // START: Error Handling
    const errors = computed(() => usePage().props.value.errors)
    const hasErrors = computed(() => Object.keys(errors.value).length > 0)
    // END: Error Handling
</script>

<style lang="sass" scoped>
    .grid
        display: grid
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr))
        gap: 1rem
</style>