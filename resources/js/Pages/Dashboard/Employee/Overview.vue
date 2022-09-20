<template>
    <Head title="Intranet" />

    <DashboardSubLayout title="FDBS Intranet">
        <template #head>
            <Link class="icon-button" :href="route('dashboard.employee.documents')">
                <div class="icon">draft</div>
                <div class="button-divider"></div>
                <div class="text">Dokumente</div>
            </Link>
    
            <a class="icon-button" v-if="leitbild" target="_blank" :href="route('docs', leitbild.slug)">
                <div class="icon">explore</div>
                <div class="button-divider"></div>
                <div class="text">{{leitbild.name}}</div>
            </a>
    
            <a class="icon-button" v-if="organigramm" target="_blank" :href="route('docs', organigramm.slug)">
                <div class="icon">lan</div>
                <div class="button-divider"></div>
                <div class="text">{{organigramm.name}}</div>
            </a>
    
            <a class="icon-button" target="_blank" href="https://fleischer-dienst.uweb2000.de">
                <div class="icon">school</div>
                <div class="button-divider"></div>
                <div class="text">Uweb Schulungen</div>
            </a>
        </template>

        <div class="posts-container" v-if="posts.length">
            <h2 class="margin-0 margin-top-3 text-align-center">News und Termine</h2>
            <article class="post-wrapper" v-for="post in posts" :key="post.id">
                <Tag v-if="post.pinned" class="pinned" icon="push_pin" color="green" label="Angepinnt"/>
                <div class="info-group">
                    <h3 class="title">{{post.title}}</h3>
                    <time class="date" :datetime="post.created_at">{{$dayjs(post.created_at).format('DD. MMM YYYY')}}</time>
                </div>
                <p class="text">{{post.content}}</p>
            </article>
        </div>
    </DashboardSubLayout>
</template>

<script setup>
    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import Card from '@/Components/Page/Card.vue'
    import Tag from '@/Components/Form/Tag.vue'

    defineProps({
        leitbild: Object,
        organigramm: Object,
        posts: Array,
    })
</script>

<style lang="sass" scoped>
    .icon-button
        background: var(--color-background)
        flex: 1
        display: flex
        padding: 1rem
        gap: 1rem
        align-items: center
        border-radius: var(--radius-m)
        color: var(--color-heading)
        transition: all 200ms

        &:hover,
        &:focus
            color: var(--color-primary)
            box-shadow: var(--shadow-elevation-medium)

        .icon
            font-family: var(--font-icon)
            font-size: 2rem
            user-select: none
            aspect-ratio: 1
            line-height: 1.2
            height: 2.4rem
            display: flex
            align-items: center
            justify-content: center
            color: var(--color-primary)

        .button-divider
            height: 100%
            border-right: 1px solid currentColor
            opacity: .2

        .text
            font-family: var(--font-heading)
            font-size: 1.15rem

    .posts-container
        padding-top: 1rem
        gap: 2rem
        display: flex
        flex-direction: column

        .post-wrapper
            display: flex
            align-items: flex-start
            flex-direction: column
            border-radius: var(--radius-m)
            gap: 1rem
            padding: 1rem
            background: var(--color-background-soft)

            .pinned
                display: inline-flex

            .title
                margin: 0

            .date
                margin: 0
                font-size: .9rem

            .text
                margin: 0
                max-width: 800px

    @media only screen and (max-width: 500px)
        .posts-container
            padding: 2rem 0 0
</style>                    