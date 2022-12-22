<template>
    <WikiLayout>
        <Head>
            <title>{{post.title}}</title>
        </Head>
        
        <div class="limiter">
            <div class="top-spacer"></div>
            <Link :href="route('wiki')">Zurück</Link>
            <div class="article-hero">
                <img class="article-hero-image" :src="post.image" :alt="post.title">
            </div>
        </div>
        <div class="limiter text-limiter">
            <div class="flex vertical gap-1 padding-block-3">
                <h1>{{post.title}}</h1>
                <div class="flex gap-1 v-center" v-if="post.category">{{post.category.name}}</div>
            </div>
        </div>
        <div class="limiter text-limiter formatted-content" v-html="post.content"></div>
        <div class="margin-bottom-4"></div>
    </WikiLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import WikiLayout from '@/Layouts/Wiki.vue'
    import { ref } from 'vue'

    const props = defineProps({
        post: Object,
    })
</script>

<style lang="sass" scoped>
    .top-spacer
        height: calc(var(--height-header) + 1rem)
    .article-hero
        width: 100%
        height: 300px
        position: relative
        border-radius: var(--radius-l)

    .article-hero-image
        position: absolute
        top: 0
        left: 0
        width: 100%
        height: 100%
        object-fit: cover
        object-position: center
        border-radius: inherit

    h1
        margin: 0
</style>