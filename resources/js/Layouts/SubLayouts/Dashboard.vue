<template>
    <GuestLayout>
        <main>
            <section id="hero-section">
                <h1>{{title}}</h1>
            </section>
            <section id="content-section">
                <div class="limiter">
                    <slot />
                </div>
            </section>
        </main>
    </GuestLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import GuestLayout from '@/Layouts/Guest.vue'

    defineProps({
        title: String,
    })
</script>

<style lang="sass" scoped>
    #hero-section
        display: flex
        align-items: center
        justify-content: center
        margin-top: var(--height-header)
        padding-bottom: var(--height-header)
        height: calc(350px + var(--height-header))
        background: var(--color-background-soft)

        h1
            color: var(--color-primary)

    #content-section
        .limiter
            --mui-background: var(--color-background-soft)

            .checkbox
                --mui-background: var(--color-background)

    @media only screen and (max-width: 500px)
        #hero-section
            padding-bottom: 0
            height: 250px
</style>