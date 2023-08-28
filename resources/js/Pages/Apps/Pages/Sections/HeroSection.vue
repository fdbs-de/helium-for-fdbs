<template>
    <Limiter class="he-background-image" is="section" :size="size">
        <h1 :style="'color:'+titleColor">{{ title }}</h1>
    </Limiter>
</template>

<script setup>
    import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'



    defineProps({
        size: String,
        title: String,
        titleColor: {
            type: String,
            default: 'var(--color-primary)',
        },
        image: String,
    })
    


    const Limiter = LimiterManifest.component
</script>

<style lang="sass" scoped>
    .he-background-image
        background-color: var(--color-background-soft)
        background-image: url('https://images.unsplash.com/photo-1692890846581-da1a95435f34?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2535&q=80')
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