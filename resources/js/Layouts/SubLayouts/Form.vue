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
    import GuestLayout from '@/Layouts/Guest.vue'
    import ValidationErrors from '@/Components/ValidationErrors.vue'
    import { defineEmits } from 'vue'

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
        margin-top: var(--height-header)
        padding-bottom: var(--height-header)
        height: calc(350px + var(--height-header))
        background: var(--color-background-soft)

        h1
            color: var(--color-primary)

    #content-section
        form
            width: 100%
            max-width: 500px
            margin: 0 auto var(--height-header)
            transform: translateY(calc(-1 * var(--height-header)))
            padding: calc(var(--su) * 2)
            gap: calc(var(--su) * 2)
            background: var(--color-background)
            border-radius: calc(var(--su) * .75)
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
                margin-bottom: calc(var(--su) * 2)
                transform: none
                padding-inline: var(--su)
                gap: calc(var(--su) * 1.25)
</style>