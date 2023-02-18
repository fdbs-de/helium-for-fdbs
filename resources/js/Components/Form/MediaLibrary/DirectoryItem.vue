<template>
    <component :is="component" :item="item" :enable-preview="enablePreview" :selection="selection" :show-actions="showActions"/>
</template>

<script setup>
    import DirectoryItemGrid from '@/Components/Form/MediaLibrary/DirectoryItemGrid.vue'
    import DirectoryItemList from '@/Components/Form/MediaLibrary/DirectoryItemList.vue'
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
        showActions: {
            type: Boolean,
            default: true,
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
            case 'list': return DirectoryItemList
            default: return DirectoryItemGrid
        }
    })
</script>