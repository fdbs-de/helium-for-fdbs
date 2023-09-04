<template>
    <section class="he-section he-download-manager-section" :style="{ padding, backgroundColor, }">
        <component :is="LimiterManifest.component" :size="size">
            <component :is="DownloadManagerManifest.component" class="radius-m border" :media-id="mediaId" />
        </component>
    </section>
</template>

<script setup>
    import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'
    import DownloadManagerManifest from '@/Pages/Apps/Pages/Partials/DownloadManager.manifest.js'
    
    
    
    defineProps({
        size: String,
        mediaId: [String, Number],
        padding: String,
        backgroundColor: String,
    })
</script>