<template>
    <WikiLayout :categories="categories" title="Firmenwiki">
        <Head>
            <title>Firmenwiki – FDBS Wiki</title>
        </Head>

        <div class="grid margin-bottom-4">
            <Card v-for="post in posts" cover
                aspect-ratio="16/9"
                :key="post.id"
                :name="post.title"
                :image="post.image"
                :color="post.category.color"
                :primary-tag="post.category.name"
                :tags="post.tags"
                :link="route('wiki.entry', [post.category.slug, post.slug])"
            />
        </div>
    </WikiLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import PostInterface from '@/Interfaces/Wiki/Post.js'
    import { computed } from 'vue'

    import WikiLayout from '@/Layouts/Wiki.vue'
    import Card from '@/Components/Page/Card.vue'

    const props = defineProps({
        categories: Array,
        posts: Array,
    })

    const posts_ = computed(() => props.posts)
    const posts = computed(() => posts_.value.map(post => new PostInterface(post)))
</script>

<style lang="sass" scoped>
    .grid
        display: grid
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr))
        gap: 2rem
</style>