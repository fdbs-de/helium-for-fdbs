<template>
    <TextSubLayout :title="post.title" image="/images/content/banner/karriere_513169496_482949832.webp" has-small-limiter>
        <Head>
            <title>{{post.title}} – FDBS Karriere</title>
        </Head>
        
        <div class="flex margin-bottom-2" v-if="post.tags.map(e => e.toLowerCase()).includes('schnellbewerbung')">
            <mui-button as="a" class="flex-1" size="large" label="Jetzt in unter 1 Minute bewerben" :href="route('karriere.funnel.lkw-fahrer')" />
        </div>

        <div class="flex wrap gap-1 v-center margin-bottom-4">
            <Tag v-if="post.category" :style="'color: '+post.category.color || 'gray'" :icon="post.category.icon || 'category'" shape="pill">{{post.category.name}}</Tag>
            <Tag v-for="tag in post.tags" :key="tag" style="color: var(--color-text);" shape="pill">{{tag}}</Tag>
        </div>

        <div class="formatted-content" v-html="post.content"></div>

        <div class="flex margin-top-4" v-if="post.tags.map(e => e.toLowerCase()).includes('schnellbewerbung')">
            <mui-button as="a" class="flex-1" size="large" label="Jetzt in unter 1 Minute bewerben" :href="route('karriere.funnel.lkw-fahrer')" />
        </div>
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