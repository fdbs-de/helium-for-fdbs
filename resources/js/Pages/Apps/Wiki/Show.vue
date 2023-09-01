<template>
    <WikiLayout :backlink="route('wiki')" backlink-text="Zurück zur Übersicht" :image="post.image">
        <Head>
            <title>{{post.title}} – FDBS Wiki</title>
        </Head>

        <div class="card padding-block-2">
            <div class="limiter text-limiter">
                <h1>{{post.title}}</h1>

                <div class="flex gap-1 v-center wrap" v-if="post.post_category || post.tags">
                    <Tag v-if="post.post_category" :style="'color: '+post.post_category.color || 'gray'" :icon="post.post_category.icon || 'category'" shape="pill">{{post.post_category.name}}</Tag>
                    <Tag v-if="post.status !== 'published'" style="color: var(--color-error)" shape="pill">Nicht veröffentlicht</Tag>
                    <Tag v-for="tag in post.tags" :key="tag" style="color: var(--color-text-soft);" shape="pill">{{tag}}</Tag>
                </div>
    
                <div class="formatted-content" v-html="post.content"></div>
            </div>
        </div>
    </WikiLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import { ref } from 'vue'

    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import WikiLayout from '@/Layouts/Wiki.vue'
    import Tag from '@/Components/Form/Tag.vue'

    const props = defineProps({
        post: Object,
    })
</script>

<style lang="sass" scoped>
    .card
        background: var(--color-background)
        border-radius: var(--radius-m)
        box-shadow: var(--shadow-elevation-low)

        h1
            font-size: clamp(1.5rem, 5vw, 2rem)
            font-weight: 600
            margin: 0
            margin-bottom: 2rem
</style>