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
                    :primary-tag="$dayjs(post.created_at).format('D. MMMM YYYY')"
                    :tags="post.category ? [post.category.name] : null"
                    :image="post.image || 'https://images.unsplash.com/photo-1605106325682-3482f7c1c9c4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=663&q=80'"
                    :link="post.slug ? route('blog.article', {'post': post.slug}) : '#'"
                />
            </div>
        </div>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import Tag from '@/Components/Form/Tag.vue'
    import Card from '@/Components/Page/Card.vue'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'

    const props = defineProps({
        posts: Array,
    })
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