<template>
    <TextSubLayout title="FDBS Blog" image="/images/content/banner/rechtliches_437198485.webp">
        <Head>
            <title>Unsere Blogbeiträge – FDBS Blog</title>
        </Head>

        <div class="limiter flex vertical" style="padding: 0">
            <div class="article-grid">
                <Card class="article-card" v-for="post in posts" cover
                    aspect-ratio="2.5"
                    tag-position="beneath-image"
                    :key="post.id"
                    :name="post.title"
                    :image="post.image"
                    :color="post.post_category.color"
                    :primary-tag="post.post_category.name"
                    :effect="post.status !== 'published'"
                    :tags="post.tags"
                    :link="route('blog.article', [post.post_category.slug, post.slug])"
                    :warning="post.status !== 'published' ? 'Dieser Eintrag ist nicht veröffentlicht. Du hast die Berechtigungen, ihn trotzdem zu sehen.' : ''"
                />
            </div>
        </div>
    </TextSubLayout>
</template>

<script setup>
    import { Head } from '@inertiajs/inertia-vue3'

    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import Card from '@/Components/Page/Card.vue'

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