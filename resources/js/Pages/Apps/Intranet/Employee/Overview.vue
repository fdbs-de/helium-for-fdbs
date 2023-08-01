<template>
    <Head title="Intranet" />

    <DashboardSubLayout title="News und Termine" area="Intranet">
        <div class="posts-container">
            <!-- <h2 class="margin-0 margin-top-3 text-align-center">News und Termine</h2> -->

            <Calendar :entries="appointments" :groups="['Allgemein', 'Audits', 'Vertrieb', 'Messen']"/>
            
            <article class="post-wrapper" v-for="post in posts" :key="post.id">
                <Tag v-if="post.pinned" class="pinned" icon="push_pin" color="green" label="Angepinnt"/>
                <div class="info-group">
                    <h3 class="title">{{post.title}}</h3>
                    <time class="date" :datetime="post.created_at">{{$dayjs(post.created_at).format('DD. MMM YYYY')}}</time>
                </div>
                <div class="formatted-content" v-html="post.content"></div>
            </article>
        </div>
    </DashboardSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    
    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
    import Calendar from '@/Components/Form/Calendar.vue'
    import Tag from '@/Components/Form/Tag.vue'
    import appointments from '@/Pages/Apps/Intranet/Employee/appointments.json'



    defineProps({
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
            background: var(--color-background)
            box-shadow: var(--shadow-elevation-low)

            .pinned
                display: inline-flex

            .title
                margin: 0

            .date
                margin: 0
                font-size: .9rem

            .formatted-content
                margin: 0
                width: 100%
                max-width: 800px

    @media only screen and (max-width: 500px)
        .posts-container
            padding: 2rem 0 0
</style>                    