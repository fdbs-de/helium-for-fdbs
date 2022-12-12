<template>
    <component :is="component" :item="item" :enable-preview="enablePreview" :selection="selection"/>
</template>

<script setup>
    import DirectoryItemGrid from '@/Components/Form/MediaLibrary/DirectoryItemGrid.vue'
    import { computed } from 'vue'

    const props = defineProps({
        item: {
            type: Object,
            required: true,
        },
        layout: {
            type: String,
            default: 'grid',
        },
        enablePreview: {
            type: Boolean,
            default: false,
        },
        selection: {
            type: Array,
            default: () => [],
        },
    })

    const component = computed(() => {
        switch (props.layout)
        {
            case 'grid': return DirectoryItemGrid
            case 'list': return DirectoryItemGrid
            default: return DirectoryItemGrid
        }
    })
</script>