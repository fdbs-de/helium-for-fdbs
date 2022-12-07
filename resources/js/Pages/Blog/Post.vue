<template>
    <GuestLayout>
        <Head>
            <title>{{post.title}}</title>
        </Head>
    
        <div class="limiter">
            <img class="article-hero-image" :src="post.image" :alt="post.title">
        </div>
        <div class="limiter text-limiter">
            <div class="flex vertical gap-1 padding-block-3">
                <h1>{{post.title}}</h1>
                <div class="flex gap-1 v-center">
                    <span v-if="post.category">{{post.category.name}}</span>
                    <span v-if="post.category">•</span>
                    <span>{{ $dayjs(post.created_at).format('D. MMMM YYYY') }}</span>
                </div>
            </div>
        </div>
        <div class="limiter text-limiter" v-html="post.content"></div>
        <div class="margin-bottom-4"></div>
    </GuestLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import GuestLayout from '@/Layouts/Guest.vue'

    const props = defineProps({
        post: Object,
    })
</script>

<style lang="sass" scoped>
    .article-hero-image
        width: 100%
        aspect-ratio: 2.5
        object-fit: cover
        object-position: center
        margin-top: calc(var(--height-header) + 1rem)
        border-radius: var(--radius-l)

    h1
        margin: 0
</style>