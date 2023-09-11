<template>
    <template v-for="element in elements">
        <component :is="ElementTemplates[element.type].component" v-bind="formatProps(element.props)" :prefetched-data="prefetchedData"/>
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

    function formatProps(props) {
        return props.reduce((acc, prop) => {
            acc[prop.key] = prop.value
            return acc
        }, {})
    }
</script>

<style lang="sass" scoped>
</style>