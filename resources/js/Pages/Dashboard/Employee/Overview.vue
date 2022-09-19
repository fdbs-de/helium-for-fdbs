<template>
    <Head title="Intranet" />

    <DashboardSubLayout title="FDBS Intranet">
        <div class="grid">
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
        </div>
        <div class="posts-container">
            <article class="post-wrapper">
                <Tag class="pinned" icon="push_pin" color="gray" label="Angepinnt"/>
                <div class="info-group">
                    <h3 class="title">Neue Mitarbeiter zum 01.10.2022</h3>
                    <time class="date" datetime="2022-10-01">01. Okt 2022</time>
                </div>
                <p class="text">
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                    Unde asperiores eos eaque deleniti veritatis ea nemo, accusantium
                    ratione expedita repellat facere dolores error ipsam, laboriosam
                    similique! Modi reiciendis iure nostrum?
                </p>
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
    })
</script>

<style lang="sass" scoped>
    .grid
        display: grid
        gap: 2rem
        padding: 2rem
        border-bottom: 1px solid #00000020
        border-radius: calc(var(--su) * 0.75) calc(var(--su) * 0.75) 0 0
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr))

    .icon-button
        background: var(--color-background)
        display: flex
        padding: 1rem
        gap: 1rem
        align-items: center
        border-radius: var(--radius-m)
        border: 1px solid #00000020
        color: var(--color-heading)
        transition: all 200ms

        &:hover
            color: var(--color-primary)
            border-color: transparent
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
        padding: 2rem 2rem 0rem
        gap: 2rem
        display: flex
        flex-direction: column

        .post-wrapper
            display: flex
            align-items: flex-start
            flex-direction: column
            border-bottom: 1px solid #00000020
            gap: 1rem
            padding: 0 0 2rem

            &:last-child
                border-bottom: none

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
        .grid
            padding: 1rem
            gap: 1rem
            grid-template-columns: auto

        .posts-container
            padding: 2rem 1rem 0
</style>                    