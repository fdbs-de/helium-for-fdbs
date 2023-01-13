<template>
    <TextSubLayout title="FDBS Blog" image="/images/content/banner/rechtliches_437198485.webp">
        <Head>
            <title>Blog</title>
        </Head>

        <div class="limiter flex vertical" style="padding: 0">
            <div class="article-grid">
                <Card class="article-card" v-for="post in posts" cover
                    aspect-ratio="2.5"
                    :key="post.id"
                    :name="post.title"
                    :primary-tag="post.category.name"
                    :tags="post.tags"
                    :image="post.image"
                    :link="route('blog.article', [post.category.slug, post.slug])"
                />
            </div>
        </div>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import PostInterface from '@/Interfaces/Wiki/Post.js'
    import { computed } from 'vue'

    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import Tag from '@/Components/Form/Tag.vue'
    import Card from '@/Components/Page/Card.vue'

    const props = defineProps({
        posts: Array,
    })

    const posts_ = computed(() => props.posts)
    const posts = computed(() => posts_.value.map(post => new PostInterface(post)))
</script>

<style lang="sass" scoped>
    .article-grid
        display: grid
        grid-template-columns: repeat(2, 1fr)
        grid-auto-rows: auto
        gap: 2rem

    .article-card
        &:first-of-type
            grid-column: 1 / 3
            
            

    @media screen and (max-width: 900px)
        .article-grid
            grid-template-columns: 1fr
            gap: 2rem

        .article-card
            &:first-of-type
                grid-column: 1 / 2
</style>