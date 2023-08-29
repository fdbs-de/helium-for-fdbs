<template>
    <component :is="LimiterManifest.component" :size="size">
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