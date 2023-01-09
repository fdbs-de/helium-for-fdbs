<template>
    <Head title="Admin-Übersicht" />

    <AdminLayout title="Admin-Übersicht">
        <div class="layout">
            <div class="card main-card">
                <h1 class="margin-top-0">Hee, du... Admin-Mensch</h1>
                <p>
                    Hier ist eine Übersicht. Sie zeigt dir viele Informationen, wie bspw. ... gar nichts.<br>
                    Viel Spaß!
                </p>
            </div>
            <div class="card"></div>
            <div class="card"></div>
        </div>
    </AdminLayout>
</template>

<script setup>
    import { Head } from '@inertiajs/inertia-vue3'
    import { ref } from 'vue'

    import AdminLayout from '@/Layouts/Admin.vue'
</script>

<style lang="sass" scoped>
    .layout
        display: grid
        grid-template-columns: 1fr 1fr
        gap: 2rem

    .card
        padding: 2rem
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-m)

        h1
            font-size: 2rem
            margin: 0
            font-weight: 700

    .main-card
        grid-column: span 2
</style>