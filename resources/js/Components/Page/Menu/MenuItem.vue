<template>
    <li>
        <Link :href="href" :class="{'active': $page.url == '/'}">{{label}}</Link>
        <ul v-if="children && children.length > 0">
            <MenuItem v-for="(item, i) in children" :key="i" :href="item.href" :label="item.label" :children="item.children || []" />
        </ul>
    </li>
</template>

<script setup>
    import MenuItem from '@/Components/Page/Menu/MenuItem.vue'
    import { Link } from '@inertiajs/inertia-vue3'

    defineProps({
        href: {
            type: [String, Object],
            default: '#'
        },
        label: {
            type: String,
            default: ''
        },
        children: {
            type: Array,
            default: () => []
        }
    })
</script>