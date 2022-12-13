<template>
    <div class="breadcrumbs">
        <div class="root-crumb">
            <button class="breadcrumb root-button" @click="$emit('open', basePath.path)">
                <div class="icon">{{basePath.icon}}</div>
                <div class="label">{{basePath.label}}</div>
            </button>
            <VDropdown placement="bottom-end">
                <button class="breadcrumb root-chevron" v-tooltip="'Stammordner wechseln'">
                    <div class="icon">expand_more</div>
                </button>
                <template #popper>
                    <div class="flex padding-1 vertical">
                        <mui-button class="dropdown-button" variant="text" label="Öffentlich" icon-left="public" @click="$emit('open', 'public/media')"/>
                        <mui-button class="dropdown-button" variant="text" label="Privat" icon-left="lock" @click="$emit('open', 'private/media')"/>
                    </div>
                </template>
            </VDropdown>
        </div>
        
        <button class="breadcrumb chevron" v-for="breadcrumb in breadcrumbs" :key="breadcrumb.path" @click="$emit('open', breadcrumb.path)">
            <div class="label">{{ breadcrumb.label }}</div>
        </button>
    </div>
</template>

<script setup>
    import { computed } from 'vue'

    const props = defineProps({
        path: {
            type: String,
            required: true,
        },
        basePaths: {
            type: Array,
            required: true,
        },
    })



    const startsWithBasePath = (path) => {
        return props.basePaths.some(p => path.startsWith(p.path))
    }



    const basePath = computed(() => {
        return props.basePaths.find(p => props.path.startsWith(p.path)) || {path: '', label: '', icon: ''}
    })

    const breadcrumbs = computed(() => {
        let path = props.path
        let basePath = props.basePaths.find(p => path.startsWith(p.path)).path

        // Return empty array if path does not start with a base path
        if (!startsWithBasePath(path)) return []

        // Remove leading base paths
        path = path.substring(basePath.length)

        // Remove leading slash
        let breadcrumbs = path.split('/').filter(p => p !== '') || []

        // Create all breadcrumbs from path
        return breadcrumbs.reduce((acc, currentCrumb, i) => {
            let path = acc[i - 1]?.path ? (acc[i - 1].path + '/' + currentCrumb) : (basePath + '/' + currentCrumb)

            acc.push({path, label: currentCrumb})

            return acc
        }, [])

    })
</script>

<style lang="sass" scoped>
    .breadcrumbs
        display: flex
        align-items: center
        gap: 2rem
        user-select: none

        .root-crumb
            display: flex
            align-items: center

        .breadcrumb
            height: 2.5rem
            background: transparent
            border: none
            display: flex
            gap: .5rem
            padding: 0 1rem
            border-radius: var(--radius-m)
            align-items: center
            margin: 0
            cursor: pointer
            font-size: .9rem
            color: var(--color-text)
            font-family: inherit
            position: relative
            border: 1px solid var(--color-border)

            .icon
                font-family: var(--font-icon)
                font-size: 1.25rem

            &:hover
                color: var(--color-heading)
                border-color: transparent
                background: var(--color-background)
                box-shadow: var(--shadow-elevation-low)

            &.chevron::after
                content: '/'
                position: absolute
                top: 50%
                left: -1rem
                color: #00000070
                transform: translate(-50%, -50%)
                user-select: none
                pointer-events: none

            &.root-button,
            &.root-chevron
                border: none
                background: var(--color-background)
                box-shadow: var(--shadow-elevation-low)

            &.root-chevron
                padding: 0 .25rem
                border-left: 1px solid var(--color-border)
                border-top-left-radius: 0
                border-bottom-left-radius: 0

            &.root-button
                width: 130px
                border-top-right-radius: 0
                border-bottom-right-radius: 0
</style>