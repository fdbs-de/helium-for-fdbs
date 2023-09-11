<template>
    <li :class="{'has-dropdown': hasDropdown, 'active': isActive}">
        <Link :href="href">{{title}}</Link>
        <ul v-if="hasDropdown">
            <MenuItem v-for="(item, i) in children" :key="item.title+i" :href="item.href" :title="item.title" :children="item.children || []" />
        </ul>
    </li>
</template>

<script setup>
    import { computed, ref } from 'vue'
    import { Link, usePage } from '@inertiajs/inertia-vue3'
    
    import MenuItem from '@/Pages/Apps/Pages/Partials/Menu/MenuItem.vue'



    const props = defineProps({
        href: {
            type: [String, Object],
            default: '#'
        },
        title: {
            type: String,
            default: ''
        },
        children: {
            type: Array,
            default: () => []
        }
    })

    const hasDropdown = computed(() => {
        return props.children && props.children.length > 0
    })

    const isActive = computed(() => {
        let pageURL = usePage().url.value

        let itemURL = new URL(props.href, window.location).pathname

        if (itemURL === '/')
        {
            return pageURL === itemURL
        }
        else
        {
            return pageURL.startsWith(itemURL)
        }
    })
</script>