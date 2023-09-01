<template>
    <component class="he-text-section" :is="LimiterManifest.component" :size="size">
        <div class="he-richtext formatted-content" v-html="content"></div>
    </component>
</template>

<script setup>
    import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'
    
    
    
    defineProps({
        size: String,
        content: String,
    })
</script>

<style lang="sass" scoped>
    .he-text-section
        padding-block: 4rem
</style>