<template>
    <AdminLayout title="App Einstellungen">
        <ValidationErrors />

        <div class="grid">
            <Card cover image="/images/app/applications/app_cover_pages.png" name="Pages" color="var(--color-app-pages-on-light)">
                <span>Folgt</span>
                <mui-button class="w-100" label="Aktivieren" size="large" v-if="form.apps_blog_enabled === false" @click="update('blog', true)"/>
                <mui-button class="w-100" label="Deaktivieren" size="large" variant="contained" color="error" v-if="form.apps_blog_enabled === true" @click="update('blog', false)"/>
            </Card>

            <Card cover image="/images/app/applications/app_cover_blog.png" name="Blog" color="var(--color-app-blog-on-light)">
                <span>Die Blog-App erlaubt es, Blog-Beiträge auf der Website zu veröffentlichen.</span>
                <mui-button class="w-100" label="Aktivieren" size="large" v-if="form.apps_blog_enabled === false" @click="update('blog', true)"/>
                <mui-button class="w-100" label="Deaktivieren" size="large" variant="contained" color="error" v-if="form.apps_blog_enabled === true" @click="update('blog', false)"/>
            </Card>

            <Card cover image="/images/app/applications/app_cover_forms.png" name="Forms" color="var(--color-app-forms-on-light)">
                <span>Folgt</span>
                <mui-button class="w-100" label="Aktivieren" size="large" v-if="form.apps_blog_enabled === false" @click="update('blog', true)"/>
                <mui-button class="w-100" label="Deaktivieren" size="large" variant="contained" color="error" v-if="form.apps_blog_enabled === true" @click="update('blog', false)"/>
            </Card>

            <Card cover image="/images/app/applications/app_cover_ecommerce.png" name="Ecommerce" color="var(--color-app-ecommerce-on-light)">
                <span>Folgt</span>
                <mui-button class="w-100" label="Aktivieren" size="large" v-if="form.apps_blog_enabled === false" @click="update('blog', true)"/>
                <mui-button class="w-100" label="Deaktivieren" size="large" variant="contained" color="error" v-if="form.apps_blog_enabled === true" @click="update('blog', false)"/>
            </Card>

            <Card cover image="/images/app/applications/app_cover_jobs.png" name="Jobs" color="var(--color-app-jobs-on-light)">
                <span>Die Jobs-App erlaubt es, Stellenangebote auf der Website zu veröffentlichen.</span>
                <mui-button class="w-100" label="Aktivieren" size="large" v-if="form.apps_jobs_enabled === false" @click="update('jobs', true)"/>
                <mui-button class="w-100" label="Deaktivieren" size="large" variant="contained" color="error" v-if="form.apps_jobs_enabled === true" @click="update('jobs', false)"/>
            </Card>

            <Card cover image="/images/app/applications/app_cover_intranet.png" name="Intranet" color="var(--color-app-intranet-on-light)">
                <span>Die Intranet-App erlaubt es, einen internen Bereich für Mitarbeiter einzurichten.</span>
                <mui-button class="w-100" label="Aktivieren" size="large" v-if="form.apps_intranet_enabled === false" @click="update('intranet', true)"/>
                <mui-button class="w-100" label="Deaktivieren" size="large" variant="contained" color="error" v-if="form.apps_intranet_enabled === true" @click="update('intranet', false)"/>
            </Card>
            
            <Card cover image="/images/app/applications/app_cover_wiki.png" name="Wiki" color="var(--color-app-wiki-on-light)">
                <span>Die Wiki-App erlaubt es, eine interne Wissensdatenbank einzurichten.</span>
                <mui-button class="w-100" label="Aktivieren" size="large" v-if="form.apps_wiki_enabled === false" @click="update('wiki', true)"/>
                <mui-button class="w-100" label="Deaktivieren" size="large" variant="contained" color="error" v-if="form.apps_wiki_enabled === true" @click="update('wiki', false)"/>
            </Card>

            <Card cover image="/images/app/applications/app_cover_marketing.png" name="Marketing" color="var(--color-app-marketing-on-light)">
                <span>Folgt</span>
                <mui-button class="w-100" label="Aktivieren" size="large" v-if="form.apps_blog_enabled === false" @click="update('blog', true)"/>
                <mui-button class="w-100" label="Deaktivieren" size="large" variant="contained" color="error" v-if="form.apps_blog_enabled === true" @click="update('blog', false)"/>
            </Card>
        </div>
    </AdminLayout>
</template>

<script setup>
    import { useForm } from '@inertiajs/inertia-vue3'

    import AdminLayout from '@/Layouts/Admin.vue'
    import ValidationErrors from '@/Components/ValidationErrors.vue'
    import Card from '@/Components/Page/Card.vue'



    const props = defineProps({
        settings: Object,
        page: String,
    })



    const form = useForm({
        apps_blog_enabled: props?.settings['apps.blog.enabled'] || false,
        apps_jobs_enabled: props?.settings['apps.jobs.enabled'] || false,
        apps_intranet_enabled: props?.settings['apps.intranet.enabled'] || false,
        apps_wiki_enabled: props?.settings['apps.wiki.enabled'] || false,
    })

    const update = (app, state) => {
        form[`apps_${app}_enabled`] = state
        form.patch(route('admin.settings.update', props.page), { preserveScroll: true, })
    }
</script>

<style lang="sass" scoped>
    .grid
        display: grid
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr))
        gap: 1rem
</style>