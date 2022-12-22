<template>
    <component :is="component" :item="item" :enable-preview="enablePreview" :selection="selection"/>
</template>

<script setup>
    import IconItemGrid from '@/Components/Form/Posts/IconItemGrid.vue'
    import IconItemList from '@/Components/Form/Posts/IconItemList.vue'
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
            case 'grid': return IconItemGrid
            case 'list': return IconItemList
            default: return IconItemGrid
        }
    })
</script>