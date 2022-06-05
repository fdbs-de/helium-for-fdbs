<template>
    <li :class="{'has-dropdown': hasDropdown, 'active': isActive}">
        <Link :href="href">{{label}}</Link>
        <ul v-if="hasDropdown">
            <MenuItem v-for="item in children" :key="item.id" :href="item.href" :label="item.label" :children="item.children || []" />
        </ul>
    </li>
</template>

<script setup>
    import MenuItem from '@/Components/Page/Menu/MenuItem.vue'
    import { Link, usePage } from '@inertiajs/inertia-vue3'
    import { computed, ref } from 'vue'

    const props = defineProps({
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

    const hasDropdown = computed(() => {
        return props.children && props.children.length > 0
    })

    const isActive = computed(() => {
        let pageURL = usePage().url.value
        let itemURL = new URL(props.href).pathname

        if (itemURL === '/')
        {
            return pageURL === itemURL
        }
        else
        {
            return pageURL.startsWith(itemURL)
        }
        // console.log(usePage().url.value, )
        // return usePage.url.value == $href
    })
</script>