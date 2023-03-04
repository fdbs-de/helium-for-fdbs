<template>
    <div class="breadcrumbs">
        <button class="breadcrumb" v-for="breadcrumb in breadcrumbs" :key="breadcrumb.path" @click="$emit('open', breadcrumb)">
            <div class="label">{{ breadcrumb.name }}</div>
        </button>
    </div>
</template>

<script setup>
    import { computed } from 'vue'

    const props = defineProps({
        rootIcon: String,
        rootName: {
            type: String,
            default: 'Storage'
        },
        breadcrumbs: {
            type: Array,
            default: () => []
        },
    })



    const breadcrumbs = computed(() => {
        let breadcrumbs = props.breadcrumbs.map(e => {
            return {
                id: e.id,
                path: e.path,
                name: getName(e.path)
            }
        })

        if (breadcrumbs.length > 0) breadcrumbs[0].name = props.rootName
        
        return breadcrumbs
    })

    const getName = (path) => {
        const parts = path.split('/')
        return parts[parts.length - 1]
    }
</script>

<style lang="sass" scoped>
    .breadcrumbs
        display: flex
        align-items: center
        gap: 2rem
        padding-inline: .5rem
        user-select: none

        .breadcrumb
            background: transparent
            border: none
            display: flex
            align-items: center
            margin: 0
            gap: .5rem
            cursor: pointer
            font-size: 1rem
            color: var(--color-text)
            font-family: inherit
            position: relative
            padding: 0
            border: none

            &:hover
                color: var(--color-primary)

            &:not(.breadcrumb:first-child)::after
                content: 'chevron_right'
                position: absolute
                top: 50%
                left: -1rem
                color: #00000070
                transform: translate(-50%, -50%)
                user-select: none
                pointer-events: none
                font-family: var(--font-icon)

            &:first-child
                font-weight: 500

                &::before
                    content: 'home_storage'
                    user-select: none
                    pointer-events: none
                    font-family: var(--font-icon)
                    font-size: 1.5rem
</style>