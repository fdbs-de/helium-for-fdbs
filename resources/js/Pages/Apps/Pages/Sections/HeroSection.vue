<template>
    <section class="he-section he-hero-section" :style="{ height, padding, backgroundColor, backgroundImage: `url(${backgroundImage})`, }">
        <component :is="LimiterManifest.component" class="he-hero-section-limiter" :size="size">
            <h1 v-if="title" :style="{color, textAlign}">{{ title }}</h1>
        </component>
    </section>
</template>

<script setup>
    import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'



    defineProps({
        size: String,
        title: String,
        height: String,
        padding: String,
        backgroundColor: String,
        backgroundImage: String,
        color: String,
        textAlign: String,
    })
</script>

<style lang="sass" scoped>
    .he-hero-section
        background-size: cover
        background-position: center
        background-repeat: no-repeat
        display: flex
        align-items: center

        h1
            font-size: 3rem
            font-weight: 700
</style>