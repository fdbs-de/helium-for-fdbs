<template>
    <div class="card-wrapper">
        <h3 class="title" v-if="title">{{title}}</h3>
        <h3 class="spec" v-if="spec">{{spec}}</h3>
        <h3 class="subtitle" v-if="subtitle">{{subtitle}}</h3>
    </div>
    
</template>

<script setup>
    defineProps({
        title: String,
        spec: String,
        subtitle: String,
    })
</script>

<style lang="sass" scoped>
    .card-wrapper
        display: flex
        flex-direction: column
        align-items: center
        text-align: center
        padding: 2rem
        border-radius: .5rem
        border: 1px solid #e6e6e6
        background-color: var(--color-background)

        h3
            font-size: 1.25rem
            font-weight: 500
            margin: 0

        h3.spec
            color: var(--color-primary)
            font-size: 2rem
            font-weight: 700
</style>