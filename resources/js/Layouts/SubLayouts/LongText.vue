<template>
    <GuestLayout>
        <main>
            <section id="hero-section">
                <h1>{{title}}</h1>
            </section>
            <section id="content-section">
                <div class="limiter text-limiter">
                    <slot />
                </div>
            </section>
        </main>
    </GuestLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import GuestLayout from '@/Layouts/Guest.vue'
    import { defineEmits } from 'vue'

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
        height: 300px
        background: var(--color-background-soft)

        h1
            color: var(--color-primary)

    #content-section
        padding-block: 4rem

    @media only screen and (max-width: 500px)
        #hero-section
            height: 200px
</style>