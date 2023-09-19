<template>
    <AuthenticatedLayout :title="title">
        <h1><span>{{ title }}</span></h1>
        <div class="limiter">
            <div class="flex vertical padding-block-6">
                <slot />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import { Head, Link, usePage } from '@inertiajs/inertia-vue3'
    import AuthenticatedLayout from '@/Layouts/Authenticated.vue'

    defineProps({
        title: String,
    })
</script>

<style lang="sass" scoped>
h1
    border-top: 3px solid var(--color-primary)
    margin: 0
    font-size: .9rem
    text-align: center
    color: var(--color-background)
    overflow: hidden

    span
        display: inline-flex
        align-items: center
        background: var(--color-primary)
        padding: 0 2rem 3px
        min-height: 1.5rem
        border-radius: 0 0 var(--radius-m) var(--radius-m)
        position: relative

        &::before,
        &::after
            content: ''
            position: absolute
            top: 0
            width: 1rem
            height: 1rem
            background: transparent
            pointer-events: none

        &::before
            right: 100%
            border-radius: 0 var(--radius-m) 0 0
            box-shadow: .5rem -.5rem 0 var(--color-primary)

        &::after
            left: 100%
            border-radius: var(--radius-m) 0 0 0
            box-shadow: -.5rem -.5rem 0 var(--color-primary)
</style>