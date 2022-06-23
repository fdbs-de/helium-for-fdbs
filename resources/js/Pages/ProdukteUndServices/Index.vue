<template>
    <TextSubLayout title="Unsere Produkte und Services">
        <Head>
            <title>Unsere Produkte & Services</title>
        </Head>
        <div class="grid">
            <Link class="item" :href="route('angebote')">
                <img src="/images/content/test_banner.jpg">
            </Link>

            <Link class="item" :href="route('foodservice')">
                <img src="/images/content/test_banner.jpg">
            </Link>

            <Link class="item" :href="route('unsere-marken')">
                <img src="/images/content/test_banner.jpg">
            </Link>

            <Link class="item" :href="route('fachberatung-kaese-und-salate')">
                <img src="/images/content/test_banner.jpg">
            </Link>

            <Link class="item" :href="route('marketing-und-kommunikation')">
                <img src="/images/content/test_banner.jpg">
            </Link>

            <Link class="item" :href="route('technischer-kundendienst')">
                <img src="/images/content/test_banner.jpg">
            </Link>

            <Link class="item" :href="route('seminare')">
                <img src="/images/content/test_banner.jpg">
            </Link>
        </div>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
</script>

<style lang="sass" scoped>
    .grid
        display: grid
        gap: 3rem
        margin-top: 3rem
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr))

        .item
            display: flex
            position: relative
            aspect-ratio: 3/2
            border-radius: 8px
            overflow: hidden
            background: var(--color-background-soft)

            &:hover,
            &:focus
                img
                    transform: scale(1.1)
            img
                border-radius: 0
                position: absolute
                top: 0
                left: 0
                width: 100%
                height: 100%
                object-fit: cover
                transition: all 200ms
</style>