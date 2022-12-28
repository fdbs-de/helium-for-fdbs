<template>
    <component :is="component" :item="item" :enable-preview="enablePreview" :selection="selection"/>
</template>

<script setup>
    import ImageCardGrid from '@/Components/Form/Card/ImageCardGrid.vue'
    import ImageCardList from '@/Components/Form/Card/ImageCardList.vue'
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
            case 'grid': return ImageCardGrid
            case 'list': return ImageCardList
            default: return ImageCardGrid
        }
    })
</script>