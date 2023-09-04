<template>
    <section class="he-section he-download-manager-section" :style="{ padding, backgroundColor, }">
        <component :is="LimiterManifest.component" :size="size">
            <FormBuilder :form-id="formId" />
        </component>
    </section>
</template>

<script setup>
    import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'
    import FormBuilder from '@/Components/Apps/Forms/Frontend/Form.vue'
    
    
    
    defineProps({
        size: String,
        formId: [String, Number],
        padding: String,
        backgroundColor: String,
    })
</script>