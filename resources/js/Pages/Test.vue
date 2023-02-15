<template>
    <TextSubLayout title="Form Test" has-small-limiter>
        <Head>
            <title>TEST – FDBS</title>
        </Head>

        <FrontendForm :form="form" />
    </TextSubLayout>
</template>

<script setup>
    import { Head } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import FrontendForm from '@/Components/Apps/Forms/Frontend/Form.vue'

    const props = defineProps({
        form: Object,
    })
</script>