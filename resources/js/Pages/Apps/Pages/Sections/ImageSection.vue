<template>
    <section class="he-section he-image-section" :style="{padding, backgroundColor}">
        <component class="he-image-section-limiter" :is="LimiterManifest.component" :size="size">
            <a :href="link" style="display: contents;">
                <img class="content-image" :style="{height, objectFit}" :src="src" :alt="alt" />
            </a>
        </component>
    </section>
</template>

<script setup>
    import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'
    
    
    
    defineProps({
        size: String,
        src: String,
        alt: String,
        link: String,
        height: String,
        padding: String,
        backgroundColor: String,
        objectFit: String,
    })
</script>

<style lang="sass" scoped>
</style>