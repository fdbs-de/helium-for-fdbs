<template>
    <WikiLayout :categories="categories" :posts="posts" title="Firmenwiki">
        <Head>
            <title>Firmenwiki – FDBS Wiki</title>
        </Head>

        <div class="grid margin-bottom-4">
            <Card v-for="post in posts" cover tag-position="beneath-image"
                aspect-ratio="2"
                :key="post.id"
                :image="post.image"
                :color="post.category.color"
                :primary-tag="post.category.name"
                :effect="post.status !== 'published'"
                :link="route('wiki.entry', [post.category.slug, post.slug])"
                :warning="post.status !== 'published' ? 'Dieser Eintrag ist nicht veröffentlicht. Du hast die Berechtigungen, ihn trotzdem zu sehen.' : ''"
            >
            <div class="flex-1 flex wrap vertical">
                <h2 style="font-size: 1.25rem; margin: 0;">{{ post.title }}</h2>
                <div class="spacer"></div>
                <small style="margin-top: .5rem" v-if="post.tags.length">{{ post.tags.map(tag => '#'+tag).join(' ') }}</small>
            </div>
            </Card>
        </div>
    </WikiLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import PostInterface from '@/Interfaces/Wiki/Post.js'
    import { computed } from 'vue'

    import WikiLayout from '@/Layouts/Wiki.vue'
    import Card from '@/Components/Page/Card.vue'
    import Tag from '@/Components/Form/Tag.vue'

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