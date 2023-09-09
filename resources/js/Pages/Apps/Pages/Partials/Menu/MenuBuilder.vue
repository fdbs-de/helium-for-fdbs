<template>
    <ul>
        <MenuItem v-for="(item, i) in items" :key="i" :href="item.href" :title="item.title" :children="item.children || []" />
    </ul>
</template>

<script setup>
    import MenuItem from '@/Pages/Apps/Pages/Partials/Menu/MenuItem.vue'

    defineProps({
        items: {
            type: Array,
            default: '#'
        },
    })
</script>