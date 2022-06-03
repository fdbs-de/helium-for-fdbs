<template>
    <ul>
        <MenuItem v-for="(item, i) in items" :key="i" :href="item.href" :label="item.label" :children="item.children || []" />
    </ul>
</template>

<script setup>
    import MenuItem from '@/Components/Page/Menu/MenuItem.vue'

    defineProps({
        items: {
            type: [Array],
            default: '#'
        },
    })
</script>