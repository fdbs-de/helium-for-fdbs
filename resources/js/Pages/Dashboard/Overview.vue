<template>
    <Head title="Profil" />

    <DashboardSubLayout title="Übersicht">
        <div class="welcome-wrapper">
            <h1 class="margin-top-0">Hey! 👋</h1>
            <p>
                Herzlich willkommen im neuen Loginbereich vom FDBS.<br>
                Im Loginbereich können Sie auf die Spezi-Datenbank zugreifen,<br>
                Informationen im Intranet nachlesen, unsere aktuellsten Angebote durchstöbern und vieles mehr.
            </p>
        </div>
    </DashboardSubLayout>
</template>

<script setup>
    import { Head } from '@inertiajs/inertia-vue3'
    
    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
</script>

<style lang="sass" scoped>
    .welcome-wrapper
        margin-bottom: 2rem
        padding: 2rem
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-xl)

        h1
            font-size: 4rem
            margin: 0
            font-weight: 700
</style>