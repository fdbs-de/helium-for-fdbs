<template>
    <TextSubLayout title="Blog" image="/images/content/banner/rechtliches_437198485.webp" has-small-limiter>
        <Head>
            <title>FDBS Blog</title>
        </Head>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'

    const props = defineProps({
        post: Object,
    })
</script>