<template>
    <template v-for="element in elements">
        <component :is="ElementTemplates[element.type].component" v-bind="element.props" />
    </template>
</template>

<script setup>
    import ElementTemplates from '@/Pages/Apps/Pages/ElementTemplates'



    defineProps({
        elements: {
            type: Array,
            default: () => ([]),
        },
        prefetchedData: {
            type: Object,
            default: () => ({}),
        },
    })
</script>

<style lang="sass" scoped>
</style>