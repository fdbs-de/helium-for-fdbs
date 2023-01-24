<template>
    <WikiLayout :backlink="route('wiki')" backlink-text="Zurück zur Übersicht" :title="post.title" :image="post.image">
        <Head>
            <title>{{post.title}} – FDBS Wiki</title>
        </Head>

        <div class="card padding-block-2">
            <div class="limiter text-limiter">
                <div class="flex vertical gap-1 padding-block-1">
                    <div class="flex gap-1 v-center" v-if="post.category || post.tags">
                        <Tag v-if="post.category" :style="'color: '+post.category.color || 'gray'" :icon="post.category.icon || 'category'">{{post.category.name}}</Tag>
                        <Tag v-for="tag in post.tags" :key="tag" style="color: var(--color-text);" icon="tag">{{tag}}</Tag>
                    </div>
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
</style>