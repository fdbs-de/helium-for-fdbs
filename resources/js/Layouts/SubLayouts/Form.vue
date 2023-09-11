<template>
    <GuestLayout>
        <main>
            <section id="hero-section">
                <h1>{{title}}</h1>
            </section>
            <section id="content-section">
                <form @submit.prevent="$emit('submit')" :class="{'no-padding': noPadding, 'no-gap': noSpacing}">
                    <ValidationErrors />

                    <div v-if="status">
                        {{ status }}
                    </div>

                    <slot />
                </form>
            </section>
        </main>
    </GuestLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import { defineEmits } from 'vue'
    
    import GuestLayout from '@/Layouts/Guest.vue'
    import ValidationErrors from '@/Components/ValidationErrors.vue'

    defineProps({
        title: String,
        status: String,
        noPadding: {
            type: Boolean,
            default: false,
        },
        noSpacing: {
            type: Boolean,
            default: false,
        },
    })

    const emit = defineEmits(['submit'])
</script>

<style lang="sass" scoped>
    #hero-section
        display: flex
        align-items: center
        justify-content: center
        padding-bottom: var(--height-header)
        height: calc(350px + var(--height-header))
        background: var(--color-background-soft)

        h1
            color: var(--color-primary)
            font-weight: 700

    #content-section
        form
            width: 100%
            max-width: 500px
            margin: 0 auto var(--height-header)
            transform: translateY(calc(-1 * var(--height-header)))
            padding: 2rem
            gap: 2rem
            background: var(--color-background)
            border-radius: var(--radius-l)
            box-shadow: var(--shadow-elevation-low)
            display: flex
            flex-direction: column

            --mui-background: var(--color-background-soft)

            &.no-padding
                padding: 0 !important

            &.no-gap
                gap: 0 !important

    @media only screen and (max-width: 500px)
        #hero-section
            padding-bottom: 0
            height: 250px

        #content-section
            form
                border-radius: 0
                box-shadow: none
                margin-bottom: 2rem
                transform: none
                padding-inline: 1rem
                gap: 1.25rem
</style>