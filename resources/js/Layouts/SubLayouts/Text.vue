<template>
    <GuestLayout>
        <main>
            <section id="hero-section" :class="{'large': largeHero}">
                <div class="limiter">
                    <div class="inner-wrapper" :style="'background-image: url('+(image || '')+')'">
                        <h1 :style="`color: ${color};`" v-if="title">{{title}}</h1>
                    </div>
                </div>
            </section>
            <section id="content-section">
                <div class="limiter" :class="{'text-limiter': hasSmallLimiter}">
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
        image: String,
        color: {
            type: String,
            default: 'var(--color-primary)'
        },
        hasSmallLimiter: {
            type: Boolean,
            default: false
        },
        largeHero: {
            type: Boolean,
            default: false
        },
    })
</script>

<style lang="sass" scoped>
    #hero-section
        display: flex
        margin-top: calc(var(--height-header) + 1rem)

        &.large
            .inner-wrapper
                height: 500px

        .inner-wrapper
            display: flex
            align-items: center
            justify-content: center
            height: 300px
            padding: 0 1rem
            background-color: var(--color-background-soft)
            background-position: center
            background-repeat: no-repeat
            background-size: cover
            border-radius: var(--radius-xl)

        h1
            text-align: center
            font-weight: 700

    #content-section
        padding-block: 4rem

    @media only screen and (max-width: 700px)
        #hero-section
            .inner-wrapper
                height: auto !important
                aspect-ratio: 2/1
</style>