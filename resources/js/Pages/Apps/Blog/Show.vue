<template>
    <GuestLayout>
        <Head>
            <title>{{post.title}} – FDBS Blog</title>
        </Head>
    
        <div class="limiter">
            <div class="article-hero">
                <img class="article-hero-image" :style="`height: calc(100% - ${offset}px); top: ${offset}px;`" :src="post.image" :alt="post.title">
            </div>
        </div>
        <div class="limiter text-limiter">
            <div class="flex vertical gap-1 padding-block-3">
                <h1>{{post.title}}</h1>
                <div class="flex gap-1 v-center">
                    <Tag v-if="post.category" :color="post.category.color || 'gray'" :icon="post.category.icon || 'category'">{{post.category.name}}</Tag>
                    <Tag v-if="post.status !== 'published'" color="var(--color-error)">Nicht veröffentlicht</Tag>
                    <Tag v-for="tag in post.tags" :key="tag" color="var(--color-text)" icon="tag">{{tag}}</Tag>
                    <span>{{ $dayjs(post.created_at).format('D. MMMM YYYY') }}</span>
                </div>
            </div>
        </div>
        <div class="limiter text-limiter formatted-content" v-html="post.content"></div>
        <div class="margin-bottom-4"></div>
    </GuestLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import { ref } from 'vue'

    import GuestLayout from '@/Layouts/Guest.vue'
    import Tag from '@/Components/Form/Tag.vue'

    const props = defineProps({
        post: Object,
    })



    const offset = ref(window.pageYOffset)

    window.addEventListener('scroll', () => {
        offset.value = window.pageYOffset
    })

</script>

<style lang="sass" scoped>
    .article-hero
        width: 100%
        aspect-ratio: 2.5
        position: relative
        margin-top: calc(var(--height-header) + 1rem)
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