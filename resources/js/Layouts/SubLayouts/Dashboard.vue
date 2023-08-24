<template>
    <AuthenticatedLayout :title="title">
        <div id="hero-section">
            <div class="limiter">
                <div class="hero-card">
                    <h1>{{ title }}</h1>
                </div>
            </div>
        </div>

        <section id="content-section">
            <div class="limiter">
                <div class="main-card">
                    <div class="dashboard-nav-bar" v-if="$slots.head">
                        <slot name="head"/>
                    </div>
                    <slot />

                    <div class="fab" v-if="$slots.fab">
                        <slot name="fab" />
                    </div>
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>

<script setup>
    import { Head, Link, usePage } from '@inertiajs/inertia-vue3'
    import AuthenticatedLayout from '@/Layouts/Authenticated.vue'

    defineProps({
        title: String,
        area: String,
    })
</script>

<style lang="sass" scoped>
    #hero-section
        .hero-card
            text-align: center
            background: var(--color-background)
            border-radius: var(--radius-l)
            box-shadow: var(--shadow-elevation-low)
            padding: 1rem
            height: 8rem
            display: flex
            align-items: center
            justify-content: center

            h1
                font-size: 1.5rem

    #content-section
        margin: 2rem 0

        .main-card
            display: flex
            flex-direction: column

            .checkbox
                --mui-background: var(--color-background)

            .dashboard-nav-bar
                display: flex
                flex-wrap: wrap
                align-items: center
                gap: 1rem
                padding: 1rem
                border-radius: var(--radius-l)
                background: var(--color-background)
                box-shadow: var(--shadow-elevation-low)
                --mui-background: var(--color-background-soft)
                position: relative

                > a
                    height: 2.5rem
                    font-size: .8rem
                    letter-spacing: .05rem
                    font-weight: 600
                    text-transform: uppercase
                    color: var(--color-text)
                    border-radius: calc(var(--su) * .5)
                    padding-inline: 1rem
                    display: flex
                    align-items: center
                    cursor: pointer
                    user-select: none

                    &:hover,
                    &:focus
                        background: var(--color-background-soft)
                        color: var(--color-heading)

                    &.active
                        background: var(--color-primary)
                        color: var(--color-background)

        .fab
            position: fixed
            bottom: 3rem
            right: 3rem
            z-index: 1000

    @media only screen and (max-width: 900px)
        #content-section
            margin: 1rem 0

            .main-card
                .dashboard-nav-bar
                    flex-direction: column
                    align-items: flex-start
                    gap: 1rem
</style>