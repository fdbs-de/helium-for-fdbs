<template>
    <Limiter is="section" :size="size">
        <div class="he-richtext formatted-content" v-html="content"></div>
    </Limiter>
</template>

<script setup>
    import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'
    
    
    
    defineProps({
        size: String,
        content: String,
    })
    


    const Limiter = LimiterManifest.component
</script>