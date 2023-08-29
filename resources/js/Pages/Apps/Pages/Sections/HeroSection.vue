<template>
    <component :is="LimiterManifest.component" class="he-background-image" :size="size" :style="`background-image: url(${image})`">
        <h1 :style="'color:'+titleColor">{{ title }}</h1>
    </component>
</template>

<script setup>
    import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'



    defineProps({
        size: String,
        title: String,
        titleColor: {
            type: String,
            default: 'var(--color-heading)',
        },
        image: {
            type: String,
            default: '',
        },
    })
</script>

<style lang="sass" scoped>
    .he-background-image
        background-color: var(--color-background-soft)
        color: var(--color-heading)
        background-size: cover
        background-position: center
        background-repeat: no-repeat
        height: 300px
        display: flex
        align-items: center
        justify-content: center

        h1
            font-size: 3rem
            font-weight: 700
</style>