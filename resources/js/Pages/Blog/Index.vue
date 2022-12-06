<template>
    <TextSubLayout title="FDBS Blog" image="/images/content/banner/rechtliches_437198485.webp" has-small-limiter>
        <Head>
            <title>Blog</title>
        </Head>

        <div class="flex vertical">
            <article class="flex vertical gap-1 padding-block-3 border-bottom" v-for="post in posts" :key="post.id">
                <h2 class="margin-0">{{post.title}}</h2>
                <div class="flex gap-1 v-center">
                    <span v-if="post.category">{{post.category.name}}</span>
                    <i v-else>Keine Kategorie</i>
                    <span>•</span>
                    <time class="date" :datetime="post.created_at">{{$dayjs(post.created_at).format('DD. MMM YYYY')}}</time>
                </div>
    
                <div v-html="post.content" class="content"></div>
    
                <Link v-if="post.slug" :href="route('blog.article', {'post': post.slug})" class="button">Weiterlesen</Link>
            </article>
        </div>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'

    const props = defineProps({
        posts: Array,
    })
</script>

<style lang="sass">
    article
        > .content
            display: -webkit-box
            -webkit-line-clamp: 4
            -webkit-box-orient: vertical
            overflow: hidden

            h1, h2, h3, h4, h5, h6
                margin: .35em 0
                font-weight: 500
                color: var(--color-text)

            h1
                font-size: 2rem

            h2
                font-size: 1.5rem

            h3
                font-size: 1.25rem

            h4, h5, h6
                font-size: 1rem

            img
                display: none

</style>