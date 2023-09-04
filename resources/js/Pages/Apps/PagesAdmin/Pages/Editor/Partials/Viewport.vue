<template>
    <div class="viewport-wrapper">
        <div class="viewport" :style="`max-width: ${tab.breakpoint.width}px`">
            <BlockBuilderCollector :elements="tab.data.content" />

            <small class="flex h-center padding-block-4 user-select-none color-text" v-if="!tab.data.content.length">
                Hier könnte Ihr Inhalt stehen
            </small>
        </div>
    </div>
</template>

<script setup>
    import BlockBuilderCollector from '@/Pages/Apps/Pages/Renderer/BlockBuilderCollector.vue'



    const props = defineProps({
        tab: {
            type: Object,
            required: true,
        },
    })
</script>

<style lang="sass" scoped>
    .viewport-wrapper
        display: flex
        flex-direction: column
        align-items: center
        padding: 1rem

        .viewport
            width: 100%
            max-height: 80vh
            overflow: auto
            background: white
            border: 1px solid var(--color-background-soft)
            border-radius: var(--radius-s)
            box-shadow: var(--shadow-elevation-low)
</style>