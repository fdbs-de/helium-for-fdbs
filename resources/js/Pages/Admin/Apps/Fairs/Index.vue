<template>
    <Head title="Messeanmeldungen Exportieren" />

    <AdminLayout title="Messeanmeldungen Exportieren">

        <div class="flex padding-block-4 h-center">
            <mui-button as="a" label="Messeanmeldungen exportieren" size="large" target="_blank" :href="route('admin.fairs.export')"/>
        </div>
    </AdminLayout>
</template>

<script setup>
    import { Head } from '@inertiajs/inertia-vue3'

    import AdminLayout from '@/Layouts/Admin.vue'
</script>

<style lang="sass" scoped>
</style>