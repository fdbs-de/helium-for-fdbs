<template>
    <section class="he-section he-hero-section" :style="{ height, padding, backgroundColor, backgroundImage, }">
        <component :is="LimiterManifest.component" class="he-hero-section-limiter" :size="size">
            <h1 v-if="title" :style="{color, textAlign}">{{ title }}</h1>
        </component>
    </section>
</template>

<script setup>
    import { computed } from 'vue'

    import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'



    const props = defineProps({
        size: String,
        title: String,
        height: String,
        padding: String,
        backgroundColor: String,
        backgroundImage: String,
        color: String,
        textAlign: String,
    })

    const backgroundImage = computed(() => {
        return props.backgroundImage ? `url(${props.backgroundImage})` : null
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