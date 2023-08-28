<template>
    <Limiter is="section" :size="size">
        <DownloadManager class="radius-m border" :media-id="mediaId" />
    </Limiter>
</template>

<script setup>
    import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'
    import DownloadManagerManifest from '@/Pages/Apps/Pages/Partials/DownloadManager.manifest.js'
    
    
    
    defineProps({
        size: String,
        mediaId: [String, Number],
    })
    


    const Limiter = LimiterManifest.component
    const DownloadManager = DownloadManagerManifest.component
</script>