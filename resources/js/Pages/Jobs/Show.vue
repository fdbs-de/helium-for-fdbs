<template>
    <TextSubLayout :title="'Stellenangebot: '+post.title" image="/images/content/banner/karriere_513169496_482949832.webp" has-small-limiter>
        <Head>
            <title>Stellenangebot: {{post.title}}</title>
        </Head>

        <div class="flex wrap gap-1 margin-bottom-2">
            <Tag v-if="post.category">Type: {{post.category.name}}</Tag>
            <Tag v-for="tag in post.tags" :key="tag">{{tag}}</Tag>
        </div>

        <div class="formatted-content" v-html="post.content"></div>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import Tag from '@/Components/Form/Tag.vue'

    const props = defineProps({
        post: Object,
    })
</script>