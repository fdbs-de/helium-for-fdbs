<template>
    <Head title="Profil" />

    <DashboardSubLayout title="Übersicht" area="Loginbereich">
        <div class="welcome-wrapper">
            <h1 class="margin-top-0">Hey! 👋</h1>
            <p>
                Herzlich willkommen im neuen Loginbereich vom FDBS.<br>
                Im Loginbereich können Sie auf die Spezi-Datenbank zugreifen,<br>
                Informationen im Intranet nachlesen, unsere aktuellsten Angebote durchstöbern und vieles mehr.
            </p>
            
            <!-- <BlogInput v-model="v1" />
            <p v-html="v1"></p>
            <p>{{v1}}</p> -->

            <!-- <div class="flex wrap gap-2 margin-top-2">
                <mui-button :as="Link" :href="route('dashboard.employee.overview')" v-if="$page.props.auth.user.employee_profile" label="Zum Intranet"/>
                <mui-button :as="Link" :href="route('dashboard.customer.specs')" v-if="$page.props.auth.user.customer_profile" label="Zur Spezi-Datenbank"/>
                <mui-button :as="Link" :href="route('dashboard.profile')" variant="contained" label="Zum Profil"/>
            </div> -->
        </div>
    </DashboardSubLayout>
</template>

<script setup>
    import Tag from '@/Components/Form/Tag.vue'
    import Popup from '@/Components/Form/Popup.vue'
    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
    import BlogInput from '@/Components/Form/BlogInput.vue'

    import { Head, Link, usePage, useForm } from '@inertiajs/inertia-vue3'
    import { ref, computed } from 'vue'

    const v1 = ref('')
</script>

<style lang="sass" scoped>
    .welcome-wrapper
        margin-bottom: 2rem
        padding: 2rem
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-xl)

        h1
            font-size: 4rem
            margin: 0
            font-weight: 700
</style>