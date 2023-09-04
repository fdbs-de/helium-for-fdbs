<template>
    <section class="he-section he-text-section" :style="{padding, backgroundColor, color}">
        <component class="he-text-section-limiter" :is="LimiterManifest.component" :size="size">
            <div class="he-richtext formatted-content" v-html="content"></div>
        </component>
    </section>
</template>

<script setup>
    import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'
    
    
    
    defineProps({
        size: String,
        content: String,
        padding: String,
        backgroundColor: String,
        color: String,
    })
</script>

<style lang="sass" scoped>
</style>